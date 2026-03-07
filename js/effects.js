/* =============================================
   TIBST Visual Effects
   effects.js — Scroll splits, parallax, tilt, cursor
   ============================================= */

// ===== FEATURE 1: Scroll-Triggered Text Split Animations =====

function initTextSplit() {
  var selectors = '.section-title, .uni-hero-h1 span, .uni-hero-h1 em';
  var elements = document.querySelectorAll(selectors);

  if (!elements.length) return;

  elements.forEach(function (el) {
    var text = el.textContent.trim();
    if (!text) return;

    var words = text.split(/\s+/);
    el.innerHTML = '';

    words.forEach(function (word, i) {
      var span = document.createElement('span');
      span.className = 'text-split-word';
      span.textContent = word;
      span.style.transitionDelay = (i * 0.05) + 's';
      el.appendChild(span);

      // Add a space node between words (except after the last)
      if (i < words.length - 1) {
        el.appendChild(document.createTextNode(' '));
      }
    });
  });

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var wordSpans = entry.target.querySelectorAll('.text-split-word');
        wordSpans.forEach(function (span) {
          if (!span.classList.contains('text-split-visible')) {
            span.classList.add('text-split-visible');
          }
        });
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  elements.forEach(function (el) {
    observer.observe(el);
  });
}


// ===== FEATURE 2: Parallax Depth on Hero & Stats =====

function initParallax() {
  if (window.innerWidth <= 768 || window.matchMedia('(pointer: coarse)').matches) return;

  var targets = document.querySelectorAll('.uni-hero-bg, .stats-band-bg');
  if (!targets.length) return;

  var ticking = false;

  function updateParallax() {
    var scrollY = window.pageYOffset;

    targets.forEach(function (el) {
      var parent = el.parentElement;
      var rect = parent.getBoundingClientRect();
      var parentTop = rect.top + scrollY;
      var parentHeight = rect.height;

      // Only apply when element section is near viewport
      if (scrollY + window.innerHeight < parentTop || scrollY > parentTop + parentHeight) {
        return;
      }

      var offset = (scrollY - parentTop) * 0.3;
      el.style.transform = 'translateY(' + offset + 'px)';
    });

    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(updateParallax);
    }
  }, { passive: true });

  // Initial position
  updateParallax();

  // Disable on resize to mobile
  window.addEventListener('resize', function () {
    if (window.innerWidth <= 768) {
      targets.forEach(function (el) {
        el.style.transform = '';
      });
    }
  });
}


// ===== FEATURE 3: 3D Tilt Effect on Programme Cards =====

function initCardTilt() {
  if (window.innerWidth <= 1024) return;

  var cards = document.querySelectorAll('.prog-card-v6');
  if (!cards.length) return;

  var MAX_ROTATION = 8;

  cards.forEach(function (card) {
    card.addEventListener('mousemove', function (e) {
      var rect = card.getBoundingClientRect();
      var centerX = rect.left + rect.width / 2;
      var centerY = rect.top + rect.height / 2;

      // Normalized position from -1 to 1
      var normalizedX = (e.clientX - centerX) / (rect.width / 2);
      var normalizedY = (e.clientY - centerY) / (rect.height / 2);

      // Clamp values
      normalizedX = Math.max(-1, Math.min(1, normalizedX));
      normalizedY = Math.max(-1, Math.min(1, normalizedY));

      var rotateY = normalizedX * MAX_ROTATION;
      var rotateX = -normalizedY * MAX_ROTATION;

      // Shadow shifts in the opposite direction of tilt
      var shadowX = -normalizedX * 15;
      var shadowY = -normalizedY * 15;

      card.classList.add('tilt-active');
      card.classList.remove('tilt-reset');
      card.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg)';
      card.style.boxShadow = shadowX + 'px ' + shadowY + 'px 30px rgba(0, 0, 0, 0.12)';
    });

    card.addEventListener('mouseleave', function () {
      card.classList.remove('tilt-active');
      card.classList.add('tilt-reset');
      card.style.transform = '';
      card.style.boxShadow = '';

      // Clean up class after transition ends
      card.addEventListener('transitionend', function handler() {
        card.classList.remove('tilt-reset');
        card.removeEventListener('transitionend', handler);
      });
    });
  });

  // Disable on resize to smaller screens
  window.addEventListener('resize', function () {
    if (window.innerWidth <= 1024) {
      cards.forEach(function (card) {
        card.classList.remove('tilt-active', 'tilt-reset');
        card.style.transform = '';
        card.style.boxShadow = '';
      });
    }
  });
}


// ===== FEATURE 4: Custom Cursor on Hero & CTA =====

function initCustomCursor() {
  // Skip on touch devices
  if (window.matchMedia('(pointer: coarse)').matches) return;

  var cursorEl = document.createElement('div');
  cursorEl.className = 'custom-cursor';
  document.body.appendChild(cursorEl);

  var targetAreas = document.querySelectorAll('.uni-hero, .cta-band');
  if (!targetAreas.length) {
    cursorEl.remove();
    return;
  }

  var mouseX = 0;
  var mouseY = 0;
  var cursorX = 0;
  var cursorY = 0;
  var isInsideTarget = false;
  var isHovering = false;
  var rafId = null;
  var LERP = 0.15;

  function updateCursor() {
    cursorX += (mouseX - cursorX) * LERP;
    cursorY += (mouseY - cursorY) * LERP;

    cursorEl.style.transform = 'translate(' + cursorX + 'px, ' + cursorY + 'px) translate(-50%, -50%) scale(1)';

    if (isInsideTarget) {
      rafId = requestAnimationFrame(updateCursor);
    }
  }

  function startLoop() {
    if (rafId) return;
    rafId = requestAnimationFrame(updateCursor);
  }

  function stopLoop() {
    if (rafId) {
      cancelAnimationFrame(rafId);
      rafId = null;
    }
  }

  // Track mouse globally for smooth entry
  document.addEventListener('mousemove', function (e) {
    mouseX = e.clientX;
    mouseY = e.clientY;
  }, { passive: true });

  targetAreas.forEach(function (area) {
    area.addEventListener('mouseenter', function () {
      isInsideTarget = true;
      cursorX = mouseX;
      cursorY = mouseY;
      cursorEl.classList.add('active');
      area.classList.add('cursor-target-active');
      startLoop();
    });

    area.addEventListener('mouseleave', function () {
      isInsideTarget = false;
      cursorEl.classList.remove('active', 'cursor-hover');
      area.classList.remove('cursor-target-active');
      stopLoop();
    });

    // Detect hover over interactive elements inside target areas
    area.addEventListener('mouseover', function (e) {
      var target = e.target.closest('a, button, .btn-primary, .btn-outline-glass, .btn-white');
      if (target) {
        isHovering = true;
        cursorEl.classList.add('cursor-hover');
      }
    });

    area.addEventListener('mouseout', function (e) {
      var target = e.target.closest('a, button, .btn-primary, .btn-outline-glass, .btn-white');
      if (target) {
        isHovering = false;
        cursorEl.classList.remove('cursor-hover');
      }
    });
  });
}


// ===== INITIALIZE ALL EFFECTS =====

document.addEventListener('DOMContentLoaded', function () {
  initTextSplit();
  initParallax();
  initCardTilt();
  initCustomCursor();
});
