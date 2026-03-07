<?php
/**
 * E-Library User Authentication
 *
 * Restricts access to users with .edu.gov.gh emails (+ exceptions).
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

// Allowed email domains and specific exceptions
define('LIBRARY_ALLOWED_DOMAINS', ['edu.gov.gh']);
define('LIBRARY_ALLOWED_EMAILS', ['oh84dev@gmail.com']);

function isLibraryEmailAllowed(string $email): bool
{
    $email = strtolower(trim($email));

    // Check exceptions first
    if (in_array($email, LIBRARY_ALLOWED_EMAILS, true)) {
        return true;
    }

    // Check domain
    $domain = substr($email, strrpos($email, '@') + 1);
    foreach (LIBRARY_ALLOWED_DOMAINS as $allowed) {
        if ($domain === $allowed || str_ends_with($domain, '.' . $allowed)) {
            return true;
        }
    }

    return false;
}

function libraryRegister(string $email, string $password, string $fullName): bool|string
{
    $email = strtolower(trim($email));

    if (!isLibraryEmailAllowed($email)) {
        return 'Only .edu.gov.gh email addresses are allowed to register.';
    }

    if (strlen($password) < 6) {
        return 'Password must be at least 6 characters.';
    }

    $pdo = getDB();

    // Check if email already exists
    $stmt = $pdo->prepare('SELECT id FROM library_users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return 'An account with this email already exists.';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO library_users (email, password_hash, full_name) VALUES (?, ?, ?)');
    $stmt->execute([$email, $hash, trim($fullName)]);

    return true;
}

function libraryLogin(string $email, string $password): bool
{
    $email = strtolower(trim($email));
    $pdo   = getDB();

    $stmt = $pdo->prepare('SELECT * FROM library_users WHERE email = ? AND is_approved = 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    $_SESSION['library_user'] = [
        'id'    => $user['id'],
        'email' => $user['email'],
        'name'  => $user['full_name'],
    ];

    return true;
}

function isLibraryLoggedIn(): bool
{
    return isset($_SESSION['library_user']);
}

function getLibraryUser(): ?array
{
    return $_SESSION['library_user'] ?? null;
}

function requireLibraryAuth(): void
{
    if (!isLibraryLoggedIn()) {
        header('Location: library.php');
        exit;
    }
}
