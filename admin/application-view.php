<?php
/**
 * Admin Application View — detailed view with status management.
 */

$adminPageTitle  = 'View Application';
$adminActivePage = 'applications';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo = getDB();
$id = (int) ($_GET['id'] ?? 0);

if (!$id) {
    flashMessage('Invalid application ID.', 'error');
    header('Location: /admin/applications.php');
    exit;
}

// Handle status update (must run before admin-header outputs HTML)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && validateCsrf()) {
    $newStatus = $_POST['status'] ?? '';
    $adminNotes = trim($_POST['admin_notes'] ?? '');

    if (in_array($newStatus, ['pending', 'reviewed', 'accepted', 'rejected'])) {
        $stmt = $pdo->prepare('UPDATE applications SET status = ?, admin_notes = ? WHERE id = ?');
        $stmt->execute([$newStatus, $adminNotes, $id]);
        flashMessage('Application status updated to ' . ucfirst($newStatus) . '.', 'success');
        header('Location: /admin/application-view.php?id=' . $id);
        exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM applications WHERE id = ?');
$stmt->execute([$id]);
$app = $stmt->fetch();

if (!$app) {
    flashMessage('Application not found.', 'error');
    header('Location: /admin/applications.php');
    exit;
}

require_once __DIR__ . '/includes/admin-header.php';

$badgeColors = [
    'pending'  => 'background:#fef3c7; color:#92400e;',
    'reviewed' => 'background:#dbeafe; color:#1e40af;',
    'accepted' => 'background:#dcfce7; color:#166534;',
    'rejected' => 'background:#fef2f2; color:#991b1b;',
];
?>

<div style="margin-bottom: 1rem;">
    <a href="/admin/applications.php" style="color: var(--admin-primary); text-decoration: none;">&larr; Back to Applications</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start;">
    <!-- Main Details -->
    <div>
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header">
                <h3>Personal Information</h3>
                <span style="display:inline-block; padding:0.25rem 0.75rem; border-radius:20px; font-size:0.8rem; font-weight:600; <?= $badgeColors[$app['status']] ?? '' ?>"><?= ucfirst(escape($app['status'])) ?></span>
            </div>
            <div style="padding: 1.25rem;">
                <?php if ($app['photo']): ?>
                    <div style="margin-bottom: 1rem;">
                        <img src="<?= escape($app['photo']) ?>" alt="Applicant photo" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                    </div>
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div><strong>First Name:</strong><br><?= escape($app['first_name']) ?></div>
                    <div><strong>Last Name:</strong><br><?= escape($app['last_name']) ?></div>
                    <div><strong>Middle Name:</strong><br><?= escape($app['middle_name'] ?: '—') ?></div>
                    <div><strong>Date of Birth:</strong><br><?= date('F j, Y', strtotime($app['date_of_birth'])) ?></div>
                    <div><strong>Gender:</strong><br><?= escape($app['gender']) ?></div>
                    <div><strong>Place of Birth:</strong><br><?= escape($app['place_of_birth']) ?></div>
                    <div><strong>Nationality:</strong><br><?= escape($app['nationality']) ?></div>
                    <div><strong>Marital Status:</strong><br><?= escape($app['marital_status'] ?: '—') ?></div>
                    <div><strong>Email:</strong><br><a href="mailto:<?= escape($app['email']) ?>"><?= escape($app['email']) ?></a></div>
                    <div><strong>Phone:</strong><br><?= escape($app['phone']) ?></div>
                </div>

                <div style="margin-top: 0.75rem;">
                    <strong>Address:</strong><br>
                    <?= escape($app['street_address']) ?>
                    <?php if ($app['address_line_2']): ?><br><?= escape($app['address_line_2']) ?><?php endif; ?>
                    <br><?= escape($app['city']) ?>
                    <?php if ($app['state_region']): ?>, <?= escape($app['state_region']) ?><?php endif; ?>
                    <?php if ($app['postal_code']): ?> <?= escape($app['postal_code']) ?><?php endif; ?>
                    <br><?= escape($app['country']) ?>
                </div>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header"><h3>Educational Background</h3></div>
            <div style="padding: 1.25rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div><strong>Qualification 1:</strong><br><?= escape($app['qualification_1']) ?></div>
                    <div><strong>School & Date 1:</strong><br><?= escape($app['school_date_1']) ?></div>
                    <?php if ($app['qualification_2']): ?>
                    <div><strong>Qualification 2:</strong><br><?= escape($app['qualification_2']) ?></div>
                    <div><strong>School & Date 2:</strong><br><?= escape($app['school_date_2']) ?></div>
                    <?php endif; ?>
                    <?php if ($app['qualification_3']): ?>
                    <div><strong>Qualification 3:</strong><br><?= escape($app['qualification_3']) ?></div>
                    <div><strong>School & Date 3:</strong><br><?= escape($app['school_date_3']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header"><h3>Employment & Background</h3></div>
            <div style="padding: 1.25rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div><strong>Currently Employed:</strong><br><?= escape($app['currently_employed']) ?></div>
                    <div><strong>Designation:</strong><br><?= escape($app['designation'] ?: '—') ?></div>
                </div>
                <?php if ($app['employer_details']): ?>
                <div style="margin-top: 0.75rem;"><strong>Employer Details:</strong><br><?= escape($app['employer_details']) ?></div>
                <?php endif; ?>
                <div style="margin-top: 0.75rem;">
                    <strong>Criminal Conviction:</strong> <?= escape($app['criminal_conviction']) ?>
                    <?php if ($app['conviction_details']): ?>
                    <br><strong>Details:</strong> <?= escape($app['conviction_details']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div class="admin-card-header"><h3>Sponsorship & Next of Kin</h3></div>
            <div style="padding: 1.25rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div><strong>Sponsor:</strong><br><?= escape($app['sponsor']) ?></div>
                    <div><strong>Next of Kin:</strong><br><?= escape($app['next_of_kin_name']) ?></div>
                    <div><strong>Next of Kin Phone:</strong><br><?= escape($app['next_of_kin_phone']) ?></div>
                    <div><strong>Next of Kin Address:</strong><br><?= escape($app['next_of_kin_address']) ?></div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h3>Programme & Documents</h3></div>
            <div style="padding: 1.25rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                    <div><strong>Programme Type:</strong><br><?= ucfirst(escape($app['programme_type'])) ?></div>
                    <div><strong>Programme Choice:</strong><br><?= escape($app['programme_choice']) ?></div>
                </div>

                <strong>Uploaded Documents:</strong>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.5rem;">
                    <?php
                    $docs = [
                        'cv_file' => 'CV',
                        'certificates_file' => 'Certificates',
                        'transcripts_file' => 'Transcripts',
                        'reference_file' => 'Reference Letter',
                        'personal_statement_file' => 'Personal Statement',
                        'payment_proof_file' => 'Payment Proof',
                    ];
                    foreach ($docs as $field => $label):
                        if ($app[$field]):
                    ?>
                        <a href="<?= escape($app[$field]) ?>" target="_blank" style="display:flex; align-items:center; gap:0.5rem; padding:0.5rem 0.75rem; background:#f3f4f6; border-radius:8px; text-decoration:none; color:#374151; font-size:0.9rem;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <?= $label ?>
                        </a>
                    <?php endif; endforeach; ?>
                </div>

                <div style="margin-top: 1rem; font-size: 0.85rem; color: #6b7280;">
                    Submitted: <?= date('F j, Y \a\t g:i A', strtotime($app['submitted_at'])) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar: Status Update -->
    <div class="admin-card" style="position: sticky; top: 80px;">
        <div class="admin-card-header"><h3>Update Status</h3></div>
        <div style="padding: 1.25rem;">
            <form method="POST">
                <?= csrfField() ?>

                <div class="form-group">
                    <label for="status">Application Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" <?= $app['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="reviewed" <?= $app['status'] === 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                        <option value="accepted" <?= $app['status'] === 'accepted' ? 'selected' : '' ?>>Accepted</option>
                        <option value="rejected" <?= $app['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="admin_notes">Admin Notes</label>
                    <textarea name="admin_notes" id="admin_notes" class="form-control" rows="6" placeholder="Internal notes about this application..."><?= escape($app['admin_notes'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
