<?php
/**
 * TIBST CMS Installer
 *
 * This script sets up the database, creates configuration files,
 * and seeds initial data for the TIBST content management system.
 *
 * DELETE THIS FILE AFTER INSTALLATION.
 */

// Prevent timeout on slow servers
set_time_limit(300);

$errors = [];
$success = false;

// Check if already installed
$alreadyInstalled = file_exists(__DIR__ . '/includes/config.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$alreadyInstalled) {
    $dbHost     = trim($_POST['db_host'] ?? '');
    $dbName     = trim($_POST['db_name'] ?? '');
    $dbUser     = trim($_POST['db_user'] ?? '');
    $dbPass     = $_POST['db_pass'] ?? '';
    $adminName  = trim($_POST['admin_name'] ?? '');
    $adminEmail = trim($_POST['admin_email'] ?? '');
    $adminPass  = $_POST['admin_pass'] ?? '';

    // ── Validation ──────────────────────────────────────────
    if ($dbHost === '')     $errors[] = 'Database host is required.';
    if ($dbName === '')     $errors[] = 'Database name is required.';
    if ($dbUser === '')     $errors[] = 'Database username is required.';
    if ($adminName === '')  $errors[] = 'Admin name is required.';
    if ($adminEmail === '') $errors[] = 'Admin email is required.';
    if ($adminPass === '')  $errors[] = 'Admin password is required.';
    if (strlen($adminPass) < 8) $errors[] = 'Admin password must be at least 8 characters.';

    if (empty($errors)) {
        try {
            // ── Connect to MySQL (without selecting a database) ─
            $pdo = new PDO(
                "mysql:host={$dbHost};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            // ── Create the database if it doesn't exist ─────────
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");

            // ── Create tables ───────────────────────────────────
            $tables = [
                "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL,
                    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS hero_slides (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    image VARCHAR(500) NOT NULL,
                    headline_1 VARCHAR(255) NOT NULL DEFAULT '',
                    headline_2 VARCHAR(255) NOT NULL DEFAULT '',
                    headline_3 VARCHAR(255) NOT NULL DEFAULT '',
                    subtitle TEXT,
                    cta_text VARCHAR(100) DEFAULT 'Apply Now',
                    cta_link VARCHAR(500) DEFAULT 'admissions.php',
                    sort_order INT DEFAULT 0,
                    is_active TINYINT(1) DEFAULT 1,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS programmes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    degree_type VARCHAR(50) NOT NULL,
                    description TEXT,
                    duration VARCHAR(50),
                    image VARCHAR(500),
                    is_featured TINYINT(1) DEFAULT 0,
                    sort_order INT DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS news (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) NOT NULL UNIQUE,
                    publish_date DATE NOT NULL,
                    excerpt TEXT,
                    body LONGTEXT,
                    image VARCHAR(500),
                    is_published TINYINT(1) DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS testimonials (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    quote TEXT NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    role VARCHAR(150),
                    initials VARCHAR(5),
                    sort_order INT DEFAULT 0,
                    is_active TINYINT(1) DEFAULT 1,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS staff (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    role VARCHAR(150),
                    bio TEXT,
                    photo VARCHAR(500),
                    department VARCHAR(100),
                    sort_order INT DEFAULT 0,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS settings (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    setting_key VARCHAR(100) NOT NULL UNIQUE,
                    setting_value TEXT
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

                "CREATE TABLE IF NOT EXISTS page_blocks (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    page VARCHAR(50) NOT NULL,
                    block_id VARCHAR(50) NOT NULL,
                    content LONGTEXT,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    UNIQUE KEY page_block (page, block_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            ];

            foreach ($tables as $sql) {
                $pdo->exec($sql);
            }

            // ── Insert default settings ─────────────────────────
            $settingsStmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (:k, :v)");
            $defaultSettings = [
                'site_name'       => 'Thrivus Institute of Biomedical Science and Technology',
                'site_short_name' => 'TIBST',
                'phone'           => '+233 302 957 663',
                'mobile'          => '+233 277 715 058',
                'email'           => 'info@thrivusinstitute.edu.gh',
                'address'         => 'Constellations Avenue, Lashibi - Accra, Ghana',
                'facebook'        => 'https://www.facebook.com/thrivusinstitute',
                'instagram'       => 'https://www.instagram.com/thrivusinstitute',
                'linkedin'        => 'https://www.linkedin.com/company/thrivusinstitute',
                'youtube'         => 'https://www.youtube.com/@thrivusinstitute',
                'whatsapp'        => 'https://wa.me/233277715058',
            ];
            foreach ($defaultSettings as $key => $value) {
                $settingsStmt->execute([':k' => $key, ':v' => $value]);
            }

            // ── Seed hero slide ─────────────────────────────────
            $pdo->exec("INSERT INTO hero_slides (image, headline_1, headline_2, headline_3, subtitle, cta_text, cta_link, sort_order, is_active) VALUES (
                'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80',
                'Shaping the',
                'Future of',
                'Biomedical Science',
                'TIBST is a premier institution dedicated to advancing biomedical science education and research in Ghana and beyond.',
                'Apply Now',
                'admissions.php',
                1,
                1
            )");

            // ── Seed programmes ─────────────────────────────────
            $progStmt = $pdo->prepare("INSERT INTO programmes (title, degree_type, description, duration, image, is_featured, sort_order) VALUES (:title, :degree, :desc, :dur, NULL, :feat, :sort)");

            $progStmt->execute([
                ':title' => 'Gene Therapy',
                ':degree' => 'MPhil',
                ':desc' => 'Explore cutting-edge gene therapy techniques and their applications in modern medicine. This programme prepares graduates for careers in genetic research and clinical gene therapy.',
                ':dur' => '2 years',
                ':feat' => 1,
                ':sort' => 1,
            ]);
            $progStmt->execute([
                ':title' => 'Gene Therapy',
                ':degree' => 'PhD',
                ':desc' => 'Conduct advanced research in gene therapy, contributing original knowledge to the field. This doctoral programme is designed for candidates seeking to lead innovation in genetic medicine.',
                ':dur' => '3-4 years',
                ':feat' => 0,
                ':sort' => 2,
            ]);
            $progStmt->execute([
                ':title' => 'Human Embryology',
                ':degree' => 'MPhil',
                ':desc' => 'Study the science of human embryonic development and reproductive biology. This programme equips students with expertise in embryology research and assisted reproduction technologies.',
                ':dur' => '2 years',
                ':feat' => 0,
                ':sort' => 3,
            ]);

            // ── Seed news ───────────────────────────────────────
            $newsStmt = $pdo->prepare("INSERT INTO news (title, slug, publish_date, excerpt, body, image, is_published) VALUES (:title, :slug, :date, :excerpt, :body, NULL, 1)");

            $newsStmt->execute([
                ':title' => 'TIBST Opens Applications for 2026/2027 Academic Year',
                ':slug' => 'tibst-opens-applications-2026-2027',
                ':date' => '2026-03-01',
                ':excerpt' => 'The Thrivus Institute of Biomedical Science and Technology is now accepting applications for the upcoming academic year.',
                ':body' => '<p>The Thrivus Institute of Biomedical Science and Technology (TIBST) is pleased to announce that applications are now open for the 2026/2027 academic year. Prospective students are invited to apply for our MPhil and PhD programmes in Gene Therapy and Human Embryology.</p><p>Applicants should hold a relevant first degree and demonstrate a strong interest in biomedical research. Scholarships and financial aid options are available for qualifying candidates.</p>',
            ]);
            $newsStmt->execute([
                ':title' => 'New Research Partnership with Leading Biomedical Lab',
                ':slug' => 'new-research-partnership-biomedical-lab',
                ':date' => '2026-03-03',
                ':excerpt' => 'TIBST has signed a memorandum of understanding with a leading biomedical research laboratory to enhance collaborative research.',
                ':body' => '<p>TIBST is proud to announce a new research partnership that will strengthen our commitment to world-class biomedical research. The memorandum of understanding was signed in a ceremony attended by faculty, students, and partners.</p><p>This collaboration will provide our students and researchers with access to advanced laboratory facilities and joint research opportunities in gene therapy and regenerative medicine.</p>',
            ]);
            $newsStmt->execute([
                ':title' => 'Guest Lecture Series on Advances in Gene Therapy',
                ':slug' => 'guest-lecture-series-gene-therapy',
                ':date' => '2026-03-05',
                ':excerpt' => 'TIBST will host a series of guest lectures featuring internationally renowned experts in gene therapy and molecular biology.',
                ':body' => '<p>The Thrivus Institute is excited to announce an upcoming guest lecture series focused on the latest advances in gene therapy. The series will feature presentations from leading researchers and clinicians from around the world.</p><p>Topics will include CRISPR-based therapies, viral vector design, and clinical trials for genetic disorders. All students, faculty, and members of the public are welcome to attend.</p>',
            ]);

            // ── Seed testimonials ───────────────────────────────
            $testStmt = $pdo->prepare("INSERT INTO testimonials (quote, name, role, initials, sort_order, is_active) VALUES (:quote, :name, :role, :initials, :sort, 1)");

            $testStmt->execute([
                ':quote' => 'TIBST has provided me with an exceptional learning environment. The faculty are dedicated, the research facilities are outstanding, and the curriculum is truly world-class.',
                ':name' => 'Dr. Ama Kusi',
                ':role' => 'MPhil Gene Therapy Graduate',
                ':initials' => 'AK',
                ':sort' => 1,
            ]);
            $testStmt->execute([
                ':quote' => 'Studying at TIBST transformed my understanding of biomedical science. The hands-on research experience and mentorship I received were invaluable for my career.',
                ':name' => 'Kwame Mensah',
                ':role' => 'PhD Candidate, Gene Therapy',
                ':initials' => 'KM',
                ':sort' => 2,
            ]);
            $testStmt->execute([
                ':quote' => 'The Human Embryology programme at TIBST is rigorous and deeply rewarding. I feel well-prepared to contribute meaningfully to reproductive science research.',
                ':name' => 'Dr. Efua Aidoo',
                ':role' => 'MPhil Human Embryology Graduate',
                ':initials' => 'EA',
                ':sort' => 3,
            ]);

            // ── Create admin user ───────────────────────────────
            $hash = password_hash($adminPass, PASSWORD_DEFAULT);
            $userStmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :hash, 'admin')");
            $userStmt->execute([
                ':name'  => $adminName,
                ':email' => $adminEmail,
                ':hash'  => $hash,
            ]);

            // ── Write config file ───────────────────────────────
            $includesDir = __DIR__ . '/includes';
            if (!is_dir($includesDir)) {
                mkdir($includesDir, 0755, true);
            }

            $configContent = "<?php\n";
            $configContent .= "/**\n * TIBST CMS Configuration\n * Generated by installer on " . date('Y-m-d H:i:s') . "\n */\n\n";
            $configContent .= "define('DB_HOST', " . var_export($dbHost, true) . ");\n";
            $configContent .= "define('DB_NAME', " . var_export($dbName, true) . ");\n";
            $configContent .= "define('DB_USER', " . var_export($dbUser, true) . ");\n";
            $configContent .= "define('DB_PASS', " . var_export($dbPass, true) . ");\n\n";
            $configContent .= "try {\n";
            $configContent .= "    \$pdo = new PDO(\n";
            $configContent .= "        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',\n";
            $configContent .= "        DB_USER,\n";
            $configContent .= "        DB_PASS,\n";
            $configContent .= "        [\n";
            $configContent .= "            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,\n";
            $configContent .= "            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,\n";
            $configContent .= "            PDO::ATTR_EMULATE_PREPARES   => false,\n";
            $configContent .= "        ]\n";
            $configContent .= "    );\n";
            $configContent .= "} catch (PDOException \$e) {\n";
            $configContent .= "    die('Database connection failed: ' . \$e->getMessage());\n";
            $configContent .= "}\n";

            file_put_contents($includesDir . '/config.php', $configContent);

            // ── Create uploads directory ────────────────────────
            $uploadsDir = __DIR__ . '/uploads';
            if (!is_dir($uploadsDir)) {
                mkdir($uploadsDir, 0755, true);
            }

            // Prevent PHP execution in uploads
            $htaccess = "# Prevent PHP execution in uploads directory\n";
            $htaccess .= "<FilesMatch \"\\.php$\">\n";
            $htaccess .= "    Order Allow,Deny\n";
            $htaccess .= "    Deny from all\n";
            $htaccess .= "</FilesMatch>\n";
            file_put_contents($uploadsDir . '/.htaccess', $htaccess);

            $success = true;

        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIBST CMS Installer</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .installer {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            max-width: 560px;
            width: 100%;
            overflow: hidden;
        }

        .installer-header {
            background: #050505;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        .installer-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .installer-header .accent {
            color: #4E9B17;
        }

        .installer-header p {
            font-size: 0.9rem;
            color: #aaa;
        }

        .installer-body {
            padding: 2rem;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4E9B17;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e8f5e0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.35rem;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4E9B17;
            box-shadow: 0 0 0 3px rgba(78, 155, 23, 0.15);
        }

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: #4E9B17;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
        }

        .btn:hover {
            background: #3d7c12;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .alert ul {
            margin: 0.5rem 0 0 1.25rem;
        }

        .alert a {
            color: inherit;
            font-weight: 600;
        }

        .warning-text {
            margin-top: 1rem;
            padding: 0.75rem;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 6px;
            color: #92400e;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .spacer {
            height: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="installer">
        <div class="installer-header">
            <h1><span class="accent">TIBST</span> CMS Installer</h1>
            <p>Thrivus Institute of Biomedical Science and Technology</p>
        </div>
        <div class="installer-body">
            <?php if ($alreadyInstalled): ?>
                <div class="alert alert-info">
                    <strong>Already Installed</strong><br>
                    The TIBST CMS has already been installed. The configuration file exists at <code>includes/config.php</code>.
                    <br><br>
                    <a href="index.php">Go to the website</a>
                </div>

            <?php elseif ($success): ?>
                <div class="alert alert-success">
                    <strong>Installation Complete!</strong><br>
                    The TIBST CMS has been installed successfully. Your database is set up and the admin account has been created.
                    <br><br>
                    <a href="index.php">Go to the website</a>
                </div>
                <div class="warning-text">
                    <strong>Important:</strong> For security, please delete <code>install.php</code> from your server immediately.
                </div>

            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-error">
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="section-title">Database Connection</div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="db_host">Database Host</label>
                            <input type="text" id="db_host" name="db_host" value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="db_name">Database Name</label>
                            <input type="text" id="db_name" name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? 'tibst_cms') ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="db_user">Database Username</label>
                            <input type="text" id="db_user" name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="db_pass">Database Password</label>
                            <input type="password" id="db_pass" name="db_pass" value="">
                        </div>
                    </div>

                    <div class="spacer"></div>
                    <div class="section-title">Admin Account</div>

                    <div class="form-group">
                        <label for="admin_name">Admin Name</label>
                        <input type="text" id="admin_name" name="admin_name" value="<?= htmlspecialchars($_POST['admin_name'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="admin_email">Admin Email</label>
                        <input type="email" id="admin_email" name="admin_email" value="<?= htmlspecialchars($_POST['admin_email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="admin_pass">Admin Password <small>(min. 8 characters)</small></label>
                        <input type="password" id="admin_pass" name="admin_pass" minlength="8" required>
                    </div>

                    <button type="submit" class="btn">Install TIBST CMS</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
