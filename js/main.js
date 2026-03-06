// ===== MOBILE NAV =====
function toggleMobileNav() {
  const nav = document.getElementById('nav-menu');
  const hamburger = document.getElementById('hamburger');
  nav.classList.toggle('active');
  hamburger.classList.toggle('open');
  document.body.style.overflow = nav.classList.contains('active') ? 'hidden' : '';
}

// Close mobile nav on link click
document.addEventListener('click', (e) => {
  if (e.target.closest('.nav-link') && window.innerWidth <= 768) {
    const nav = document.getElementById('nav-menu');
    const hamburger = document.getElementById('hamburger');
    if (nav && nav.classList.contains('active')) {
      nav.classList.remove('active');
      hamburger.classList.remove('open');
      document.body.style.overflow = '';
    }
  }
});

// ===== SCROLL ANIMATIONS =====
function initScrollAnimations() {
  const elements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  elements.forEach(el => observer.observe(el));
}

// ===== STAT COUNTER ANIMATION =====
function animateCounters() {
  const counters = document.querySelectorAll('[data-count]');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-count'));
        const suffix = el.getAttribute('data-suffix') || '';
        const prefix = el.getAttribute('data-prefix') || '';
        let current = 0;
        const duration = 2000;
        const step = target / (duration / 16);

        function update() {
          current += step;
          if (current >= target) {
            el.textContent = prefix + target.toLocaleString() + suffix;
          } else {
            el.textContent = prefix + Math.ceil(current).toLocaleString() + suffix;
            requestAnimationFrame(update);
          }
        }
        requestAnimationFrame(update);
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.3 });
  counters.forEach(el => observer.observe(el));
}

// ===== MAGNETIC BUTTON HOVER =====
function initMagneticButtons() {
  document.querySelectorAll('.btn-primary, .btn-outline-glass, .btn-white').forEach(btn => {
    btn.addEventListener('mousemove', (e) => {
      const rect = btn.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;
      btn.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = '';
    });
  });
}

// ===== STICKY HEADER =====
function initStickyHeader() {
  const header = document.getElementById('main-header');
  if (!header) return;

  let lastScroll = 0;
  window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;
    if (currentScroll > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
    lastScroll = currentScroll;
  });
}

// ===== ACTIVE NAV HIGHLIGHT =====
function highlightActiveNav() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPage || (currentPage === '' && href === 'index.html')) {
      link.classList.add('active');
    }
  });
}

// ===== ACCORDION =====
function initAccordions() {
  document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
      const item = header.parentElement;
      const isActive = item.classList.contains('active');

      // Close all
      item.parentElement.querySelectorAll('.accordion-item').forEach(i => {
        i.classList.remove('active');
      });

      // Open clicked (if wasn't already open)
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
}

// ===== SMOOTH SCROLL =====
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;
      e.preventDefault();
      const target = document.querySelector(targetId);
      if (target) {
        const headerHeight = document.getElementById('main-header')?.offsetHeight || 80;
        const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;
        window.scrollTo({ top: targetPosition, behavior: 'smooth' });
      }
    });
  });
}

// ===== BACK TO TOP =====
function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });

  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ===== HERO SLIDER =====
function initHeroSlider() {
    const slider = document.querySelector('.hero-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    const dots = slider.querySelectorAll('.slider-dot');
    const prevBtn = slider.querySelector('.slider-prev');
    const nextBtn = slider.querySelector('.slider-next');

    if (slides.length <= 1) return;

    let current = 0;
    let interval;

    function goTo(index) {
        slides[current].classList.remove('active');
        if (dots[current]) dots[current].classList.remove('active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() {
        stopAuto();
        interval = setInterval(next, 6000);
    }
    function stopAuto() { clearInterval(interval); }

    if (prevBtn) prevBtn.addEventListener('click', () => { stopAuto(); prev(); startAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { stopAuto(); next(); startAuto(); });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => { stopAuto(); goTo(i); startAuto(); });
    });

    slider.addEventListener('mouseenter', stopAuto);
    slider.addEventListener('mouseleave', startAuto);

    // Touch/swipe support
    let touchStartX = 0;
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        stopAuto();
    }, { passive: true });
    slider.addEventListener('touchend', (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            diff > 0 ? next() : prev();
        }
        startAuto();
    }, { passive: true });

    startAuto();
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', () => {
  initHeroSlider();
  initScrollAnimations();
  animateCounters();
  initStickyHeader();
  highlightActiveNav();
  initAccordions();
  initSmoothScroll();
  initBackToTop();
  initMagneticButtons();
});
