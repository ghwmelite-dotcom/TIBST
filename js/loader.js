/* ============================================
   Site Loader / Entrance Screen
   Shows a branded loading animation once per session.
   ============================================ */

(function () {
  'use strict';

  var LOADER_ID = 'site-loader';
  var SESSION_KEY = 'tibst_loaded';

  /** Inject loader HTML as the first child of <body> if it doesn't already exist. */
  function injectLoader() {
    if (document.getElementById(LOADER_ID)) return;

    var loader = document.createElement('div');
    loader.className = 'site-loader';
    loader.id = LOADER_ID;
    loader.innerHTML =
      '<div class="site-loader-logo">T</div>' +
      '<div class="site-loader-text">TIBST</div>';

    document.body.insertBefore(loader, document.body.firstChild);
  }

  /** Immediately hide the loader (used when session already loaded). */
  function hideLoaderInstantly() {
    var loader = document.getElementById(LOADER_ID);
    if (loader) {
      loader.style.display = 'none';
    }
  }

  /** Run the entrance animation sequence. */
  function playLoader() {
    var loader = document.getElementById(LOADER_ID);
    if (!loader) return;

    // Step 1 (100ms delay): start fade-in + text animations
    setTimeout(function () {
      loader.classList.add('animate');
    }, 100);

    // Step 2 (1300ms from start): trigger slide-up exit
    setTimeout(function () {
      loader.classList.add('done');
    }, 1300);

    // Step 3 (1800ms from start): fully remove from view
    setTimeout(function () {
      loader.style.display = 'none';
      sessionStorage.setItem(SESSION_KEY, '1');
    }, 1800);
  }

  // --- Entry point ---
  document.addEventListener('DOMContentLoaded', function () {
    injectLoader();

    if (sessionStorage.getItem(SESSION_KEY)) {
      hideLoaderInstantly();
      return;
    }

    playLoader();
  });
})();
