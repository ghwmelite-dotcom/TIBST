/* =============================================
   TIBST Dark Mode Toggle
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {
  const STORAGE_KEY = 'tibst_theme';
  const html = document.documentElement;

  // --- Create toggle button ---
  const toggle = document.createElement('button');
  toggle.className = 'dark-mode-toggle';
  toggle.setAttribute('aria-label', 'Toggle dark mode');
  toggle.type = 'button';

  // --- Insert into nav-container before hamburger ---
  const navContainer = document.querySelector('.nav-container');
  const hamburger = document.querySelector('.hamburger');

  if (navContainer) {
    if (hamburger) {
      navContainer.insertBefore(toggle, hamburger);
    } else {
      navContainer.appendChild(toggle);
    }
  }

  // --- Determine initial theme ---
  const saved = localStorage.getItem(STORAGE_KEY);
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

  function applyTheme(theme, withTransition) {
    if (withTransition) {
      html.classList.add('theme-transitioning');
    }

    html.setAttribute('data-theme', theme);

    if (withTransition) {
      setTimeout(function () {
        html.classList.remove('theme-transitioning');
      }, 400);
    }
  }

  // Set initial theme (no transition on load)
  if (saved) {
    applyTheme(saved, false);
  } else if (prefersDark.matches) {
    applyTheme('dark', false);
  } else {
    applyTheme('light', false);
  }

  // --- Toggle click handler ---
  toggle.addEventListener('click', function () {
    var current = html.getAttribute('data-theme');
    var next = current === 'dark' ? 'light' : 'dark';
    applyTheme(next, true);
    localStorage.setItem(STORAGE_KEY, next);
  });

  // --- Listen for OS preference changes (only when no manual override) ---
  prefersDark.addEventListener('change', function (e) {
    if (!localStorage.getItem(STORAGE_KEY)) {
      applyTheme(e.matches ? 'dark' : 'light', true);
    }
  });
});
