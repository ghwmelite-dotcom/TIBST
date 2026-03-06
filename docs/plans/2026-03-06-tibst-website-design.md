# TIBST University Website - Design Document

## Overview
Static university website for Thrivus Institute of Biomedical Sciences & Technology (TIBST), built with HTML/CSS/JS + Tailwind CSS CDN, hosted on Namecheap shared hosting.

## Branding
- Primary: #4E9B17 (green)
- Secondary: #000000 (black)
- Tagline: "Your career starts with us"
- Motto: "Prepare to be challenged"

## Tech Stack
- HTML5 + Tailwind CSS (CDN) + Vanilla JavaScript
- No build tools, deploy via FTP/File Manager
- Google Fonts for typography

## Pages

### 1. index.html (Homepage)
- Hero banner with CTA (Apply Now)
- Quick stats (programs, students, research units)
- Featured programs carousel
- News/events preview
- Testimonials
- Partners/affiliations

### 2. about.html
- Mission, vision, values
- History of TIBST
- Governing council
- Executive team
- Academic staff
- Administration

### 3. academics.html
- Programs overview
- MPhil Gene Therapy (2-3 years)
- PhD Gene Therapy (2-3 years)
- MPhil Human Embryology (2-3 years)
- PhD Human Embryology (2-3 years)
- Certificate Programmes
- Department info

### 4. admissions.html
- How to apply (step-by-step)
- Entry requirements
- Fees structure
- Financial aid & sponsorship
- 2026/2027 intake info
- Apply Now CTA

### 5. student-life.html
- Campus life overview
- Facilities
- Clubs & organizations
- Gallery grid
- Student testimonials

### 6. research.html
- Research units
- Translational Research Unit
- Research Support Units
- Research Resources
- Publications
- Partnerships

### 7. news-events.html
- News articles grid
- Upcoming events
- Announcements
- Archive

### 8. contact.html
- Contact form
- Google Maps embed (Constellations Avenue, Lashibi - Accra)
- Phone: +233 302 957 663 / +233 277715058
- Email: info@thrivusinstitute.edu.gh
- WhatsApp link
- Social media links

### 9. portal.html
- Staff login
- Student login
- Quick links to resources

### 10. library.html
- Library resources
- Catalog search
- Digital resources

## Shared Components
- Header: top info bar + main nav with dropdowns
- Footer: contact info, quick links, social media, newsletter signup
- Chatbot widget (floating, bottom-right)

## Chatbot (3-tier)
1. FAQ layer: predefined Q&A buttons (admissions, fees, programs, contact)
2. AI layer: text input with API integration (Claude/OpenAI key configurable)
3. Live chat: "Talk to a person" button (WhatsApp integration)

## File Structure
```
/
  index.html
  about.html
  academics.html
  admissions.html
  student-life.html
  research.html
  news-events.html
  contact.html
  portal.html
  library.html
  /css
    styles.css
  /js
    main.js
    chatbot.js
  /images
    (placeholder images)
  /docs
    /plans
```

## Contact Info (from existing site)
- Address: Constellations Avenue, Lashibi - Accra
- Phone: +233 302 957 663
- Mobile: +233 277715058
- Email: info@thrivusinstitute.edu.gh
- Social: Facebook, Instagram, LinkedIn, YouTube
