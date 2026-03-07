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
            <small>Administration</small>
        </div>

        <nav class="sidebar-nav">
            <a href="/admin/dashboard.php" class="<?= $adminActivePage === 'dashboard' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span> Dashboard
            </a>
            <a href="/admin/slides.php" class="<?= $adminActivePage === 'slides' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"/><polyline points="8 20 16 20"/><line x1="12" y1="18" x2="12" y2="20"/></svg></span> Hero Slides
            </a>
            <a href="/admin/programmes.php" class="<?= $adminActivePage === 'programmes' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></span> Programmes
            </a>
            <a href="/admin/news.php" class="<?= $adminActivePage === 'news' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span> News &amp; Events
            </a>
            <a href="/admin/testimonials.php" class="<?= $adminActivePage === 'testimonials' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span> Testimonials
            </a>
            <a href="/admin/staff.php" class="<?= $adminActivePage === 'staff' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span> Staff
            </a>
            <a href="/admin/applications.php" class="<?= $adminActivePage === 'applications' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span> Applications
            </a>
            <a href="/admin/pages.php" class="<?= $adminActivePage === 'pages' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></span> Page Content
            </a>
            <a href="/admin/settings.php" class="<?= $adminActivePage === 'settings' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></span> Settings
            </a>
            <?php if (isAdmin()): ?>
            <a href="/admin/users.php" class="<?= $adminActivePage === 'users' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span> User Management
            </a>
            <?php endif; ?>

            <div class="sidebar-separator"></div>

            <a href="/admin/profile.php" class="<?= $adminActivePage === 'profile' ? 'active' : '' ?>">
                <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span> My Profile
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
