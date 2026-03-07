<?php
$pageTitle = 'Apply to Thrivus - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'admissions';
require_once 'includes/header.php';
require_once 'includes/csrf.php';

$programmes = getAllProgrammes();
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrf()) {
        $errors[] = 'Invalid form submission. Please try again.';
    } else {
        $pdo = getDB();

        // Collect and validate fields
        $firstName      = trim($_POST['first_name'] ?? '');
        $lastName       = trim($_POST['last_name'] ?? '');
        $middleName     = trim($_POST['middle_name'] ?? '');
        $dob            = trim($_POST['date_of_birth'] ?? '');
        $gender         = trim($_POST['gender'] ?? '');
        $placeOfBirth   = trim($_POST['place_of_birth'] ?? '');
        $nationality    = trim($_POST['nationality'] ?? '');
        $emailAddr      = trim($_POST['email'] ?? '');
        $phone          = trim($_POST['phone'] ?? '');
        $streetAddress  = trim($_POST['street_address'] ?? '');
        $addressLine2   = trim($_POST['address_line_2'] ?? '');
        $city           = trim($_POST['city'] ?? '');
        $stateRegion    = trim($_POST['state_region'] ?? '');
        $postalCode     = trim($_POST['postal_code'] ?? '');
        $country        = trim($_POST['country'] ?? '');
        $maritalStatus  = trim($_POST['marital_status'] ?? '');

        $qualification1 = trim($_POST['qualification_1'] ?? '');
        $schoolDate1    = trim($_POST['school_date_1'] ?? '');
        $qualification2 = trim($_POST['qualification_2'] ?? '');
        $schoolDate2    = trim($_POST['school_date_2'] ?? '');
        $qualification3 = trim($_POST['qualification_3'] ?? '');
        $schoolDate3    = trim($_POST['school_date_3'] ?? '');

        $employed       = trim($_POST['currently_employed'] ?? '');
        $designation    = trim($_POST['designation'] ?? '');
        $employerDetails = trim($_POST['employer_details'] ?? '');
        $criminal       = trim($_POST['criminal_conviction'] ?? '');
        $convictionDetails = trim($_POST['conviction_details'] ?? '');

        $sponsor        = trim($_POST['sponsor'] ?? '');
        $nokName        = trim($_POST['next_of_kin_name'] ?? '');
        $nokAddress     = trim($_POST['next_of_kin_address'] ?? '');
        $nokPhone       = trim($_POST['next_of_kin_phone'] ?? '');

        $programmeType  = trim($_POST['programme_type'] ?? '');
        $programmeChoice = trim($_POST['programme_choice'] ?? '');
        $agreedTerms    = isset($_POST['agreed_terms']) ? 1 : 0;

        // Validation
        if ($firstName === '')      $errors[] = 'First name is required.';
        if ($lastName === '')       $errors[] = 'Last name is required.';
        if ($dob === '')            $errors[] = 'Date of birth is required.';
        if (!in_array($gender, ['Male', 'Female'])) $errors[] = 'Gender is required.';
        if ($placeOfBirth === '')   $errors[] = 'Place of birth is required.';
        if ($nationality === '')    $errors[] = 'Nationality is required.';
        if ($emailAddr === '' || !filter_var($emailAddr, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
        if ($phone === '')          $errors[] = 'Phone number is required.';
        if ($streetAddress === '')  $errors[] = 'Street address is required.';
        if ($city === '')           $errors[] = 'City is required.';
        if ($country === '')        $errors[] = 'Country is required.';
        if ($qualification1 === '') $errors[] = 'At least one educational qualification is required.';
        if ($schoolDate1 === '')    $errors[] = 'School and date for qualification 1 is required.';
        if (!in_array($employed, ['Yes', 'No'])) $errors[] = 'Employment status is required.';
        if (!in_array($criminal, ['Yes', 'No'])) $errors[] = 'Criminal conviction disclosure is required.';
        if (!in_array($sponsor, ['Self', 'Parent', 'Employer', 'Other'])) $errors[] = 'Sponsorship information is required.';
        if ($nokName === '')        $errors[] = 'Next of kin name is required.';
        if ($nokAddress === '')     $errors[] = 'Next of kin address is required.';
        if ($nokPhone === '')       $errors[] = 'Next of kin phone is required.';
        if (!in_array($programmeType, ['postgraduate', 'certificate'])) $errors[] = 'Programme type is required.';
        if ($programmeChoice === '') $errors[] = 'Programme choice is required.';
        if (!$agreedTerms)          $errors[] = 'You must agree to the terms and declaration.';

        // File uploads
        $photoPath = '';
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photoPath = uploadImage('photo');
            if ($photoPath === false) {
                $errors[] = 'Photo upload failed. Accepted formats: JPG, PNG, GIF, WEBP (max 5 MB).';
                $photoPath = '';
            }
        }

        $fileFields = ['cv_file', 'certificates_file', 'transcripts_file', 'reference_file', 'personal_statement_file', 'payment_proof_file'];
        $filePaths = [];
        foreach ($fileFields as $field) {
            if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                $label = ucwords(str_replace('_', ' ', str_replace('_file', '', $field)));
                $errors[] = "{$label} document is required.";
                $filePaths[$field] = '';
            } else {
                $path = uploadDocument($field);
                if ($path === false) {
                    $label = ucwords(str_replace('_', ' ', str_replace('_file', '', $field)));
                    $errors[] = "{$label} upload failed. Accepted: PDF, DOC, DOCX, images (max 10 MB).";
                    $filePaths[$field] = '';
                } else {
                    $filePaths[$field] = $path;
                }
            }
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO applications (
                first_name, last_name, middle_name, date_of_birth, gender, place_of_birth,
                nationality, email, phone, street_address, address_line_2, city,
                state_region, postal_code, country, marital_status, photo,
                qualification_1, school_date_1, qualification_2, school_date_2,
                qualification_3, school_date_3,
                currently_employed, designation, employer_details,
                criminal_conviction, conviction_details,
                sponsor, next_of_kin_name, next_of_kin_address, next_of_kin_phone,
                programme_type, programme_choice,
                cv_file, certificates_file, transcripts_file, reference_file,
                personal_statement_file, payment_proof_file,
                agreed_terms
            ) VALUES (
                :first_name, :last_name, :middle_name, :dob, :gender, :pob,
                :nationality, :email, :phone, :street, :addr2, :city,
                :state, :postal, :country, :marital, :photo,
                :q1, :sd1, :q2, :sd2, :q3, :sd3,
                :employed, :designation, :employer,
                :criminal, :conviction,
                :sponsor, :nok_name, :nok_addr, :nok_phone,
                :prog_type, :prog_choice,
                :cv, :certs, :trans, :ref, :ps, :pay,
                :terms
            )");

            $stmt->execute([
                ':first_name'   => $firstName,
                ':last_name'    => $lastName,
                ':middle_name'  => $middleName,
                ':dob'          => $dob,
                ':gender'       => $gender,
                ':pob'          => $placeOfBirth,
                ':nationality'  => $nationality,
                ':email'        => $emailAddr,
                ':phone'        => $phone,
                ':street'       => $streetAddress,
                ':addr2'        => $addressLine2,
                ':city'         => $city,
                ':state'        => $stateRegion,
                ':postal'       => $postalCode,
                ':country'      => $country,
                ':marital'      => $maritalStatus,
                ':photo'        => $photoPath,
                ':q1'           => $qualification1,
                ':sd1'          => $schoolDate1,
                ':q2'           => $qualification2,
                ':sd2'          => $schoolDate2,
                ':q3'           => $qualification3,
                ':sd3'          => $schoolDate3,
                ':employed'     => $employed,
                ':designation'  => $designation,
                ':employer'     => $employerDetails,
                ':criminal'     => $criminal,
                ':conviction'   => $convictionDetails,
                ':sponsor'      => $sponsor,
                ':nok_name'     => $nokName,
                ':nok_addr'     => $nokAddress,
                ':nok_phone'    => $nokPhone,
                ':prog_type'    => $programmeType,
                ':prog_choice'  => $programmeChoice,
                ':cv'           => $filePaths['cv_file'],
                ':certs'        => $filePaths['certificates_file'],
                ':trans'        => $filePaths['transcripts_file'],
                ':ref'          => $filePaths['reference_file'],
                ':ps'           => $filePaths['personal_statement_file'],
                ':pay'          => $filePaths['payment_proof_file'],
                ':terms'        => $agreedTerms,
            ]);

            $success = true;
        }
    }
}

$showWizard = ($_SERVER['REQUEST_METHOD'] === 'POST');
?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80');"></div>
  <div class="hero-overlay"></div>
  <div class="hero-pattern"></div>
  <div class="hero-content">
    <div class="breadcrumb">
      <a href="index.php">Home</a>
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
      <span>Apply</span>
    </div>
    <h1>Apply to <span class="highlight">Thrivus</span></h1>
    <p class="hero-subtitle">Take the first step toward a career in biomedical science. Follow the steps below to submit your application.</p>
  </div>
</section>

<!-- APPLICATION STEPS -->
<section class="section" style="background: var(--off-white);" id="apply-landing">
  <div class="container">
    <div class="section-header fade-up">
      <div class="section-label">How to Apply</div>
      <h2 class="section-title">Three-Step Application Process</h2>
      <p class="section-subtitle">Follow these simple steps to complete your application to TIBST.</p>
    </div>

    <div class="features-grid">
      <div class="feature-card fade-up">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <h3>Step 1: Get Started</h3>
        <p>Complete the online application form below. All supporting documents must be submitted in prescribed formats (PDF, DOC, or DOCX).</p>
      </div>

      <div class="feature-card fade-up fade-up-delay-1">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        </div>
        <h3>Step 2: Payment for Application</h3>
        <p><strong>Bank Transfer (GHS):</strong><br>Ecobank Ghana, Account: 1441002263479, Spintex Branch</p>
        <p style="margin-top:8px;"><strong>International (USD):</strong><br>SWIFT: ECOCGHAC, Account: 3441002204083</p>
        <p style="margin-top:8px;"><strong>MTN Mobile Money:</strong><br>+233 54 209 8923, Merchant ID: 750888</p>
      </div>

      <div class="feature-card fade-up fade-up-delay-2">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <h3>Step 3: Submit Application</h3>
        <p>Complete the online form with all required documents and proof of payment. Applications submitted without proof of payment will not be processed.</p>
      </div>
    </div>

    <div class="fade-up" style="text-align: center; margin-top: 3rem;">
      <button type="button" class="btn btn-primary btn-lg" id="start-application-btn" style="padding: 1rem 3rem; font-size: 1.1rem;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px; vertical-align: -3px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Start Application
      </button>
    </div>
  </div>
</section>

<!-- ===== APPLICATION PORTAL (Multi-Step Wizard) ===== -->
<section class="appw" id="apply-wizard" style="display: none;">
  <div class="container">

    <!-- Stepper -->
    <div class="appw-stepper">
      <div class="appw-step is-active" data-step="1"><span class="appw-step__num">1</span><span class="appw-step__label">Personal</span></div>
      <div class="appw-step" data-step="2"><span class="appw-step__num">2</span><span class="appw-step__label">Education</span></div>
      <div class="appw-step" data-step="3"><span class="appw-step__num">3</span><span class="appw-step__label">Employment</span></div>
      <div class="appw-step" data-step="4"><span class="appw-step__num">4</span><span class="appw-step__label">Sponsorship</span></div>
      <div class="appw-step" data-step="5"><span class="appw-step__num">5</span><span class="appw-step__label">Programme</span></div>
      <div class="appw-step" data-step="6"><span class="appw-step__num">6</span><span class="appw-step__label">Documents</span></div>
      <div class="appw-step" data-step="7"><span class="appw-step__num">7</span><span class="appw-step__label">Review</span></div>
    </div>

    <?php if ($success): ?>
    <!-- Success State -->
    <div class="appw-card">
      <div class="appw-success">
        <div class="appw-success__icon">
          <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h2>Application Submitted Successfully!</h2>
        <p>Thank you for applying to TIBST. Your application has been received and is now under review. We will contact you at the email address you provided with further instructions.</p>
        <a href="index.php" class="btn btn-primary" style="margin-top: 1.5rem;">Return to Home</a>
      </div>
    </div>
    <?php else: ?>

    <?php if (!empty($errors)): ?>
    <div class="appw-errors" id="appw-errors">
      <h4>Please fix the following errors:</h4>
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= escape($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="apply.php" enctype="multipart/form-data" id="appw-form">
      <?= csrfField() ?>

      <!-- ─── Step 1: Personal Information ─────────────────────── -->
      <div class="appw-card appw-panel is-active" data-panel="1">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Personal Information</h3>
            <p class="appw-card__sub">Tell us about yourself</p>
          </div>
        </div>

        <div class="appw-field">
          <label class="appw-label">Passport Photo <span class="appw-optional">(optional)</span></label>
          <input type="file" name="photo" accept="image/*" class="appw-file">
        </div>

        <div class="appw-row appw-row--3">
          <div class="appw-field">
            <label class="appw-label">First Name <span class="appw-req">*</span></label>
            <input type="text" name="first_name" required class="appw-input" data-save value="<?= escape($_POST['first_name'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Last Name <span class="appw-req">*</span></label>
            <input type="text" name="last_name" required class="appw-input" data-save value="<?= escape($_POST['last_name'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Middle Name</label>
            <input type="text" name="middle_name" class="appw-input" data-save value="<?= escape($_POST['middle_name'] ?? '') ?>">
          </div>
        </div>

        <div class="appw-row appw-row--3">
          <div class="appw-field">
            <label class="appw-label">Date of Birth <span class="appw-req">*</span></label>
            <input type="date" name="date_of_birth" required class="appw-input" data-save value="<?= escape($_POST['date_of_birth'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Gender <span class="appw-req">*</span></label>
            <select name="gender" required class="appw-input" data-save>
              <option value="">Select...</option>
              <option value="Male" <?= ($_POST['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= ($_POST['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
          </div>
          <div class="appw-field">
            <label class="appw-label">Marital Status</label>
            <select name="marital_status" class="appw-input" data-save>
              <option value="">Select...</option>
              <option value="Single" <?= ($_POST['marital_status'] ?? '') === 'Single' ? 'selected' : '' ?>>Single</option>
              <option value="Married" <?= ($_POST['marital_status'] ?? '') === 'Married' ? 'selected' : '' ?>>Married</option>
              <option value="Divorced" <?= ($_POST['marital_status'] ?? '') === 'Divorced' ? 'selected' : '' ?>>Divorced</option>
              <option value="Widowed" <?= ($_POST['marital_status'] ?? '') === 'Widowed' ? 'selected' : '' ?>>Widowed</option>
            </select>
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Place of Birth <span class="appw-req">*</span></label>
            <input type="text" name="place_of_birth" required class="appw-input" data-save value="<?= escape($_POST['place_of_birth'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Nationality <span class="appw-req">*</span></label>
            <input type="text" name="nationality" required class="appw-input" data-save value="<?= escape($_POST['nationality'] ?? '') ?>">
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Email Address <span class="appw-req">*</span></label>
            <input type="email" name="email" required class="appw-input" data-save value="<?= escape($_POST['email'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Phone Number <span class="appw-req">*</span></label>
            <input type="tel" name="phone" required class="appw-input" data-save value="<?= escape($_POST['phone'] ?? '') ?>">
          </div>
        </div>

        <div class="appw-field">
          <label class="appw-label">Street Address <span class="appw-req">*</span></label>
          <input type="text" name="street_address" required class="appw-input" data-save value="<?= escape($_POST['street_address'] ?? '') ?>">
        </div>

        <div class="appw-field">
          <label class="appw-label">Address Line 2</label>
          <input type="text" name="address_line_2" class="appw-input" data-save value="<?= escape($_POST['address_line_2'] ?? '') ?>">
        </div>

        <div class="appw-row appw-row--4">
          <div class="appw-field">
            <label class="appw-label">City <span class="appw-req">*</span></label>
            <input type="text" name="city" required class="appw-input" data-save value="<?= escape($_POST['city'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">State / Region</label>
            <input type="text" name="state_region" class="appw-input" data-save value="<?= escape($_POST['state_region'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Postal Code</label>
            <input type="text" name="postal_code" class="appw-input" data-save value="<?= escape($_POST['postal_code'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Country <span class="appw-req">*</span></label>
            <input type="text" name="country" required class="appw-input" data-save value="<?= escape($_POST['country'] ?? '') ?>">
          </div>
        </div>
      </div>

      <!-- ─── Step 2: Educational Background ───────────────────── -->
      <div class="appw-card appw-panel" data-panel="2">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 1.66 2.69 3 6 3s6-1.34 6-3v-5"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Educational Background</h3>
            <p class="appw-card__sub">List your qualifications starting with the most recent</p>
          </div>
        </div>

        <div class="appw-qual-block">
          <h4 class="appw-qual-label">Qualification 1 <span class="appw-req">*</span></h4>
          <div class="appw-row appw-row--2">
            <div class="appw-field">
              <label class="appw-label">Qualification / Degree</label>
              <input type="text" name="qualification_1" required class="appw-input" data-save placeholder="e.g. BSc Biomedical Science" value="<?= escape($_POST['qualification_1'] ?? '') ?>">
            </div>
            <div class="appw-field">
              <label class="appw-label">School / Institution & Date</label>
              <input type="text" name="school_date_1" required class="appw-input" data-save placeholder="e.g. University of Ghana, 2020" value="<?= escape($_POST['school_date_1'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="appw-qual-block">
          <h4 class="appw-qual-label">Qualification 2 <span class="appw-optional">(optional)</span></h4>
          <div class="appw-row appw-row--2">
            <div class="appw-field">
              <label class="appw-label">Qualification / Degree</label>
              <input type="text" name="qualification_2" class="appw-input" data-save value="<?= escape($_POST['qualification_2'] ?? '') ?>">
            </div>
            <div class="appw-field">
              <label class="appw-label">School / Institution & Date</label>
              <input type="text" name="school_date_2" class="appw-input" data-save value="<?= escape($_POST['school_date_2'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="appw-qual-block">
          <h4 class="appw-qual-label">Qualification 3 <span class="appw-optional">(optional)</span></h4>
          <div class="appw-row appw-row--2">
            <div class="appw-field">
              <label class="appw-label">Qualification / Degree</label>
              <input type="text" name="qualification_3" class="appw-input" data-save value="<?= escape($_POST['qualification_3'] ?? '') ?>">
            </div>
            <div class="appw-field">
              <label class="appw-label">School / Institution & Date</label>
              <input type="text" name="school_date_3" class="appw-input" data-save value="<?= escape($_POST['school_date_3'] ?? '') ?>">
            </div>
          </div>
        </div>
      </div>

      <!-- ─── Step 3: Employment & Background ──────────────────── -->
      <div class="appw-card appw-panel" data-panel="3">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Employment & Background</h3>
            <p class="appw-card__sub">Your current employment and background information</p>
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Are you currently employed? <span class="appw-req">*</span></label>
            <select name="currently_employed" required class="appw-input" data-save>
              <option value="">Select...</option>
              <option value="Yes" <?= ($_POST['currently_employed'] ?? '') === 'Yes' ? 'selected' : '' ?>>Yes</option>
              <option value="No" <?= ($_POST['currently_employed'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
            </select>
          </div>
          <div class="appw-field">
            <label class="appw-label">Designation / Job Title</label>
            <input type="text" name="designation" class="appw-input" data-save value="<?= escape($_POST['designation'] ?? '') ?>">
          </div>
        </div>

        <div class="appw-field">
          <label class="appw-label">Employer Name & Address <span class="appw-optional">(if employed)</span></label>
          <textarea name="employer_details" rows="2" class="appw-textarea" data-save><?= escape($_POST['employer_details'] ?? '') ?></textarea>
        </div>

        <div class="appw-field">
          <label class="appw-label">Have you ever been convicted of a criminal offence? <span class="appw-req">*</span></label>
          <select name="criminal_conviction" required class="appw-input" data-save>
            <option value="">Select...</option>
            <option value="No" <?= ($_POST['criminal_conviction'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
            <option value="Yes" <?= ($_POST['criminal_conviction'] ?? '') === 'Yes' ? 'selected' : '' ?>>Yes</option>
          </select>
        </div>

        <div class="appw-field">
          <label class="appw-label">If yes, please provide details</label>
          <textarea name="conviction_details" rows="2" class="appw-textarea" data-save><?= escape($_POST['conviction_details'] ?? '') ?></textarea>
        </div>
      </div>

      <!-- ─── Step 4: Sponsorship & Next of Kin ────────────────── -->
      <div class="appw-card appw-panel" data-panel="4">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Sponsorship & Next of Kin</h3>
            <p class="appw-card__sub">Funding source and emergency contact</p>
          </div>
        </div>

        <div class="appw-field">
          <label class="appw-label">Who is sponsoring your studies? <span class="appw-req">*</span></label>
          <select name="sponsor" required class="appw-input" data-save>
            <option value="">Select...</option>
            <option value="Self" <?= ($_POST['sponsor'] ?? '') === 'Self' ? 'selected' : '' ?>>Self</option>
            <option value="Parent" <?= ($_POST['sponsor'] ?? '') === 'Parent' ? 'selected' : '' ?>>Parent / Guardian</option>
            <option value="Employer" <?= ($_POST['sponsor'] ?? '') === 'Employer' ? 'selected' : '' ?>>Employer</option>
            <option value="Other" <?= ($_POST['sponsor'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
          </select>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Next of Kin Full Name <span class="appw-req">*</span></label>
            <input type="text" name="next_of_kin_name" required class="appw-input" data-save value="<?= escape($_POST['next_of_kin_name'] ?? '') ?>">
          </div>
          <div class="appw-field">
            <label class="appw-label">Next of Kin Phone <span class="appw-req">*</span></label>
            <input type="tel" name="next_of_kin_phone" required class="appw-input" data-save value="<?= escape($_POST['next_of_kin_phone'] ?? '') ?>">
          </div>
        </div>

        <div class="appw-field">
          <label class="appw-label">Next of Kin Address <span class="appw-req">*</span></label>
          <input type="text" name="next_of_kin_address" required class="appw-input" data-save value="<?= escape($_POST['next_of_kin_address'] ?? '') ?>">
        </div>
      </div>

      <!-- ─── Step 5: Programme Selection ──────────────────────── -->
      <div class="appw-card appw-panel" data-panel="5">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Programme Selection</h3>
            <p class="appw-card__sub">Choose your desired programme of study</p>
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Programme Type <span class="appw-req">*</span></label>
            <select name="programme_type" required class="appw-input" data-save>
              <option value="">Select...</option>
              <option value="postgraduate" <?= ($_POST['programme_type'] ?? '') === 'postgraduate' ? 'selected' : '' ?>>Postgraduate (MPhil / PhD)</option>
              <option value="certificate" <?= ($_POST['programme_type'] ?? '') === 'certificate' ? 'selected' : '' ?>>Certificate Programme</option>
            </select>
          </div>
          <div class="appw-field">
            <label class="appw-label">Programme Choice <span class="appw-req">*</span></label>
            <select name="programme_choice" required class="appw-input" data-save>
              <option value="">Select...</option>
              <?php foreach ($programmes as $prog): ?>
                <option value="<?= escape($prog['title'] . ' - ' . $prog['degree_type']) ?>" <?= ($_POST['programme_choice'] ?? '') === $prog['title'] . ' - ' . $prog['degree_type'] ? 'selected' : '' ?>><?= escape($prog['title'] . ' (' . $prog['degree_type'] . ')') ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- ─── Step 6: Required Documents ───────────────────────── -->
      <div class="appw-card appw-panel" data-panel="6">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Required Documents</h3>
            <p class="appw-card__sub">Upload all required documents (PDF, DOC, DOCX, JPG, PNG &mdash; max 10 MB each)</p>
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Curriculum Vitae (CV) <span class="appw-req">*</span></label>
            <input type="file" name="cv_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="appw-file">
          </div>
          <div class="appw-field">
            <label class="appw-label">Certificates <span class="appw-req">*</span></label>
            <input type="file" name="certificates_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="appw-file">
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Academic Transcripts <span class="appw-req">*</span></label>
            <input type="file" name="transcripts_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="appw-file">
          </div>
          <div class="appw-field">
            <label class="appw-label">Reference Letter <span class="appw-req">*</span></label>
            <input type="file" name="reference_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="appw-file">
          </div>
        </div>

        <div class="appw-row appw-row--2">
          <div class="appw-field">
            <label class="appw-label">Personal Statement <span class="appw-req">*</span></label>
            <input type="file" name="personal_statement_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="appw-file">
          </div>
          <div class="appw-field">
            <label class="appw-label">Proof of Payment <span class="appw-req">*</span></label>
            <input type="file" name="payment_proof_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp" class="appw-file">
          </div>
        </div>
      </div>

      <!-- ─── Step 7: Review & Submit ──────────────────────────── -->
      <div class="appw-card appw-panel" data-panel="7">
        <div class="appw-card__header">
          <div class="appw-card__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <div>
            <h3 class="appw-card__title">Review & Submit</h3>
            <p class="appw-card__sub">Verify your information before submitting</p>
          </div>
        </div>

        <div class="appw-review" id="appw-review">
          <!-- Populated by JS -->
        </div>

        <div class="appw-declaration">
          <label class="appw-declaration__label">
            <input type="checkbox" name="agreed_terms" required class="appw-declaration__check">
            <span>I declare that the information provided in this application is true and correct to the best of my knowledge. I understand that any false or misleading information may result in the rejection of my application or dismissal from the institute. I agree to abide by the rules, regulations, and policies of the Thrivus Institute of Biomedical Science and Technology.</span>
          </label>
        </div>
      </div>

      <!-- Navigation Bar -->
      <div class="appw-nav">
        <button type="button" class="appw-nav__btn appw-nav__btn--back" id="appw-back" style="visibility: hidden;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Back
        </button>
        <span class="appw-nav__progress" id="appw-progress">Step 1 of 7</span>
        <button type="button" class="appw-nav__btn appw-nav__btn--next" id="appw-next">
          Next
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
        <button type="submit" class="appw-nav__btn appw-nav__btn--submit" id="appw-submit" style="display: none;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          Submit Application
        </button>
      </div>
    </form>
    <?php endif; ?>
  </div>
</section>

<!-- NEED HELP -->
<section class="section" style="background: var(--off-white);" id="apply-help">
  <div class="container">
    <div class="section-header fade-up">
      <div class="section-label">Assistance</div>
      <h2 class="section-title">Need Help?</h2>
      <p class="section-subtitle">If you have questions about the application process, get in touch with our admissions team.</p>
    </div>

    <div class="features-grid" style="max-width: 900px; margin: 0 auto;">
      <div class="feature-card fade-up">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </div>
        <h3>Phone</h3>
        <p>+233 302 957 663<br>+233 277 715 058</p>
      </div>

      <div class="feature-card fade-up fade-up-delay-1">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </div>
        <h3>Email</h3>
        <p><a href="mailto:info@thrivusinstitute.edu.gh" style="color: var(--primary);">info@thrivusinstitute.edu.gh</a></p>
      </div>

      <div class="feature-card fade-up fade-up-delay-2">
        <div class="feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
        <h3>Address</h3>
        <p>Constellations Avenue, Lashibi - Accra, Ghana</p>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const TOTAL_STEPS = 7;
  let current = 1;

  const wizard    = document.getElementById('apply-wizard');
  const landing   = document.getElementById('apply-landing');
  const startBtn  = document.getElementById('start-application-btn');
  const backBtn   = document.getElementById('appw-back');
  const nextBtn   = document.getElementById('appw-next');
  const submitBtn = document.getElementById('appw-submit');
  const progress  = document.getElementById('appw-progress');
  const form      = document.getElementById('appw-form');
  const panels    = document.querySelectorAll('.appw-panel');
  const steps     = document.querySelectorAll('.appw-step');

  if (!wizard || !form) return;

  // Show wizard if POST (errors or success)
  <?php if ($showWizard): ?>
  landing.style.display = 'none';
  wizard.style.display = '';
  <?php if (!empty($errors)): ?>
  // Jump to the step that likely has errors
  current = 1;
  updateWizard();
  <?php endif; ?>
  <?php endif; ?>

  // Start application button
  startBtn?.addEventListener('click', () => {
    landing.style.display = 'none';
    wizard.style.display = '';
    restoreFromStorage();
    updateWizard();
    wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  // Navigation
  nextBtn?.addEventListener('click', () => {
    if (!validateCurrentStep()) return;
    saveToStorage();
    if (current < TOTAL_STEPS) {
      current++;
      updateWizard();
      wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });

  backBtn?.addEventListener('click', () => {
    saveToStorage();
    if (current > 1) {
      current--;
      updateWizard();
      wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });

  function updateWizard() {
    // Panels
    panels.forEach(p => {
      p.classList.toggle('is-active', parseInt(p.dataset.panel) === current);
    });

    // Stepper
    steps.forEach(s => {
      const n = parseInt(s.dataset.step);
      s.classList.remove('is-active', 'is-done');
      if (n === current) s.classList.add('is-active');
      if (n < current)  s.classList.add('is-done');
    });

    // Nav buttons
    backBtn.style.visibility = current === 1 ? 'hidden' : 'visible';
    if (current === TOTAL_STEPS) {
      nextBtn.style.display = 'none';
      submitBtn.style.display = '';
      buildReview();
    } else {
      nextBtn.style.display = '';
      submitBtn.style.display = 'none';
    }
    progress.textContent = `Step ${current} of ${TOTAL_STEPS}`;
  }

  // Validate visible required fields in current step
  function validateCurrentStep() {
    const panel = document.querySelector(`.appw-panel[data-panel="${current}"]`);
    const fields = panel.querySelectorAll('[required]');
    let valid = true;

    fields.forEach(field => {
      // Skip file inputs on steps other than 6 for validation (they validate on submit)
      field.classList.remove('appw-input--error');
      if (!field.value || (field.type === 'checkbox' && !field.checked)) {
        field.classList.add('appw-input--error');
        valid = false;
      }
    });

    if (!valid) {
      const first = panel.querySelector('.appw-input--error');
      first?.focus();
      first?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return valid;
  }

  // sessionStorage persistence
  function saveToStorage() {
    const data = {};
    form.querySelectorAll('[data-save]').forEach(el => {
      if (el.name) data[el.name] = el.value;
    });
    try { sessionStorage.setItem('tibst_app', JSON.stringify(data)); } catch(e) {}
  }

  function restoreFromStorage() {
    try {
      const data = JSON.parse(sessionStorage.getItem('tibst_app'));
      if (!data) return;
      Object.entries(data).forEach(([name, value]) => {
        const el = form.querySelector(`[name="${name}"][data-save]`);
        if (el && !el.value) el.value = value;
      });
    } catch(e) {}
  }

  // Build review summary
  function buildReview() {
    const review = document.getElementById('appw-review');
    if (!review) return;

    const sections = [
      {
        title: 'Personal Information',
        fields: [
          ['First Name', 'first_name'], ['Last Name', 'last_name'], ['Middle Name', 'middle_name'],
          ['Date of Birth', 'date_of_birth'], ['Gender', 'gender'], ['Marital Status', 'marital_status'],
          ['Place of Birth', 'place_of_birth'], ['Nationality', 'nationality'],
          ['Email', 'email'], ['Phone', 'phone'],
          ['Street Address', 'street_address'], ['Address Line 2', 'address_line_2'],
          ['City', 'city'], ['State/Region', 'state_region'], ['Postal Code', 'postal_code'], ['Country', 'country']
        ]
      },
      {
        title: 'Educational Background',
        fields: [
          ['Qualification 1', 'qualification_1'], ['School & Date 1', 'school_date_1'],
          ['Qualification 2', 'qualification_2'], ['School & Date 2', 'school_date_2'],
          ['Qualification 3', 'qualification_3'], ['School & Date 3', 'school_date_3']
        ]
      },
      {
        title: 'Employment & Background',
        fields: [
          ['Currently Employed', 'currently_employed'], ['Designation', 'designation'],
          ['Employer Details', 'employer_details'],
          ['Criminal Conviction', 'criminal_conviction'], ['Conviction Details', 'conviction_details']
        ]
      },
      {
        title: 'Sponsorship & Next of Kin',
        fields: [
          ['Sponsor', 'sponsor'],
          ['Next of Kin Name', 'next_of_kin_name'], ['Next of Kin Phone', 'next_of_kin_phone'],
          ['Next of Kin Address', 'next_of_kin_address']
        ]
      },
      {
        title: 'Programme Selection',
        fields: [
          ['Programme Type', 'programme_type'], ['Programme Choice', 'programme_choice']
        ]
      }
    ];

    let html = '';
    sections.forEach(sec => {
      html += `<div class="appw-review__section"><h4>${sec.title}</h4><div class="appw-review__grid">`;
      sec.fields.forEach(([label, name]) => {
        const el = form.querySelector(`[name="${name}"]`);
        let val = el?.value || '';
        // For selects, get the text of the selected option
        if (el?.tagName === 'SELECT' && el.selectedIndex > 0) {
          val = el.options[el.selectedIndex].text;
        }
        if (val) {
          html += `<div class="appw-review__item"><span class="appw-review__label">${label}</span><span class="appw-review__value">${escapeHtml(val)}</span></div>`;
        }
      });
      html += '</div></div>';
    });

    // Documents
    const fileNames = {
      cv_file: 'CV', certificates_file: 'Certificates', transcripts_file: 'Transcripts',
      reference_file: 'Reference Letter', personal_statement_file: 'Personal Statement',
      payment_proof_file: 'Proof of Payment'
    };
    html += '<div class="appw-review__section"><h4>Documents</h4><div class="appw-review__grid">';
    Object.entries(fileNames).forEach(([name, label]) => {
      const el = form.querySelector(`[name="${name}"]`);
      const file = el?.files?.[0];
      html += `<div class="appw-review__item"><span class="appw-review__label">${label}</span><span class="appw-review__value ${file ? 'appw-review__value--ok' : 'appw-review__value--missing'}">${file ? file.name : 'Not uploaded'}</span></div>`;
    });
    html += '</div></div>';

    review.innerHTML = html;
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  // Clear storage on successful submit
  form?.addEventListener('submit', () => {
    try { sessionStorage.removeItem('tibst_app'); } catch(e) {}
  });

  updateWizard();
});
</script>

<?php require_once 'includes/footer.php'; ?>
