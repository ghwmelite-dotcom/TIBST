/**
 * Enhanced Timeline Animation
 * - Progress line that draws as you scroll
 * - Cards slide in with IntersectionObserver
 * - Markers pulse when activated
 */
document.addEventListener('DOMContentLoaded', function () {
  const timeline = document.querySelector('.timeline');
  if (!timeline) return;

  // --- Inject progress line element ---
  const progressLine = document.createElement('div');
  progressLine.className = 'timeline-progress-line';
  timeline.insertBefore(progressLine, timeline.firstChild);

  // --- Gather timeline items ---
  const items = Array.from(timeline.querySelectorAll('.timeline-item'));
  if (items.length === 0) return;

  // Track which items have been activated
  const activated = new Set();
  let pendingActivations = [];
  let staggerTimer = null;

  /**
   * Update the progress line height to reach the last activated item.
   */
  function updateProgressLine() {
    if (activated.size === 0) {
      progressLine.style.height = '0px';
      return;
    }

    // Find the last activated item by DOM order
    let lastIndex = -1;
    items.forEach(function (item, index) {
      if (activated.has(item)) {
        lastIndex = index;
      }
    });

    if (lastIndex < 0) return;

    const lastItem = items[lastIndex];
    const timelineRect = timeline.getBoundingClientRect();
    const itemRect = lastItem.getBoundingClientRect();

    // Progress line reaches to the marker position of the last active item
    // The marker is at top: 28px of the item (plus border offset)
    var targetHeight = (itemRect.top - timelineRect.top) + 28 + 9; // 9 = half marker height
    progressLine.style.height = targetHeight + 'px';
  }

  /**
   * Process queued activations with staggered delays.
   */
  function processActivations() {
    if (staggerTimer) return; // already processing

    function activateNext() {
      if (pendingActivations.length === 0) {
        staggerTimer = null;
        updateProgressLine();
        return;
      }

      var item = pendingActivations.shift();
      if (!activated.has(item)) {
        activated.add(item);
        item.classList.add('timeline-active');
        updateProgressLine();
      }

      staggerTimer = setTimeout(activateNext, 150);
    }

    activateNext();
  }

  // --- IntersectionObserver for card activation ---
  var observer = new IntersectionObserver(
    function (entries) {
      var newEntries = [];

      entries.forEach(function (entry) {
        if (entry.isIntersecting && !activated.has(entry.target)) {
          newEntries.push(entry.target);
        }
      });

      if (newEntries.length === 0) return;

      // Sort by DOM order to stagger correctly
      newEntries.sort(function (a, b) {
        return items.indexOf(a) - items.indexOf(b);
      });

      newEntries.forEach(function (item) {
        pendingActivations.push(item);
      });

      processActivations();
    },
    { threshold: 0.3 }
  );

  items.forEach(function (item) {
    observer.observe(item);
  });

  // --- Update progress line on scroll ---
  window.addEventListener('scroll', function () {
    updateProgressLine();
  }, { passive: true });

  // Also update on resize
  window.addEventListener('resize', function () {
    updateProgressLine();
  }, { passive: true });
});
