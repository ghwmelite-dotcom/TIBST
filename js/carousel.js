document.addEventListener('DOMContentLoaded', function () {
  var track = document.querySelector('.testimonial-marquee-track');
  if (!track) return;

  var inner = track.querySelector('.testimonial-marquee-inner');
  if (!inner) return;

  // --- Remove duplicate cards ---
  var cards = Array.from(inner.querySelectorAll('.testimonial-card-v4'));
  var totalCards = cards.length;
  if (totalCards > 1) {
    // The markup duplicates all cards for seamless loop; keep only the first half
    var half = Math.floor(totalCards / 2);
    for (var i = totalCards - 1; i >= half; i--) {
      cards[i].parentNode.removeChild(cards[i]);
    }
  }

  // --- Stop CSS marquee animation and override styles ---
  inner.style.animation = 'none';
  inner.style.display = 'flex';
  inner.style.gap = '24px';
  inner.style.overflowX = 'auto';
  inner.style.scrollSnapType = 'x mandatory';
  inner.style.cursor = 'grab';
  inner.style.width = '';
  inner.style.transform = '';

  // Apply scroll-snap-align to each remaining card
  var remainingCards = inner.querySelectorAll('.testimonial-card-v4');
  for (var c = 0; c < remainingCards.length; c++) {
    remainingCards[c].style.scrollSnapAlign = 'start';
  }

  // --- Create arrow buttons ---
  var prevArrow = document.createElement('button');
  prevArrow.className = 'carousel-arrow prev hidden';
  prevArrow.setAttribute('aria-label', 'Previous');
  prevArrow.innerHTML = '<svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>';

  var nextArrow = document.createElement('button');
  nextArrow.className = 'carousel-arrow next';
  nextArrow.setAttribute('aria-label', 'Next');
  nextArrow.innerHTML = '<svg viewBox="0 0 24 24"><polyline points="9 6 15 12 9 18"></polyline></svg>';

  track.appendChild(prevArrow);
  track.appendChild(nextArrow);

  // --- Arrow visibility ---
  function updateArrows() {
    var scrollLeft = inner.scrollLeft;
    var maxScroll = inner.scrollWidth - inner.clientWidth;

    if (scrollLeft <= 1) {
      prevArrow.classList.add('hidden');
    } else {
      prevArrow.classList.remove('hidden');
    }

    if (scrollLeft >= maxScroll - 1) {
      nextArrow.classList.add('hidden');
    } else {
      nextArrow.classList.remove('hidden');
    }
  }

  inner.addEventListener('scroll', updateArrows);
  updateArrows();

  // --- Arrow click: scroll by one card width + gap ---
  function getScrollAmount() {
    var firstCard = inner.querySelector('.testimonial-card-v4');
    if (!firstCard) return 300;
    return firstCard.offsetWidth + 24; // card width + gap
  }

  prevArrow.addEventListener('click', function () {
    inner.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
  });

  nextArrow.addEventListener('click', function () {
    inner.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
  });

  // --- Drag-to-scroll with momentum ---
  var isDragging = false;
  var startX = 0;
  var scrollStart = 0;
  var lastX = 0;
  var lastTime = 0;
  var velocity = 0;
  var momentumId = null;

  function onDragStart(e) {
    isDragging = true;
    inner.style.cursor = 'grabbing';
    inner.style.scrollSnapType = 'none'; // disable snap during drag

    var clientX = e.type === 'mousedown' ? e.pageX : e.touches[0].pageX;
    startX = clientX;
    scrollStart = inner.scrollLeft;
    lastX = clientX;
    lastTime = Date.now();
    velocity = 0;

    if (momentumId) {
      cancelAnimationFrame(momentumId);
      momentumId = null;
    }

    if (e.type === 'mousedown') {
      e.preventDefault();
    }
  }

  function onDragMove(e) {
    if (!isDragging) return;
    e.preventDefault();

    var clientX = e.type === 'mousemove' ? e.pageX : e.touches[0].pageX;
    var dx = clientX - startX;
    inner.scrollLeft = scrollStart - dx;

    // Track velocity
    var now = Date.now();
    var dt = now - lastTime;
    if (dt > 0) {
      velocity = (lastX - clientX) / dt; // px per ms
    }
    lastX = clientX;
    lastTime = now;
  }

  function onDragEnd() {
    if (!isDragging) return;
    isDragging = false;
    inner.style.cursor = 'grab';

    // Apply momentum
    var decay = 0.95;
    var currentVelocity = velocity * 16; // convert to px per frame (~16ms)

    function momentumStep() {
      if (Math.abs(currentVelocity) < 0.5) {
        // Re-enable snap when momentum ends
        inner.style.scrollSnapType = 'x mandatory';
        momentumId = null;
        return;
      }
      inner.scrollLeft += currentVelocity;
      currentVelocity *= decay;
      momentumId = requestAnimationFrame(momentumStep);
    }

    if (Math.abs(currentVelocity) > 0.5) {
      momentumId = requestAnimationFrame(momentumStep);
    } else {
      inner.style.scrollSnapType = 'x mandatory';
    }
  }

  // Mouse events
  inner.addEventListener('mousedown', onDragStart);
  window.addEventListener('mousemove', onDragMove);
  window.addEventListener('mouseup', onDragEnd);

  // Touch events
  inner.addEventListener('touchstart', onDragStart, { passive: true });
  inner.addEventListener('touchmove', onDragMove, { passive: false });
  inner.addEventListener('touchend', onDragEnd);

  // Prevent link clicks during drag
  inner.addEventListener('click', function (e) {
    if (Math.abs(lastX - startX) > 5) {
      e.preventDefault();
      e.stopPropagation();
    }
  });

  // Prevent text selection during drag
  inner.addEventListener('selectstart', function (e) {
    if (isDragging) e.preventDefault();
  });
});
