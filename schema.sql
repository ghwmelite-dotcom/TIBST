-- TIBST CMS Database Schema
-- Character set: utf8mb4

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- --------------------------------------------------------
-- Users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Hero Slides
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS hero_slides (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Programmes
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS programmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    degree_type VARCHAR(50) NOT NULL,
    description TEXT,
    duration VARCHAR(50),
    image VARCHAR(500),
    is_featured TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- News
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    publish_date DATE NOT NULL,
    excerpt TEXT,
    body LONGTEXT,
    image VARCHAR(500),
    is_published TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Testimonials
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote TEXT NOT NULL,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(150),
    initials VARCHAR(5),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Staff
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(150),
    bio TEXT,
    photo VARCHAR(500),
    department VARCHAR(100),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Settings
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Page Blocks
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS page_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page VARCHAR(50) NOT NULL,
    block_id VARCHAR(50) NOT NULL,
    content LONGTEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY page_block (page, block_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Default Settings
-- =========================================================
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Thrivus Institute of Biomedical Science and Technology'),
('site_short_name', 'TIBST'),
('phone', '+233 302 957 663'),
('mobile', '+233 277 715 058'),
('email', 'info@thrivusinstitute.edu.gh'),
('address', 'Constellations Avenue, Lashibi - Accra, Ghana'),
('facebook', 'https://www.facebook.com/thrivusinstitute'),
('instagram', 'https://www.instagram.com/thrivusinstitute'),
('linkedin', 'https://www.linkedin.com/company/thrivusinstitute'),
('youtube', 'https://www.youtube.com/@thrivusinstitute'),
('whatsapp', 'https://wa.me/233277715058'),
('gdrive_api_key', ''),
('gdrive_folder_id', '11FR2Wo7SDOhI30H59agJK-qBE41cYcx3'),
('site_logo', ''),
('site_favicon', '');

-- =========================================================
-- Seed Data: Hero Slide
-- =========================================================
INSERT INTO hero_slides (image, headline_1, headline_2, headline_3, subtitle, cta_text, cta_link, sort_order, is_active) VALUES
('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80', 'Shaping the Future of', '', 'Biomedical Science', 'TIBST is a premier institution dedicated to advancing biomedical science education and research in Ghana and beyond.', 'Apply Now', 'admissions.php', 1, 1),
('https://images.unsplash.com/photo-1576086213369-97a306d36557?w=1920&q=80', 'World-Class Research in', '', 'Gene Therapy', 'Our cutting-edge programmes equip the next generation of scientists with the skills to revolutionise genetic medicine.', 'Explore Programmes', 'academics.php', 2, 1),
('https://images.unsplash.com/photo-1559757175-5700dde675bc?w=1920&q=80', 'Admissions Open for', '', '2026/2027', 'Join a vibrant community of researchers and scholars pushing the boundaries of biomedical science and technology.', 'Apply Now', 'apply.php', 3, 1);

-- =========================================================
-- Seed Data: Programmes
-- =========================================================
INSERT INTO programmes (title, degree_type, description, duration, image, is_featured, sort_order) VALUES
('Gene Therapy', 'MPhil', 'Explore cutting-edge gene therapy techniques and their applications in modern medicine. This programme prepares graduates for careers in genetic research and clinical gene therapy.', '2 years', NULL, 1, 1),
('Gene Therapy', 'PhD', 'Conduct advanced research in gene therapy, contributing original knowledge to the field. This doctoral programme is designed for candidates seeking to lead innovation in genetic medicine.', '3-4 years', NULL, 0, 2),
('Human Embryology', 'MPhil', 'Study the science of human embryonic development and reproductive biology. This programme equips students with expertise in embryology research and assisted reproduction technologies.', '2 years', NULL, 0, 3);

-- =========================================================
-- Seed Data: News
-- =========================================================
INSERT INTO news (title, slug, publish_date, excerpt, body, image, is_published) VALUES
('TIBST Opens Applications for 2026/2027 Academic Year', 'tibst-opens-applications-2026-2027', '2026-03-01', 'The Thrivus Institute of Biomedical Science and Technology is now accepting applications for the upcoming academic year.', '<p>The Thrivus Institute of Biomedical Science and Technology (TIBST) is pleased to announce that applications are now open for the 2026/2027 academic year. Prospective students are invited to apply for our MPhil and PhD programmes in Gene Therapy and Human Embryology.</p><p>Applicants should hold a relevant first degree and demonstrate a strong interest in biomedical research. Scholarships and financial aid options are available for qualifying candidates.</p>', NULL, 1),
('New Research Partnership with Leading Biomedical Lab', 'new-research-partnership-biomedical-lab', '2026-03-03', 'TIBST has signed a memorandum of understanding with a leading biomedical research laboratory to enhance collaborative research.', '<p>TIBST is proud to announce a new research partnership that will strengthen our commitment to world-class biomedical research. The memorandum of understanding was signed in a ceremony attended by faculty, students, and partners.</p><p>This collaboration will provide our students and researchers with access to advanced laboratory facilities and joint research opportunities in gene therapy and regenerative medicine.</p>', NULL, 1),
('Guest Lecture Series on Advances in Gene Therapy', 'guest-lecture-series-gene-therapy', '2026-03-05', 'TIBST will host a series of guest lectures featuring internationally renowned experts in gene therapy and molecular biology.', '<p>The Thrivus Institute is excited to announce an upcoming guest lecture series focused on the latest advances in gene therapy. The series will feature presentations from leading researchers and clinicians from around the world.</p><p>Topics will include CRISPR-based therapies, viral vector design, and clinical trials for genetic disorders. All students, faculty, and members of the public are welcome to attend.</p>', NULL, 1);

-- =========================================================
-- Seed Data: Testimonials
-- =========================================================
INSERT INTO testimonials (quote, name, role, initials, sort_order, is_active) VALUES
('TIBST has provided me with an exceptional learning environment. The faculty are dedicated, the research facilities are outstanding, and the curriculum is truly world-class.', 'Dr. Ama Kusi', 'MPhil Gene Therapy Graduate', 'AK', 1, 1),
('Studying at TIBST transformed my understanding of biomedical science. The hands-on research experience and mentorship I received were invaluable for my career.', 'Kwame Mensah', 'PhD Candidate, Gene Therapy', 'KM', 2, 1),
('The Human Embryology programme at TIBST is rigorous and deeply rewarding. I feel well-prepared to contribute meaningfully to reproductive science research.', 'Dr. Efua Aidoo', 'MPhil Human Embryology Graduate', 'EA', 3, 1);

-- --------------------------------------------------------
-- Applications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Personal Info
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    date_of_birth DATE NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    place_of_birth VARCHAR(150) NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    street_address VARCHAR(255) NOT NULL,
    address_line_2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state_region VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) NOT NULL,
    marital_status VARCHAR(20),
    photo VARCHAR(500),
    -- Education
    qualification_1 VARCHAR(255) NOT NULL,
    school_date_1 VARCHAR(255) NOT NULL,
    qualification_2 VARCHAR(255),
    school_date_2 VARCHAR(255),
    qualification_3 VARCHAR(255),
    school_date_3 VARCHAR(255),
    -- Employment
    currently_employed ENUM('Yes', 'No') NOT NULL,
    designation VARCHAR(255),
    employer_details TEXT,
    criminal_conviction ENUM('Yes', 'No') NOT NULL,
    conviction_details TEXT,
    -- Sponsorship
    sponsor ENUM('Self', 'Parent', 'Employer', 'Other') NOT NULL,
    next_of_kin_name VARCHAR(150) NOT NULL,
    next_of_kin_address VARCHAR(255) NOT NULL,
    next_of_kin_phone VARCHAR(50) NOT NULL,
    -- Programme
    programme_type ENUM('postgraduate', 'certificate') NOT NULL,
    programme_choice VARCHAR(255) NOT NULL,
    -- File uploads
    cv_file VARCHAR(500) NOT NULL,
    certificates_file VARCHAR(500) NOT NULL,
    transcripts_file VARCHAR(500) NOT NULL,
    reference_file VARCHAR(500) NOT NULL,
    personal_statement_file VARCHAR(500) NOT NULL,
    payment_proof_file VARCHAR(500) NOT NULL,
    -- Meta
    status ENUM('pending', 'reviewed', 'accepted', 'rejected') DEFAULT 'pending',
    admin_notes TEXT,
    agreed_terms TINYINT(1) DEFAULT 0,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Library Users (E-Library access control)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS library_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    is_approved TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
