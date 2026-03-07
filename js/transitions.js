/* ==========================================================================
   Page Transitions - View Transitions API with Fallback
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function () {
  var TRANSITION_DURATION = 250;
  var supportsViewTransitions = typeof document.startViewTransition === 'function';

  /**
   * Determine whether a link should receive a page transition.
   * Returns the URL string if eligible, or null if it should be skipped.
   */
  function getTransitionUrl(anchor) {
    // Must be an anchor with an href
    if (!anchor || !anchor.href) return null;

    var href = anchor.getAttribute('href');

    // Skip empty, hash-only, and javascript: hrefs
    if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:')) {
      return null;
    }

    // Skip links that open in a new tab/window
    if (anchor.target === '_blank') return null;

    // Skip links explicitly marked to bypass transitions
    if (anchor.classList.contains('no-transition')) return null;

    // Skip admin links
    if (anchor.href.indexOf('/admin/') !== -1) return null;

    // Skip cross-origin links
    try {
      var linkUrl = new URL(anchor.href, window.location.origin);
      if (linkUrl.origin !== window.location.origin) return null;
      return linkUrl.href;
    } catch (e) {
      return null;
    }
  }

  /**
   * Handle click events on internal navigation links.
   */
  function handleClick(event) {
    // Allow default browser behaviour for modifier-key clicks (open in new tab)
    if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;

    // Only handle primary (left) mouse button
    if (event.button && event.button !== 0) return;

    // Walk up the DOM to find the nearest anchor element
    var anchor = event.target.closest('a');
    var url = getTransitionUrl(anchor);
    if (!url) return;

    event.preventDefault();

    if (supportsViewTransitions) {
      document.startViewTransition(function () {
        window.location.href = url;
      });
    } else {
      // Fallback: CSS opacity transition then navigate
      document.body.classList.add('page-transitioning');
      setTimeout(function () {
        window.location.href = url;
      }, TRANSITION_DURATION);
    }
  }

  // Attach a single delegated click listener
  document.addEventListener('click', handleClick);

  // Restore visibility when navigating back/forward (bfcache)
  window.addEventListener('pageshow', function (event) {
    document.body.classList.remove('page-transitioning');
    document.body.style.opacity = '1';
  });
});
