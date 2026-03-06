<?php
/**
 * Admin Layout Header — sidebar, topbar, flash messages.
 *
 * Expected variables before include:
 *   $adminPageTitle  — string shown in topbar and <title>
 *   $adminActivePage — string key matching sidebar nav (e.g. 'dashboard')
 */

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/functions.php';

startSession();
requireAuth();

$user = currentUser();
$initials = implode('', array_map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)), explode(' ', $user['name'])));

if (!isset($adminPageTitle))  $adminPageTitle  = 'Admin';
if (!isset($adminActivePage)) $adminActivePage = '';

$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($adminPageTitle) ?> — TIBST Admin</title>
    <link rel="stylesheet" href="/admin/css/admin.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" defer></script>
</head>
<body>
<div class="admin-wrapper">

    <!-- ─── Sidebar ──────────────────────────────────────────────────── -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <h2>TIB<span>ST</span></h2>
            <small>Admin Panel</small>
        </div>

        <nav class="sidebar-nav">
            <a href="/admin/dashboard.php" class="<?= $adminActivePage === 'dashboard' ? 'active' : '' ?>">
                <span class="nav-icon">&#9649;</span> Dashboard
            </a>
            <a href="/admin/slides.php" class="<?= $adminActivePage === 'slides' ? 'active' : '' ?>">
                <span class="nav-icon">&#9655;</span> Hero Slides
            </a>
            <a href="/admin/programmes.php" class="<?= $adminActivePage === 'programmes' ? 'active' : '' ?>">
                <span class="nav-icon">&#9733;</span> Programmes
            </a>
            <a href="/admin/news.php" class="<?= $adminActivePage === 'news' ? 'active' : '' ?>">
                <span class="nav-icon">&#9998;</span> News &amp; Events
            </a>
            <a href="/admin/testimonials.php" class="<?= $adminActivePage === 'testimonials' ? 'active' : '' ?>">
                <span class="nav-icon">&#10077;</span> Testimonials
            </a>
            <a href="/admin/staff.php" class="<?= $adminActivePage === 'staff' ? 'active' : '' ?>">
                <span class="nav-icon">&#9823;</span> Staff
            </a>
            <a href="/admin/pages.php" class="<?= $adminActivePage === 'pages' ? 'active' : '' ?>">
                <span class="nav-icon">&#9776;</span> Page Content
            </a>
            <a href="/admin/settings.php" class="<?= $adminActivePage === 'settings' ? 'active' : '' ?>">
                <span class="nav-icon">&#9881;</span> Settings
            </a>
            <?php if (isAdmin()): ?>
            <a href="/admin/users.php" class="<?= $adminActivePage === 'users' ? 'active' : '' ?>">
                <span class="nav-icon">&#9731;</span> User Management
            </a>
            <?php endif; ?>

            <div class="sidebar-separator"></div>

            <a href="/admin/profile.php" class="<?= $adminActivePage === 'profile' ? 'active' : '' ?>">
                <span class="nav-icon">&#9786;</span> My Profile
            </a>
        </nav>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar"><?= escape($initials) ?></div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name"><?= escape($user['name']) ?></div>
                <div class="sidebar-user-role"><?= escape(ucfirst($user['role'])) ?></div>
            </div>
        </div>
    </aside>

    <!-- ─── Sidebar Overlay (mobile) ─────────────────────────────────── -->
    <div class="sidebar-overlay"></div>

    <!-- ─── Main Content ─────────────────────────────────────────────── -->
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button id="sidebar-toggle" type="button" aria-label="Toggle sidebar">&#9776;</button>
                <h1><?= escape($adminPageTitle) ?></h1>
            </div>
            <div class="topbar-right">
                <a href="/" target="_blank">View Site</a>
                <span class="topbar-user">
                    <span class="topbar-user-avatar"><?= escape($initials) ?></span>
                    <?= escape($user['name']) ?>
                </span>
                <a href="/admin/logout.php">Logout</a>
            </div>
        </header>

        <main class="admin-content">
            <?php if ($flash): ?>
            <div class="alert alert-<?= escape($flash['type']) ?>">
                <span><?= escape($flash['message']) ?></span>
                <button class="alert-dismiss" type="button">&times;</button>
            </div>
            <?php endif; ?>
