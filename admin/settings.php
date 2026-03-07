<?php
/**
 * Admin — Site Settings.
 */

$adminPageTitle  = 'Settings';
$adminActivePage = 'settings';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo = getDB();

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $currentSettings = getSettings();
    $submitted = $_POST['settings'] ?? [];

    foreach ($submitted as $key => $value) {
        $stmt = $pdo->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
        $stmt->execute([trim($value), $key]);
    }

    // Handle file uploads (logo & favicon)
    $fileSettings = ['site_logo', 'site_favicon'];
    foreach ($fileSettings as $key) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $path = uploadImage($key);
            if ($path !== false) {
                // Delete old file if it exists
                $oldVal = $currentSettings[$key] ?? '';
                if ($oldVal && file_exists(dirname(__DIR__) . '/' . $oldVal)) {
                    @unlink(dirname(__DIR__) . '/' . $oldVal);
                }
                // Upsert setting
                $stmt = $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
                $stmt->execute([$key, $path]);
            }
        }
    }

    flashMessage('Settings updated.');
    header('Location: /admin/settings.php');
    exit;
}

// Now safe to output HTML
require_once __DIR__ . '/includes/admin-header.php';

$settings = getSettings();
?>

<div class="content-header">
    <h2>Settings</h2>
</div>

<div class="admin-card">
    <form method="POST" enctype="multipart/form-data">
        <?= csrfField() ?>

        <h3 class="form-section-title">Site Branding</h3>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Site Logo</label>
                <?php if (!empty($settings['site_logo'])): ?>
                <div style="margin-bottom: 10px;">
                    <img src="<?= escape($settings['site_logo']) ?>" alt="Current logo" style="max-height: 60px; border-radius: 8px; border: 1px solid #E2E0D8; padding: 6px; background: #fff;">
                </div>
                <?php endif; ?>
                <input type="file" name="site_logo" accept="image/*" class="form-input" style="padding: 8px;">
                <span class="form-hint">Recommended: PNG or SVG with transparent background, at least 200px wide.</span>
            </div>
            <div class="form-group">
                <label class="form-label">Favicon</label>
                <?php if (!empty($settings['site_favicon'])): ?>
                <div style="margin-bottom: 10px;">
                    <img src="<?= escape($settings['site_favicon']) ?>" alt="Current favicon" style="max-height: 40px; border-radius: 6px; border: 1px solid #E2E0D8; padding: 4px; background: #fff;">
                </div>
                <?php endif; ?>
                <input type="file" name="site_favicon" accept="image/*,.ico" class="form-input" style="padding: 8px;">
                <span class="form-hint">Recommended: 32&times;32 or 64&times;64 PNG, ICO, or SVG.</span>
            </div>
        </div>

        <h3 class="form-section-title">Site Information</h3>

        <div class="form-group">
            <label class="form-label">Site Name</label>
            <input type="text" name="settings[site_name]" class="form-input" value="<?= escape($settings['site_name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Site Short Name</label>
            <input type="text" name="settings[site_short_name]" class="form-input" value="<?= escape($settings['site_short_name'] ?? '') ?>">
        </div>

        <h3 class="form-section-title">Contact Information</h3>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="settings[phone]" class="form-input" value="<?= escape($settings['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Mobile</label>
                <input type="text" name="settings[mobile]" class="form-input" value="<?= escape($settings['mobile'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="settings[email]" class="form-input" value="<?= escape($settings['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Address</label>
            <textarea name="settings[address]" class="form-textarea" rows="3"><?= escape($settings['address'] ?? '') ?></textarea>
        </div>

        <h3 class="form-section-title">Social Media</h3>

        <div class="form-group">
            <label class="form-label">Facebook</label>
            <input type="url" name="settings[facebook]" class="form-input" value="<?= escape($settings['facebook'] ?? '') ?>" placeholder="https://facebook.com/...">
        </div>

        <div class="form-group">
            <label class="form-label">Instagram</label>
            <input type="url" name="settings[instagram]" class="form-input" value="<?= escape($settings['instagram'] ?? '') ?>" placeholder="https://instagram.com/...">
        </div>

        <div class="form-group">
            <label class="form-label">LinkedIn</label>
            <input type="url" name="settings[linkedin]" class="form-input" value="<?= escape($settings['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/...">
        </div>

        <div class="form-group">
            <label class="form-label">YouTube</label>
            <input type="url" name="settings[youtube]" class="form-input" value="<?= escape($settings['youtube'] ?? '') ?>" placeholder="https://youtube.com/...">
        </div>

        <div class="form-group">
            <label class="form-label">WhatsApp</label>
            <input type="url" name="settings[whatsapp]" class="form-input" value="<?= escape($settings['whatsapp'] ?? '') ?>" placeholder="https://wa.me/...">
        </div>

        <h3 class="form-section-title">E-Library (Google Drive)</h3>

        <div class="form-group">
            <label class="form-label">Google Drive API Key</label>
            <input type="text" name="settings[gdrive_api_key]" class="form-input" value="<?= escape($settings['gdrive_api_key'] ?? '') ?>" placeholder="AIzaSy...">
            <span class="form-hint">Create one at console.cloud.google.com &rarr; APIs &rarr; Credentials. Enable the Google Drive API.</span>
        </div>

        <div class="form-group">
            <label class="form-label">Google Drive Folder ID</label>
            <input type="text" name="settings[gdrive_folder_id]" class="form-input" value="<?= escape($settings['gdrive_folder_id'] ?? '') ?>" placeholder="e.g. 11FR2Wo7SDOhI30H59agJK-qBE41cYcx3">
            <span class="form-hint">The folder ID from the Google Drive share URL. The folder must be shared as "Anyone with the link can view".</span>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary">Save Settings</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
