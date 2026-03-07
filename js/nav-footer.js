/* =============================================
   Nav & Footer Enhancements — nav-footer.js
   ============================================= */

document.addEventListener('DOMContentLoaded', function () {

  /* -----------------------------------------
     Feature 1: Smart Hide/Show Sticky Header
     ----------------------------------------- */
  const header = document.getElementById('main-header');

  if (header) {
    let lastScrollY = window.scrollY;
    const HIDE_THRESHOLD = 200; // px scrolled before header can hide
    const JITTER_GUARD = 5;    // ignore scroll deltas smaller than this

    function onScroll() {
      const currentY = window.scrollY;
      const delta = currentY - lastScrollY;

      // Skip tiny movements to prevent jitter
      if (Math.abs(delta) < JITTER_GUARD) return;

      // Don't hide on mobile when the nav menu is open
      const navMenu = document.querySelector('.nav-menu.active');
      const menuOpen = !!navMenu;

      // Blur effect whenever page is scrolled at all
      if (currentY > 50) {
        header.classList.add('header-blur');
      } else {
        header.classList.remove('header-blur');
      }

      // Hide/show logic
      if (delta > 0 && currentY > HIDE_THRESHOLD && !menuOpen) {
        // Scrolling DOWN past threshold — hide
        header.classList.add('header-hidden');
      } else if (delta < 0) {
        // Scrolling UP — show
        header.classList.remove('header-hidden');
      }

      lastScrollY = currentY;
    }

    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* -----------------------------------------
     Feature 2: SVG Map in Footer
     ----------------------------------------- */
  const footerContactUl = document.querySelector('.footer-grid > div:last-child .footer-links');

  if (footerContactUl) {
    const mapDiv = document.createElement('div');
    mapDiv.className = 'footer-map';
    mapDiv.innerHTML = `
      <svg viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg" class="footer-map-svg">
        <!-- Simplified Ghana outline -->
        <path d="M85 10 L120 8 L140 20 L155 15 L165 30 L170 55 L168 80 L172 100 L165 120 L155 140 L140 155 L125 170 L115 185 L100 195 L90 200 L75 195 L60 180 L50 160 L45 140 L40 115 L42 90 L48 70 L55 50 L65 35 L75 20 Z"
              fill="rgba(78,155,23,0.1)" stroke="rgba(78,155,23,0.3)" stroke-width="1.5"/>
        <!-- Accra pin -->
        <circle cx="105" cy="175" r="5" fill="#4E9B17" class="footer-map-pin"/>
        <circle cx="105" cy="175" r="10" fill="none" stroke="#4E9B17" stroke-width="1" opacity="0.4" class="footer-map-pulse"/>
        <!-- Label -->
        <text x="120" y="178" fill="rgba(255,255,255,0.5)" font-size="10" font-family="Manrope, sans-serif">Accra</text>
      </svg>
    `;
    footerContactUl.parentNode.insertBefore(mapDiv, footerContactUl);
  }

});
