# TIBST University Website Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Build a complete static university website for Thrivus Institute of Biomedical Sciences & Technology with 10 pages and a 3-tier chatbot.

**Architecture:** Static HTML pages sharing a common header/footer injected via JavaScript includes. Tailwind CSS via CDN for styling, vanilla JS for interactivity. Chatbot is a floating widget with FAQ, AI, and live chat layers.

**Tech Stack:** HTML5, Tailwind CSS (CDN v3), vanilla JavaScript, Google Fonts (Inter + Playfair Display)

---

### Task 1: Project Setup & Folder Structure

**Files:**
- Create: `css/styles.css`
- Create: `js/main.js`
- Create: `images/.gitkeep`

**Step 1: Create directory structure**

```bash
mkdir -p css js images docs/plans
```

**Step 2: Create `css/styles.css` with custom styles and Tailwind overrides**

```css
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap');

:root {
  --primary: #4E9B17;
  --primary-dark: #3d7a12;
  --primary-light: #e8f5e0;
  --secondary: #000000;
  --white: #ffffff;
  --gray-50: #f9fafb;
  --gray-100: #f3f4f6;
  --gray-200: #e5e7eb;
  --gray-600: #4b5563;
  --gray-800: #1f2937;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  font-family: 'Inter', sans-serif;
  color: var(--gray-800);
  line-height: 1.6;
}

h1, h2, h3, h4, h5, h6 {
  font-family: 'Playfair Display', serif;
}

/* Smooth scroll */
html { scroll-behavior: smooth; }

/* Mobile nav toggle */
.nav-menu.active { display: flex !important; }

/* Dropdown */
.dropdown:hover .dropdown-menu { display: block; }
.dropdown-menu { display: none; }

/* Hero overlay */
.hero-overlay {
  background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(78,155,23,0.6) 100%);
}

/* Scroll animations */
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease;
}
.fade-in.visible {
  opacity: 1;
  transform: translateY(0);
}

/* Stat counter */
.stat-number {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary);
}

/* Card hover */
.program-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.program-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Button styles */
.btn-primary {
  background-color: var(--primary);
  color: var(--white);
  padding: 12px 32px;
  border-radius: 6px;
  font-weight: 600;
  transition: background-color 0.3s ease;
  display: inline-block;
  text-decoration: none;
}
.btn-primary:hover { background-color: var(--primary-dark); }

.btn-outline {
  border: 2px solid var(--primary);
  color: var(--primary);
  padding: 10px 30px;
  border-radius: 6px;
  font-weight: 600;
  transition: all 0.3s ease;
  display: inline-block;
  text-decoration: none;
}
.btn-outline:hover {
  background-color: var(--primary);
  color: var(--white);
}

/* Chatbot widget */
.chatbot-toggle {
  position: fixed;
  bottom: 24px;
  right: 24px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-color: var(--primary);
  color: white;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 15px rgba(78,155,23,0.4);
  z-index: 1000;
  font-size: 1.5rem;
  transition: transform 0.3s ease;
}
.chatbot-toggle:hover { transform: scale(1.1); }

.chatbot-window {
  position: fixed;
  bottom: 100px;
  right: 24px;
  width: 380px;
  max-height: 500px;
  background: white;
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.2);
  z-index: 999;
  display: none;
  flex-direction: column;
  overflow: hidden;
}
.chatbot-window.active { display: flex; }

/* Section spacing */
.section { padding: 80px 0; }
.section-title {
  font-size: 2rem;
  margin-bottom: 1rem;
  position: relative;
}
.section-title::after {
  content: '';
  display: block;
  width: 60px;
  height: 4px;
  background-color: var(--primary);
  margin-top: 10px;
}

/* Timeline */
.timeline-item {
  border-left: 3px solid var(--primary);
  padding-left: 20px;
  margin-bottom: 30px;
  position: relative;
}
.timeline-item::before {
  content: '';
  width: 12px;
  height: 12px;
  background: var(--primary);
  border-radius: 50%;
  position: absolute;
  left: -7.5px;
  top: 0;
}

/* Gallery grid */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 16px;
}

/* Form styles */
.form-input {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid var(--gray-200);
  border-radius: 8px;
  font-family: 'Inter', sans-serif;
  transition: border-color 0.3s ease;
}
.form-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(78,155,23,0.1);
}

/* Responsive */
@media (max-width: 768px) {
  .section { padding: 50px 0; }
  .stat-number { font-size: 2rem; }
  .chatbot-window { width: calc(100% - 32px); right: 16px; }
}
```

**Step 3: Create `js/main.js` with core functionality**

```javascript
// Mobile nav toggle
function toggleMobileNav() {
  const nav = document.getElementById('nav-menu');
  const hamburger = document.getElementById('hamburger');
  nav.classList.toggle('active');
  hamburger.classList.toggle('open');
}

// Scroll animations
function initScrollAnimations() {
  const elements = document.querySelectorAll('.fade-in');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });
  elements.forEach(el => observer.observe(el));
}

// Stat counter animation
function animateCounters() {
  const counters = document.querySelectorAll('.stat-number');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = parseInt(entry.target.getAttribute('data-target'));
        const suffix = entry.target.getAttribute('data-suffix') || '';
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            entry.target.textContent = target + suffix;
            clearInterval(timer);
          } else {
            entry.target.textContent = Math.ceil(current) + suffix;
          }
        }, 30);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(el => observer.observe(el));
}

// Sticky header
function initStickyHeader() {
  const header = document.getElementById('main-header');
  if (!header) return;
  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      header.classList.add('shadow-lg');
    } else {
      header.classList.remove('shadow-lg');
    }
  });
}

// Smooth scroll for anchor links
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
}

// Load shared header and footer
async function loadComponent(id, file) {
  try {
    const response = await fetch(file);
    if (response.ok) {
      const html = await response.text();
      document.getElementById(id).innerHTML = html;
    }
  } catch (e) {
    console.warn('Component load failed:', file);
  }
}

// Init
document.addEventListener('DOMContentLoaded', () => {
  initScrollAnimations();
  animateCounters();
  initStickyHeader();
  initSmoothScroll();

  // Highlight active nav link
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-link').forEach(link => {
    if (link.getAttribute('href') === currentPage) {
      link.classList.add('text-green-600', 'font-semibold');
    }
  });
});
```

**Step 4: Verify files exist**

```bash
ls -la css/ js/ images/
```

---

### Task 2: Homepage (index.html)

**Files:**
- Create: `index.html`

**Step 1: Build `index.html`**

Full homepage with: Tailwind CDN link, top info bar, navigation with dropdowns, hero section with overlay and CTA, stats section, featured programs cards, why choose us section, news/events preview, testimonials, partners section, footer with newsletter, chatbot widget placeholder.

All content uses real TIBST data: program names, contact info, address, tagline.

**Step 2: Open in browser and verify**

```bash
# Open in default browser to verify
start index.html
```

---

### Task 3: About Page (about.html)

**Files:**
- Create: `about.html`

**Step 1: Build `about.html`**

Sections: hero banner, mission/vision/values cards, history timeline, governing council grid, executive team cards, academic staff listing, administration section. Same header/footer as homepage.

---

### Task 4: Academics Page (academics.html)

**Files:**
- Create: `academics.html`

**Step 1: Build `academics.html`**

Sections: hero banner, programs overview intro, program cards (MPhil Gene Therapy, PhD Gene Therapy, MPhil Human Embryology, PhD Human Embryology, Certificate Programmes), each with duration/description/requirements/CTA. Department info section.

---

### Task 5: Admissions Page (admissions.html)

**Files:**
- Create: `admissions.html`

**Step 1: Build `admissions.html`**

Sections: hero banner, "How to Apply" step-by-step timeline, entry requirements accordion, fees structure table, financial aid & sponsorship info, 2026/2027 intake banner, Apply Now CTA with link to portal.

---

### Task 6: Student Life Page (student-life.html)

**Files:**
- Create: `student-life.html`

**Step 1: Build `student-life.html`**

Sections: hero banner, campus life overview with icons, facilities grid, clubs & organizations, photo gallery grid (placeholder images via placehold.co), student testimonials carousel.

---

### Task 7: Research Page (research.html)

**Files:**
- Create: `research.html`

**Step 1: Build `research.html`**

Sections: hero banner, research overview, research units cards (Translational Research Unit, Support Units), research resources, publications list, partnerships/collaborations section.

---

### Task 8: News & Events Page (news-events.html)

**Files:**
- Create: `news-events.html`

**Step 1: Build `news-events.html`**

Sections: hero banner, news articles grid (card layout with image/title/date/excerpt), upcoming events list with dates, announcements section, archive link.

---

### Task 9: Contact Page (contact.html)

**Files:**
- Create: `contact.html`

**Step 1: Build `contact.html`**

Sections: hero banner, two-column layout (contact form on left, info on right), Google Maps iframe embed for Constellations Avenue Lashibi Accra, phone numbers, email, WhatsApp button, social media links, office hours.

---

### Task 10: Portal Page (portal.html)

**Files:**
- Create: `portal.html`

**Step 1: Build `portal.html`**

Sections: hero banner, two-column login cards (Student Portal, Staff Portal) each with username/password fields, quick links to resources (email, LMS, library, timetable).

---

### Task 11: Library Page (library.html)

**Files:**
- Create: `library.html`

**Step 1: Build `library.html`**

Sections: hero banner, library overview, catalog search bar, digital resources grid, library hours, borrowing policies, contact librarian section.

---

### Task 12: Chatbot Widget (js/chatbot.js)

**Files:**
- Create: `js/chatbot.js`

**Step 1: Build the 3-tier chatbot**

```javascript
// chatbot.js - 3-tier chatbot: FAQ + AI + Live Chat

const CHATBOT_FAQ = [
  {
    question: "How do I apply?",
    answer: "Visit our Admissions page or click <a href='admissions.html' class='text-green-600 underline'>here</a>. You can also apply through our <a href='portal.html' class='text-green-600 underline'>Student Portal</a>."
  },
  {
    question: "What programs do you offer?",
    answer: "We offer MPhil & PhD in Gene Therapy, MPhil & PhD in Human Embryology, and Certificate Programmes. Visit <a href='academics.html' class='text-green-600 underline'>Academics</a> for details."
  },
  {
    question: "What are the fees?",
    answer: "Fee details vary by program. Visit our <a href='admissions.html' class='text-green-600 underline'>Admissions page</a> for the full fee structure, or contact us at info@thrivusinstitute.edu.gh."
  },
  {
    question: "How can I contact TIBST?",
    answer: "Phone: +233 302 957 663 | Mobile: +233 277715058 | Email: info@thrivusinstitute.edu.gh | Address: Constellations Avenue, Lashibi - Accra"
  },
  {
    question: "When is the next intake?",
    answer: "The 2026/2027 academic year admissions are currently open. Apply now through our portal!"
  },
  {
    question: "Is financial aid available?",
    answer: "Yes! We offer financial aid and sponsorship options. Visit our <a href='admissions.html#financial-aid' class='text-green-600 underline'>Financial Aid section</a> for eligibility and application details."
  }
];

class TIBSTChatbot {
  constructor() {
    this.isOpen = false;
    this.currentMode = 'faq'; // faq | ai | live
    this.messages = [];
    this.apiKey = null; // Set via config for AI mode
    this.init();
  }

  init() {
    this.render();
    this.bindEvents();
    this.addBotMessage("Hello! Welcome to TIBST. How can I help you today?");
    this.showFAQButtons();
  }

  render() {
    // Creates toggle button and chat window HTML
    // Injects into DOM
  }

  showFAQButtons() {
    // Renders FAQ quick-reply buttons
  }

  async handleAIQuery(message) {
    // Sends to AI API (Claude/OpenAI) with university context
    // Falls back to "I don't have that info" if no API key
  }

  openLiveChat() {
    // Opens WhatsApp link: https://wa.me/233277715058
    window.open('https://wa.me/233277715058', '_blank');
  }

  addBotMessage(text) { /* append to chat */ }
  addUserMessage(text) { /* append to chat */ }
  bindEvents() { /* toggle, send, FAQ clicks */ }
}

// Auto-init on page load
document.addEventListener('DOMContentLoaded', () => {
  window.tibstChatbot = new TIBSTChatbot();
});
```

**Step 2: Include chatbot.js in all HTML pages**

Add `<script src="js/chatbot.js"></script>` before `</body>` in every page.

---

### Task 13: Final Polish & Cross-Page Testing

**Files:**
- Modify: All HTML files

**Step 1: Verify all navigation links work across pages**
**Step 2: Test responsive design at mobile/tablet/desktop widths**
**Step 3: Ensure consistent header/footer across all pages**
**Step 4: Test chatbot on every page**
**Step 5: Verify all placeholder images load**
