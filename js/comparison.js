/* ===== PROGRAMME COMPARISON TOOL ===== */

document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('programme-compare');
  if (!container) return;

  const PROGRAMMES = [
    {
      id: 'mphil-gt', degree: 'MPhil', field: 'Gene Therapy', duration: '2 years',
      credits: 60, researchFocus: ['CRISPR Gene Editing', 'Viral Vector Design', 'Clinical Gene Therapy'],
      careers: ['Research Scientist', 'Gene Therapy Specialist', 'Clinical Researcher'],
      entryReq: "Bachelor's degree in Biological Sciences or related field",
      mode: 'Full-time', thesis: 'Yes \u2014 Original Research Thesis'
    },
    {
      id: 'phd-gt', degree: 'PhD', field: 'Gene Therapy', duration: '3-4 years',
      credits: 90, researchFocus: ['Advanced Gene Editing', 'Translational Gene Therapy', 'Genetic Medicine Innovation'],
      careers: ['Principal Investigator', 'Gene Therapy Director', 'University Professor'],
      entryReq: "MPhil or Master's in Gene Therapy or related field",
      mode: 'Full-time', thesis: 'Yes \u2014 Doctoral Dissertation'
    },
    {
      id: 'mphil-he', degree: 'MPhil', field: 'Human Embryology', duration: '2 years',
      credits: 60, researchFocus: ['Embryonic Development', 'Assisted Reproduction', 'Reproductive Biology'],
      careers: ['Embryologist', 'IVF Specialist', 'Reproductive Research Scientist'],
      entryReq: "Bachelor's degree in Biological Sciences or related field",
      mode: 'Full-time', thesis: 'Yes \u2014 Original Research Thesis'
    },
    {
      id: 'phd-he', degree: 'PhD', field: 'Human Embryology', duration: '3-4 years',
      credits: 90, researchFocus: ['Advanced Developmental Biology', 'Stem Cell Research', 'Clinical Reproductive Science'],
      careers: ['Senior Embryologist', 'Research Director', 'University Professor'],
      entryReq: "MPhil or Master's in Human Embryology or related field",
      mode: 'Full-time', thesis: 'Yes \u2014 Doctoral Dissertation'
    }
  ];

  // Max values for bar calculations
  const MAX_DURATION_YEARS = 4;
  const MAX_CREDITS = 90;

  function parseDurationYears(duration) {
    // Extract the highest number from duration string (e.g. "3-4 years" -> 4, "2 years" -> 2)
    var matches = duration.match(/(\d+)/g);
    if (!matches) return 0;
    return Math.max.apply(null, matches.map(Number));
  }

  function getFullName(prog) {
    return prog.degree + ' ' + prog.field;
  }

  function buildSelectOptions() {
    return PROGRAMMES.map(function (p) {
      return '<option value="' + p.id + '">' + getFullName(p) + '</option>';
    }).join('');
  }

  function buildTags(items) {
    return '<div class="compare-tags">' +
      items.map(function (item) {
        return '<span class="compare-tag">' + item + '</span>';
      }).join('') +
      '</div>';
  }

  function buildBar(value, max) {
    var pct = Math.round((value / max) * 100);
    return '<div class="compare-bar"><div class="compare-bar-fill" data-width="' + pct + '"></div></div>';
  }

  function buildCard(prog) {
    var durationYears = parseDurationYears(prog.duration);
    var durationPct = Math.round((durationYears / MAX_DURATION_YEARS) * 100);
    var creditsPct = Math.round((prog.credits / MAX_CREDITS) * 100);

    return '' +
      '<div class="compare-card fade-in" data-programme="' + prog.id + '">' +
        '<div class="compare-card-header">' + getFullName(prog) + '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Duration</div>' +
          '<div class="compare-row-value">' + prog.duration + '</div>' +
          '<div class="compare-bar"><div class="compare-bar-fill" data-width="' + durationPct + '"></div></div>' +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Credits</div>' +
          '<div class="compare-row-value">' + prog.credits + ' credits</div>' +
          '<div class="compare-bar"><div class="compare-bar-fill" data-width="' + creditsPct + '"></div></div>' +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Research Focus</div>' +
          buildTags(prog.researchFocus) +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Career Outcomes</div>' +
          buildTags(prog.careers) +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Entry Requirements</div>' +
          '<div class="compare-row-value">' + prog.entryReq + '</div>' +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Study Mode</div>' +
          '<div class="compare-row-value">' + prog.mode + '</div>' +
        '</div>' +

        '<div class="compare-row">' +
          '<div class="compare-row-label">Thesis Requirement</div>' +
          '<div class="compare-row-value">' + prog.thesis + '</div>' +
        '</div>' +

        '<a href="apply.php" class="compare-apply-btn">Apply for ' + getFullName(prog) + '</a>' +
      '</div>';
  }

  function animateBarFills(parentEl) {
    var bars = parentEl.querySelectorAll('.compare-bar-fill');
    // Slight delay so the browser registers width:0 first
    requestAnimationFrame(function () {
      bars.forEach(function (bar) {
        bar.style.width = bar.getAttribute('data-width') + '%';
      });
    });
  }

  function getProgrammeById(id) {
    for (var i = 0; i < PROGRAMMES.length; i++) {
      if (PROGRAMMES[i].id === id) return PROGRAMMES[i];
    }
    return PROGRAMMES[0];
  }

  function updateCard(slot, progId) {
    var card = grid.querySelector('.compare-card[data-slot="' + slot + '"]') ||
               grid.children[slot === 'left' ? 0 : 1];

    // Fade out
    card.classList.remove('fade-in');
    card.classList.add('fade-out');

    setTimeout(function () {
      var prog = getProgrammeById(progId);
      var temp = document.createElement('div');
      temp.innerHTML = buildCard(prog);
      var newCard = temp.firstChild;
      newCard.setAttribute('data-slot', slot);
      newCard.classList.remove('fade-in');
      newCard.classList.add('fade-out');

      card.parentNode.replaceChild(newCard, card);

      // Trigger reflow then fade in
      void newCard.offsetWidth;
      newCard.classList.remove('fade-out');
      newCard.classList.add('fade-in');
      animateBarFills(newCard);
    }, 350);
  }

  // Build the full UI
  var options = buildSelectOptions();

  container.innerHTML = '' +
    '<div class="compare-tool">' +
      '<div class="compare-selectors">' +
        '<div class="compare-selector-group">' +
          '<label class="compare-selector-label" for="compare-select-left">Programme A</label>' +
          '<select class="compare-select" id="compare-select-left">' + options + '</select>' +
        '</div>' +
        '<div class="compare-selector-group">' +
          '<label class="compare-selector-label" for="compare-select-right">Programme B</label>' +
          '<select class="compare-select" id="compare-select-right">' + options + '</select>' +
        '</div>' +
      '</div>' +
      '<div class="compare-grid"></div>' +
    '</div>';

  var selectLeft = document.getElementById('compare-select-left');
  var selectRight = document.getElementById('compare-select-right');
  var grid = container.querySelector('.compare-grid');

  // Set defaults: MPhil Gene Therapy vs PhD Gene Therapy
  selectLeft.value = 'mphil-gt';
  selectRight.value = 'phd-gt';

  // Render initial cards
  function renderCards() {
    var leftProg = getProgrammeById(selectLeft.value);
    var rightProg = getProgrammeById(selectRight.value);

    var leftCard = buildCard(leftProg);
    var rightCard = buildCard(rightProg);

    // Insert with slot markers
    grid.innerHTML = leftCard + rightCard;
    grid.children[0].setAttribute('data-slot', 'left');
    grid.children[1].setAttribute('data-slot', 'right');

    animateBarFills(grid);
  }

  renderCards();

  // Event listeners
  selectLeft.addEventListener('change', function () {
    updateCard('left', selectLeft.value);
  });

  selectRight.addEventListener('change', function () {
    updateCard('right', selectRight.value);
  });
});
