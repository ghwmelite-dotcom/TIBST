<?php
/**
 * Admin Login Page
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();

// Already logged in — go to dashboard
if (isLoggedIn()) {
    header('Location: /admin/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } elseif (login($email, $password)) {
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TIBST Admin</title>
    <link rel="stylesheet" href="/admin/css/admin.css">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <div class="login-header">
            <h1>TIB<span>ST</span></h1>
            <p>Administration Panel</p>
        </div>

        <div class="login-form-card">
            <?php if ($error): ?>
                <div class="login-error"><?= escape($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <?= csrfField() ?>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="you@tibst.edu.et"
                        value="<?= escape($_POST['email'] ?? '') ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>

        <div class="login-footer">
            <a href="/">&larr; Back to website</a>
        </div>
    </div>
</div>
</body>
</html>
