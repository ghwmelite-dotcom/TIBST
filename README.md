<div align="center">

# 🧬 TIBST — Thrivus Institute of Biomedical Sciences & Technology

### *"Your career starts with us"*

[![Website](https://img.shields.io/badge/Website-thrivusinstitute.edu.gh-4E9B17?style=for-the-badge&logo=google-chrome&logoColor=white)](https://thrivusinstitute.edu.gh)
[![License](https://img.shields.io/badge/License-All%20Rights%20Reserved-000000?style=for-the-badge)](LICENSE)
[![Pages](https://img.shields.io/badge/Pages-10-4E9B17?style=for-the-badge)]()
[![Status](https://img.shields.io/badge/Status-Live-brightgreen?style=for-the-badge)]()

<br>

<img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=900&q=80" alt="TIBST Campus" width="100%" style="border-radius: 12px;" />

<br>

**Shaping the future of biomedical science through innovative research and world-class postgraduate education.**

*Constellations Avenue, Lashibi — Accra, Ghana*

---

</div>

## 📋 Overview

The official website for **Thrivus Institute of Biomedical Sciences & Technology (TIBST)** — a premier postgraduate institution in Ghana dedicated to advancing biomedical science through cutting-edge research in **Gene Therapy** and **Human Embryology**.

Built as a fast, responsive, static website optimized for deployment on shared hosting (Namecheap).

<br>

## 🏗️ Tech Stack

| Layer | Technology |
|:------|:-----------|
| **Structure** | HTML5 (Semantic) |
| **Styling** | Custom CSS3 + CSS Variables |
| **Typography** | [Cormorant Garamond](https://fonts.google.com/specimen/Cormorant+Garamond) + [Outfit](https://fonts.google.com/specimen/Outfit) |
| **Interactivity** | Vanilla JavaScript (ES6+) |
| **Icons** | Inline SVG |
| **Hosting** | Namecheap Shared Hosting (Static) |
| **Build Tools** | None — zero dependencies, zero build step |

<br>

## 📄 Site Map

```
TIBST Website
│
├── 🏠 index.html           Homepage — hero, stats, programs, testimonials
├── 🏛️ about.html            Mission, vision, history, leadership team
├── 🎓 academics.html        Postgraduate & certificate programmes
├── 📝 admissions.html       How to apply, fees, financial aid
├── 🎭 student-life.html     Campus life, clubs, photo gallery
├── 🔬 research.html         Research units, publications, partnerships
├── 📰 news-events.html      News articles, events, announcements
├── 📞 contact.html          Contact form, map, WhatsApp
├── 🔐 portal.html           Student & staff login portals
├── 📚 library.html          Digital resources, catalog, policies
│
├── 📁 css/
│   └── styles.css           Complete design system (700+ lines)
│
├── 📁 js/
│   ├── main.js              Animations, counters, accordion, nav
│   └── chatbot.js           3-tier chatbot engine
│
└── 📁 docs/plans/
    ├── *-design.md           Design document
    └── *-implementation.md   Implementation plan
```

<br>

## ✨ Key Features

### 🎨 Design
- **Scientific Editorial** aesthetic — elegant serif typography meets modern biomedical design
- **Branding** — `#4E9B17` (life green) + `#000000` (authority black) with `#C5E063` accents
- **Fully responsive** — mobile-first, works on all screen sizes
- **Scroll animations** — fade-up reveals with staggered delays
- **DNA-inspired patterns** — subtle animated background motifs

### 💬 3-Tier Chatbot
| Layer | Function |
|:------|:---------|
| **FAQ** | Quick-reply buttons for common questions (admissions, fees, programs) |
| **AI Assistant** | Text input with OpenAI/Anthropic API integration (plug in your API key) |
| **Live Chat** | WhatsApp integration for direct staff communication |

### ⚡ Performance
- Zero framework dependencies — pure HTML/CSS/JS
- No build step required
- Optimized for shared hosting environments
- Lazy scroll animations via Intersection Observer

<br>

## 🚀 Deployment

### Namecheap (Shared Hosting)

1. Log in to your Namecheap cPanel
2. Open **File Manager** → navigate to `public_html`
3. Upload all files maintaining the folder structure:
   ```
   public_html/
   ├── index.html
   ├── about.html
   ├── ... (all .html files)
   ├── css/styles.css
   └── js/main.js, chatbot.js
   ```
4. Your site is live! 🎉

### Local Development

```bash
# Clone the repository
git clone https://github.com/ghwmelite-dotcom/TIBST.git
cd TIBST

# Open in browser (no server needed)
open index.html        # macOS
start index.html       # Windows
xdg-open index.html    # Linux
```

<br>

## 🤖 Chatbot Configuration

The chatbot works out-of-the-box with FAQ mode. To enable the **AI Assistant** mode:

```html
<!-- Add before </body> in any page -->
<script>
  // For OpenAI
  configureChatbotAPI('your-openai-api-key', 'openai');

  // OR for Anthropic (Claude)
  configureChatbotAPI('your-anthropic-api-key', 'anthropic');
</script>
```

> ⚠️ **Note:** API keys in client-side code are visible to users. For production, consider routing through a serverless function or backend proxy.

<br>

## 🎓 Programmes Offered

| Programme | Degree | Duration |
|:----------|:-------|:---------|
| Gene Therapy | MPhil | 2–3 years |
| Gene Therapy | PhD | 2–3 years |
| Human Embryology | MPhil | 2–3 years |
| Human Embryology | PhD | 2–3 years |
| Assisted Reproductive Technology | Certificate | 6–12 months |
| Molecular Diagnostics | Certificate | 6–12 months |
| Biomedical Research Methods | Certificate | 6–12 months |

<br>

## 📬 Contact

| Channel | Details |
|:--------|:--------|
| 📍 **Address** | Constellations Avenue, Lashibi — Accra, Ghana |
| 📞 **Phone** | +233 302 957 663 |
| 📱 **Mobile** | +233 277 715 058 |
| ✉️ **Email** | info@thrivusinstitute.edu.gh |
| 💬 **WhatsApp** | [Chat with us](https://wa.me/233277715058) |

<br>

---

<div align="center">

**Built with ❤️ for TIBST**

*© 2026 Thrivus Institute of Biomedical Sciences & Technology. All rights reserved.*

</div>
