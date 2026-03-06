<?php
/**
 * Authentication — Session-based auth for the TIBST CMS admin area.
 */

require_once __DIR__ . '/db.php';

/**
 * Start a session with secure cookie parameters.
 * Call this at the top of every page that needs session access.
 */
function startSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_set_cookie_params([
        'httponly'  => true,
        'samesite' => 'Strict',
    ]);

    session_start();
}

/**
 * Attempt to log in a user by email and password.
 *
 * @return bool True on success, false on failure.
 */
function login(string $email, string $password): bool
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_name']  = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role']  = $user['role'];
    $_SESSION['login_time'] = time();

    return true;
}

/**
 * Destroy the current session and redirect to the admin login page.
 */
function logout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();

    header('Location: /admin/index.php');
    exit;
}

/**
 * Check whether a user is currently logged in.
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Require that a user is logged in.  Redirects to the admin login page if not.
 */
function requireAuth(): void
{
    if (!isLoggedIn()) {
        header('Location: /admin/index.php');
        exit;
    }
}

/**
 * Require that the logged-in user has the 'admin' role.
 * Redirects to the dashboard with an error flash if not.
 */
function requireAdmin(): void
{
    requireAuth();

    if ($_SESSION['user_role'] !== 'admin') {
        if (function_exists('flashMessage')) {
            flashMessage('You do not have permission to access that page.', 'error');
        }
        header('Location: /admin/dashboard.php');
        exit;
    }
}

/**
 * Check whether the current user has the 'admin' role.
 */
function isAdmin(): bool
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Return an associative array with the current user's session data.
 *
 * @return array{id: int, name: string, email: string, role: string}|null
 */
function currentUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }

    return [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'],
        'email' => $_SESSION['user_email'],
        'role'  => $_SESSION['user_role'],
    ];
}
