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
  <section class="section" style="background: var(--off-white);">
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
          <p>Complete the online form below with all required documents and proof of payment. Applications submitted without proof of payment will not be processed.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- APPLICATION FORM -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Online Application</div>
        <h2 class="section-title">Application Form</h2>
        <p class="section-subtitle">Fill out the form below to apply to TIBST. Ensure all required fields are completed and supporting documents are attached.</p>
      </div>

      <div class="fade-up" style="max-width: 900px; margin: 0 auto;">

        <?php if ($success): ?>
          <div style="background: #f0fdf4; border: 2px solid #bbf7d0; border-radius: 12px; padding: 2rem; text-align: center; margin-bottom: 2rem;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" style="margin-bottom: 1rem;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <h3 style="color: #166534; margin-bottom: 0.5rem;">Application Submitted Successfully!</h3>
            <p style="color: #15803d;">Thank you for applying to TIBST. Your application has been received and is now under review. We will contact you at the email address you provided with further instructions.</p>
          </div>
        <?php else: ?>

          <?php if (!empty($errors)): ?>
            <div style="background: #fef2f2; border: 2px solid #fecaca; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
              <h4 style="color: #991b1b; margin-bottom: 0.5rem;">Please fix the following errors:</h4>
              <ul style="color: #b91c1c; margin-left: 1.25rem;">
                <?php foreach ($errors as $error): ?>
                  <li><?= escape($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST" action="apply.php" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 2rem;">
            <?= csrfField() ?>

            <!-- ─── Personal Information ──────────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Personal Information</legend>

              <div style="margin-bottom: 1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Passport Photo <span style="color:#999; font-weight:400;">(optional)</span></label>
                <input type="file" name="photo" accept="image/*" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px;">
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">First Name *</label>
                  <input type="text" name="first_name" required value="<?= escape($_POST['first_name'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Last Name *</label>
                  <input type="text" name="last_name" required value="<?= escape($_POST['last_name'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Middle Name</label>
                  <input type="text" name="middle_name" value="<?= escape($_POST['middle_name'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Date of Birth *</label>
                  <input type="date" name="date_of_birth" required value="<?= escape($_POST['date_of_birth'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Gender *</label>
                  <select name="gender" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <option value="Male" <?= ($_POST['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= ($_POST['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
                  </select>
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Marital Status</label>
                  <select name="marital_status" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <option value="Single" <?= ($_POST['marital_status'] ?? '') === 'Single' ? 'selected' : '' ?>>Single</option>
                    <option value="Married" <?= ($_POST['marital_status'] ?? '') === 'Married' ? 'selected' : '' ?>>Married</option>
                    <option value="Divorced" <?= ($_POST['marital_status'] ?? '') === 'Divorced' ? 'selected' : '' ?>>Divorced</option>
                    <option value="Widowed" <?= ($_POST['marital_status'] ?? '') === 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                  </select>
                </div>
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Place of Birth *</label>
                  <input type="text" name="place_of_birth" required value="<?= escape($_POST['place_of_birth'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Nationality *</label>
                  <input type="text" name="nationality" required value="<?= escape($_POST['nationality'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Email Address *</label>
                  <input type="email" name="email" required value="<?= escape($_POST['email'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Phone Number *</label>
                  <input type="tel" name="phone" required value="<?= escape($_POST['phone'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="margin-top: 1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Street Address *</label>
                <input type="text" name="street_address" required value="<?= escape($_POST['street_address'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
              </div>
              <div style="margin-top: 0.75rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Address Line 2</label>
                <input type="text" name="address_line_2" value="<?= escape($_POST['address_line_2'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.75rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">City *</label>
                  <input type="text" name="city" required value="<?= escape($_POST['city'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">State / Region</label>
                  <input type="text" name="state_region" value="<?= escape($_POST['state_region'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Postal Code</label>
                  <input type="text" name="postal_code" value="<?= escape($_POST['postal_code'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Country *</label>
                  <input type="text" name="country" required value="<?= escape($_POST['country'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>
            </fieldset>

            <!-- ─── Educational Background ────────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Educational Background</legend>

              <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 1rem;">List your educational qualifications starting with the most recent. At least one qualification is required.</p>

              <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Qualification / Degree 1 *</label>
                  <input type="text" name="qualification_1" required placeholder="e.g. BSc Biomedical Science" value="<?= escape($_POST['qualification_1'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">School / Institution & Date 1 *</label>
                  <input type="text" name="school_date_1" required placeholder="e.g. University of Ghana, 2020" value="<?= escape($_POST['school_date_1'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Qualification / Degree 2</label>
                  <input type="text" name="qualification_2" value="<?= escape($_POST['qualification_2'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">School / Institution & Date 2</label>
                  <input type="text" name="school_date_2" value="<?= escape($_POST['school_date_2'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Qualification / Degree 3</label>
                  <input type="text" name="qualification_3" value="<?= escape($_POST['qualification_3'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">School / Institution & Date 3</label>
                  <input type="text" name="school_date_3" value="<?= escape($_POST['school_date_3'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>
            </fieldset>

            <!-- ─── Employment & Background ───────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Employment & Background</legend>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Are you currently employed? *</label>
                  <select name="currently_employed" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <option value="Yes" <?= ($_POST['currently_employed'] ?? '') === 'Yes' ? 'selected' : '' ?>>Yes</option>
                    <option value="No" <?= ($_POST['currently_employed'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                  </select>
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Designation / Job Title</label>
                  <input type="text" name="designation" value="<?= escape($_POST['designation'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="margin-top: 1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Employer Name & Address <span style="color:#999; font-weight:400;">(if employed)</span></label>
                <textarea name="employer_details" rows="2" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; resize:vertical;"><?= escape($_POST['employer_details'] ?? '') ?></textarea>
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Have you ever been convicted of a criminal offence? *</label>
                  <select name="criminal_conviction" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <option value="No" <?= ($_POST['criminal_conviction'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                    <option value="Yes" <?= ($_POST['criminal_conviction'] ?? '') === 'Yes' ? 'selected' : '' ?>>Yes</option>
                  </select>
                </div>
              </div>

              <div style="margin-top: 0.75rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">If yes, please provide details</label>
                <textarea name="conviction_details" rows="2" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; resize:vertical;"><?= escape($_POST['conviction_details'] ?? '') ?></textarea>
              </div>
            </fieldset>

            <!-- ─── Sponsorship & Next of Kin ─────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Sponsorship & Next of Kin</legend>

              <div style="margin-bottom: 1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Who is sponsoring your studies? *</label>
                <select name="sponsor" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                  <option value="">Select...</option>
                  <option value="Self" <?= ($_POST['sponsor'] ?? '') === 'Self' ? 'selected' : '' ?>>Self</option>
                  <option value="Parent" <?= ($_POST['sponsor'] ?? '') === 'Parent' ? 'selected' : '' ?>>Parent / Guardian</option>
                  <option value="Employer" <?= ($_POST['sponsor'] ?? '') === 'Employer' ? 'selected' : '' ?>>Employer</option>
                  <option value="Other" <?= ($_POST['sponsor'] ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
              </div>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Next of Kin Full Name *</label>
                  <input type="text" name="next_of_kin_name" required value="<?= escape($_POST['next_of_kin_name'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Next of Kin Phone *</label>
                  <input type="tel" name="next_of_kin_phone" required value="<?= escape($_POST['next_of_kin_phone'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
                </div>
              </div>

              <div style="margin-top: 1rem;">
                <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Next of Kin Address *</label>
                <input type="text" name="next_of_kin_address" required value="<?= escape($_POST['next_of_kin_address'] ?? '') ?>" style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem;">
              </div>
            </fieldset>

            <!-- ─── Programme Selection ───────────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Programme Selection</legend>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Programme Type *</label>
                  <select name="programme_type" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <option value="postgraduate" <?= ($_POST['programme_type'] ?? '') === 'postgraduate' ? 'selected' : '' ?>>Postgraduate (MPhil / PhD)</option>
                    <option value="certificate" <?= ($_POST['programme_type'] ?? '') === 'certificate' ? 'selected' : '' ?>>Certificate Programme</option>
                  </select>
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Programme Choice *</label>
                  <select name="programme_choice" required style="width:100%; padding:0.6rem 0.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; background:#fff;">
                    <option value="">Select...</option>
                    <?php foreach ($programmes as $prog): ?>
                      <option value="<?= escape($prog['title'] . ' - ' . $prog['degree_type']) ?>" <?= ($_POST['programme_choice'] ?? '') === $prog['title'] . ' - ' . $prog['degree_type'] ? 'selected' : '' ?>><?= escape($prog['title'] . ' (' . $prog['degree_type'] . ')') ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </fieldset>

            <!-- ─── Required Documents ────────────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Required Documents</legend>

              <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 1rem;">Upload all required documents. Accepted formats: PDF, DOC, DOCX, JPG, PNG (max 10 MB each).</p>

              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Curriculum Vitae (CV) *</label>
                  <input type="file" name="cv_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Certificates *</label>
                  <input type="file" name="certificates_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Academic Transcripts *</label>
                  <input type="file" name="transcripts_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Reference Letter *</label>
                  <input type="file" name="reference_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Personal Statement *</label>
                  <input type="file" name="personal_statement_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
                <div>
                  <label style="display:block; font-weight:600; margin-bottom:0.35rem; font-size:0.9rem;">Proof of Payment *</label>
                  <input type="file" name="payment_proof_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp" style="width:100%; padding:0.5rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.9rem;">
                </div>
              </div>
            </fieldset>

            <!-- ─── Declaration ───────────────────────────────────── -->
            <fieldset style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 1.5rem;">
              <legend style="font-family: var(--font-mono, monospace); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--primary); padding: 0 0.75rem; font-weight: 600;">// Declaration</legend>

              <label style="display: flex; gap: 0.75rem; align-items: flex-start; cursor: pointer;">
                <input type="checkbox" name="agreed_terms" required style="margin-top: 0.25rem; width: 18px; height: 18px; accent-color: var(--primary);">
                <span style="font-size: 0.9rem; line-height: 1.5; color: #374151;">
                  I declare that the information provided in this application is true and correct to the best of my knowledge. I understand that any false or misleading information may result in the rejection of my application or dismissal from the institute. I agree to abide by the rules, regulations, and policies of the Thrivus Institute of Biomedical Science and Technology.
                </span>
              </label>
            </fieldset>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1.05rem;">Submit Application</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- NEED HELP -->
  <section class="section" style="background: var(--off-white);">
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

<?php require_once 'includes/footer.php'; ?>
