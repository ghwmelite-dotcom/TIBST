/* ============================================
   Gallery Lightbox — Premium Fullscreen Viewer
   ============================================ */

document.addEventListener('DOMContentLoaded', function () {
  var galleryGrid = document.querySelector('.gallery-grid');
  if (!galleryGrid) return;

  // ── Inject lightbox markup ──────────────────────────────────────────
  var lightboxHTML =
    '<div class="lightbox" id="lightbox">' +
      '<button class="lightbox-close" aria-label="Close">&times;</button>' +
      '<button class="lightbox-prev" aria-label="Previous">' +
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>' +
      '</button>' +
      '<button class="lightbox-next" aria-label="Next">' +
        '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>' +
      '</button>' +
      '<div class="lightbox-content">' +
        '<img class="lightbox-img" src="" alt="Gallery image">' +
      '</div>' +
      '<div class="lightbox-counter"><span id="lightbox-current">1</span> / <span id="lightbox-total">1</span></div>' +
    '</div>';

  document.body.insertAdjacentHTML('beforeend', lightboxHTML);

  // ── References ──────────────────────────────────────────────────────
  var lightbox      = document.getElementById('lightbox');
  var lightboxImg   = lightbox.querySelector('.lightbox-img');
  var btnClose      = lightbox.querySelector('.lightbox-close');
  var btnPrev       = lightbox.querySelector('.lightbox-prev');
  var btnNext       = lightbox.querySelector('.lightbox-next');
  var elCurrent     = document.getElementById('lightbox-current');
  var elTotal       = document.getElementById('lightbox-total');

  // ── Extract image URLs ──────────────────────────────────────────────
  var galleryItems = Array.prototype.slice.call(
    galleryGrid.querySelectorAll('.gallery-item')
  );
  var images = [];

  galleryItems.forEach(function (item) {
    var url = '';
    // Try inline style first
    var inlineBg = item.style.backgroundImage;
    if (inlineBg) {
      url = inlineBg.replace(/url\(["']?/, '').replace(/["']?\)/, '');
    }
    // Fallback to computed style
    if (!url) {
      var computed = window.getComputedStyle(item).backgroundImage;
      if (computed && computed !== 'none') {
        url = computed.replace(/url\(["']?/, '').replace(/["']?\)/, '');
      }
    }
    if (url) {
      images.push(url);
    }
  });

  if (images.length === 0) return;

  elTotal.textContent = images.length;

  // ── State ───────────────────────────────────────────────────────────
  var currentIndex = 0;
  var isOpen       = false;
  var isZoomed     = false;

  // ── Helpers ─────────────────────────────────────────────────────────
  function showImage(index, animate) {
    if (animate) {
      lightboxImg.classList.add('fading');
      setTimeout(function () {
        lightboxImg.src = images[index];
        lightboxImg.classList.remove('fading');
        // Re-trigger entry animation
        lightboxImg.style.animation = 'none';
        lightboxImg.offsetHeight; // force reflow
        lightboxImg.style.animation = '';
      }, 150);
    } else {
      lightboxImg.src = images[index];
    }

    currentIndex = index;
    elCurrent.textContent = index + 1;

    // Reset zoom on navigation
    if (isZoomed) {
      isZoomed = false;
      lightboxImg.classList.remove('zoomed');
    }
  }

  function openLightbox(index) {
    showImage(index, false);
    lightbox.classList.add('active');
    // Trigger reflow so the transition fires
    lightbox.offsetHeight;
    lightbox.classList.add('visible');
    document.body.style.overflow = 'hidden';
    isOpen = true;
  }

  function closeLightbox() {
    lightbox.classList.remove('visible');
    setTimeout(function () {
      lightbox.classList.remove('active');
    }, 300);
    document.body.style.overflow = '';
    isOpen = false;
    isZoomed = false;
    lightboxImg.classList.remove('zoomed');
  }

  function navigate(direction) {
    var newIndex = currentIndex + direction;
    if (newIndex < 0) newIndex = images.length - 1;
    if (newIndex >= images.length) newIndex = 0;
    showImage(newIndex, true);
  }

  function toggleZoom() {
    isZoomed = !isZoomed;
    if (isZoomed) {
      lightboxImg.classList.add('zoomed');
    } else {
      lightboxImg.classList.remove('zoomed');
    }
  }

  // ── Click handlers on gallery items ─────────────────────────────────
  galleryItems.forEach(function (item, idx) {
    item.addEventListener('click', function (e) {
      // Only open if we have a corresponding image
      if (idx < images.length) {
        openLightbox(idx);
      }
    });
  });

  // ── Lightbox control events ─────────────────────────────────────────
  btnClose.addEventListener('click', function (e) {
    e.stopPropagation();
    closeLightbox();
  });

  btnPrev.addEventListener('click', function (e) {
    e.stopPropagation();
    navigate(-1);
  });

  btnNext.addEventListener('click', function (e) {
    e.stopPropagation();
    navigate(1);
  });

  // Click on image toggles zoom
  lightboxImg.addEventListener('click', function (e) {
    e.stopPropagation();
    toggleZoom();
  });

  // Click on overlay background closes lightbox
  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox || e.target.classList.contains('lightbox-content')) {
      closeLightbox();
    }
  });

  // ── Keyboard navigation ─────────────────────────────────────────────
  document.addEventListener('keydown', function (e) {
    if (!isOpen) return;

    switch (e.key) {
      case 'Escape':
        closeLightbox();
        break;
      case 'ArrowLeft':
        navigate(-1);
        break;
      case 'ArrowRight':
        navigate(1);
        break;
    }
  });

  // ── Touch / Swipe navigation ────────────────────────────────────────
  var touchStartX = 0;
  var touchStartY = 0;
  var touchStartDist = 0;
  var initialScale = 1;
  var SWIPE_THRESHOLD = 50;

  function getTouchDistance(touches) {
    var dx = touches[0].clientX - touches[1].clientX;
    var dy = touches[0].clientY - touches[1].clientY;
    return Math.sqrt(dx * dx + dy * dy);
  }

  lightbox.addEventListener('touchstart', function (e) {
    if (e.touches.length === 1) {
      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
    }
    // Pinch-to-zoom start
    if (e.touches.length === 2) {
      e.preventDefault();
      touchStartDist = getTouchDistance(e.touches);
      initialScale = isZoomed ? 1.5 : 1;
    }
  }, { passive: false });

  lightbox.addEventListener('touchmove', function (e) {
    // Pinch-to-zoom
    if (e.touches.length === 2) {
      e.preventDefault();
      var currentDist = getTouchDistance(e.touches);
      var scale = initialScale * (currentDist / touchStartDist);
      // Clamp between 1 and 3
      scale = Math.max(1, Math.min(3, scale));
      lightboxImg.style.transform = 'scale(' + scale + ')';
    }
  }, { passive: false });

  lightbox.addEventListener('touchend', function (e) {
    // Handle pinch end
    if (e.touches.length === 0 && touchStartDist > 0) {
      var currentTransform = lightboxImg.style.transform;
      var match = currentTransform.match(/scale\(([\d.]+)\)/);
      if (match) {
        var finalScale = parseFloat(match[1]);
        if (finalScale > 1.2) {
          isZoomed = true;
          lightboxImg.classList.add('zoomed');
        } else {
          isZoomed = false;
          lightboxImg.classList.remove('zoomed');
          lightboxImg.style.transform = '';
        }
      }
      touchStartDist = 0;
      return;
    }

    // Swipe detection (single finger only)
    if (e.changedTouches.length === 1 && touchStartDist === 0) {
      var deltaX = e.changedTouches[0].clientX - touchStartX;
      var deltaY = e.changedTouches[0].clientY - touchStartY;

      // Only trigger swipe if horizontal movement exceeds threshold
      // and is greater than vertical movement (avoid accidental swipes)
      if (Math.abs(deltaX) > SWIPE_THRESHOLD && Math.abs(deltaX) > Math.abs(deltaY)) {
        if (deltaX > 0) {
          navigate(-1); // swipe right = previous
        } else {
          navigate(1);  // swipe left = next
        }
      }
    }
  });
});
