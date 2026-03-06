<?php
/**
 * Admin Logout — destroy session and redirect to login.
 */

require_once __DIR__ . '/../includes/auth.php';

startSession();
logout();
