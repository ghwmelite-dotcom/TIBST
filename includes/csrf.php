<?php
/**
 * CSRF Protection for the TIBST CMS.
 */

/**
 * Generate (or retrieve) a CSRF token stored in the session.
 */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Return an HTML hidden input field containing the CSRF token.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Validate the CSRF token submitted via POST.
 *
 * Terminates with HTTP 403 if the token is missing or invalid.
 * Regenerates the token after successful validation.
 */
function validateCsrf(): void
{
    $submitted = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'] ?? '', $submitted)) {
        http_response_code(403);
        die('Invalid request');
    }

    // Regenerate token after successful validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
