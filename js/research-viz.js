/* ============================================================
   Research Impact Data Visualization
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('research-impact-viz');
  if (!container) return;

  // ---- Data ----
  const pubData = [
    { year: '2018', count: 3 },
    { year: '2019', count: 7 },
    { year: '2020', count: 12 },
    { year: '2021', count: 18 },
    { year: '2022', count: 28 },
    { year: '2023', count: 35 },
    { year: '2024', count: 42 },
    { year: '2025', count: 51 }
  ];

  const areas = [
    { name: 'Gene Therapy', size: 85, color: '#4E9B17' },
    { name: 'CRISPR', size: 70, color: '#5CB820' },
    { name: 'Embryology', size: 75, color: '#3A7A11' },
    { name: 'Stem Cells', size: 55, color: '#C5E063' },
    { name: 'Viral Vectors', size: 50, color: '#7BC142' },
    { name: 'Reproductive Bio', size: 60, color: '#8DD35F' },
    { name: 'Genetic Medicine', size: 65, color: '#4E9B17' }
  ];

  const locations = [
    { name: 'Accra', x: 370, y: 230, isHome: true },
    { name: 'London', x: 375, y: 135, isHome: false },
    { name: 'Boston', x: 230, y: 145, isHome: false },
    { name: 'Tokyo', x: 680, y: 165, isHome: false },
    { name: 'Cape Town', x: 400, y: 330, isHome: false }
  ];

  // ---- Build Grid ----
  const grid = document.createElement('div');
  grid.className = 'research-viz-grid';

  // ---- 1. Publication Growth Chart ----
  const pubPanel = document.createElement('div');
  pubPanel.className = 'research-viz-panel';
  pubPanel.innerHTML = '<h3>Publication Growth</h3>';

  const barsWrapper = document.createElement('div');
  barsWrapper.className = 'pub-bars-wrapper';

  const maxCount = Math.max(...pubData.map(function (d) { return d.count; }));

  pubData.forEach(function (d) {
    const bar = document.createElement('div');
    bar.className = 'pub-bar';

    const label = document.createElement('span');
    label.className = 'pub-bar-label';
    label.textContent = d.year;

    const track = document.createElement('div');
    track.className = 'pub-bar-track';

    const fill = document.createElement('div');
    fill.className = 'pub-bar-fill';
    fill.style.width = ((d.count / maxCount) * 100) + '%';

    const count = document.createElement('span');
    count.className = 'pub-bar-count';
    count.textContent = d.count;

    track.appendChild(fill);
    bar.appendChild(label);
    bar.appendChild(track);
    bar.appendChild(count);
    barsWrapper.appendChild(bar);
  });

  pubPanel.appendChild(barsWrapper);

  // ---- 2. Research Areas Bubble Chart ----
  const bubblePanel = document.createElement('div');
  bubblePanel.className = 'research-viz-panel';
  bubblePanel.innerHTML = '<h3>Research Focus Areas</h3>';

  const bubbleArea = document.createElement('div');
  bubbleArea.className = 'bubble-area';

  var sizeMin = Math.min.apply(null, areas.map(function (a) { return a.size; }));
  var sizeMax = Math.max.apply(null, areas.map(function (a) { return a.size; }));

  areas.forEach(function (area) {
    var ratio = (area.size - sizeMin) / (sizeMax - sizeMin);
    var diameter = 80 + ratio * (160 - 80);

    var bubble = document.createElement('div');
    bubble.className = 'research-bubble';
    bubble.style.width = diameter + 'px';
    bubble.style.height = diameter + 'px';
    bubble.style.backgroundColor = area.color;

    var nameSpan = document.createElement('span');
    nameSpan.textContent = area.name;
    bubble.appendChild(nameSpan);

    var tooltip = document.createElement('div');
    tooltip.className = 'bubble-tooltip';
    tooltip.textContent = area.name + ' — Impact: ' + area.size + '%';
    bubble.appendChild(tooltip);

    bubbleArea.appendChild(bubble);
  });

  bubblePanel.appendChild(bubbleArea);

  // ---- 3. Global Collaboration Map ----
  var mapPanel = document.createElement('div');
  mapPanel.className = 'research-viz-panel research-viz-panel--map';
  mapPanel.innerHTML = '<h3>Global Collaborations</h3>';

  var mapContainer = document.createElement('div');
  mapContainer.className = 'collab-map';

  // Simplified continent outlines
  var svgNS = 'http://www.w3.org/2000/svg';
  var svg = document.createElementNS(svgNS, 'svg');
  svg.setAttribute('viewBox', '0 0 800 400');
  svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');

  // Continent paths (simplified outlines)
  var continents = [
    // North America
    'M 120,80 L 170,60 220,65 260,80 265,100 250,130 240,160 220,170 200,165 180,170 150,160 130,145 110,130 105,100 Z',
    // South America
    'M 210,210 L 230,200 255,210 270,240 275,270 265,310 250,340 230,360 215,350 200,320 195,280 200,240 Z',
    // Europe
    'M 350,70 L 370,60 400,65 420,80 415,100 400,110 385,115 370,110 355,100 345,85 Z',
    // Africa
    'M 350,150 L 380,140 410,150 430,170 435,200 440,230 430,270 415,310 400,335 380,345 360,335 345,310 335,275 330,240 335,200 340,170 Z',
    // Asia
    'M 430,60 L 480,50 540,55 600,65 660,75 700,90 720,110 710,140 690,160 660,170 620,165 580,155 540,145 500,140 470,130 450,115 435,95 Z',
    // Australia
    'M 620,270 L 660,260 700,265 720,280 725,300 710,320 680,330 650,325 630,310 620,290 Z'
  ];

  continents.forEach(function (d) {
    var path = document.createElementNS(svgNS, 'path');
    path.setAttribute('d', d);
    path.setAttribute('class', 'map-path');
    svg.appendChild(path);
  });

  // Connection lines from Accra to each partner
  var accra = locations[0];
  locations.forEach(function (loc) {
    if (loc.isHome) return;
    var line = document.createElementNS(svgNS, 'line');
    line.setAttribute('x1', accra.x);
    line.setAttribute('y1', accra.y);
    line.setAttribute('x2', loc.x);
    line.setAttribute('y2', loc.y);
    line.setAttribute('class', 'connection-line');
    // Calculate the length for dashoffset
    var dx = loc.x - accra.x;
    var dy = loc.y - accra.y;
    var length = Math.sqrt(dx * dx + dy * dy);
    line.style.strokeDasharray = length;
    line.style.strokeDashoffset = length;
    svg.appendChild(line);
  });

  // Location dots
  locations.forEach(function (loc) {
    var circle = document.createElementNS(svgNS, 'circle');
    circle.setAttribute('cx', loc.x);
    circle.setAttribute('cy', loc.y);
    circle.setAttribute('r', loc.isHome ? 6 : 4);
    circle.setAttribute('class', 'location-dot' + (loc.isHome ? ' location-dot--accra' : ''));
    svg.appendChild(circle);

    // Label on the SVG
    var text = document.createElementNS(svgNS, 'text');
    text.setAttribute('x', loc.x + 10);
    text.setAttribute('y', loc.y + 4);
    text.setAttribute('class', 'location-label');
    text.textContent = loc.name;
    svg.appendChild(text);
  });

  mapContainer.appendChild(svg);

  // Labels below map
  var labelsDiv = document.createElement('div');
  labelsDiv.className = 'collab-map-labels';
  locations.forEach(function (loc) {
    var span = document.createElement('span');
    span.textContent = loc.name + (loc.isHome ? ' (Home)' : '');
    labelsDiv.appendChild(span);
  });

  mapPanel.appendChild(mapContainer);
  mapPanel.appendChild(labelsDiv);

  // ---- Assemble Grid ----
  grid.appendChild(pubPanel);
  grid.appendChild(bubblePanel);
  grid.appendChild(mapPanel);
  container.appendChild(grid);

  // ---- IntersectionObserver Animations ----

  // Publication bars
  var pubObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var fills = pubPanel.querySelectorAll('.pub-bar-fill');
        fills.forEach(function (fill, i) {
          setTimeout(function () {
            fill.classList.add('animate');
          }, i * 100);
        });
        pubObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  pubObserver.observe(pubPanel);

  // Bubbles
  var bubbleObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var bubbles = bubblePanel.querySelectorAll('.research-bubble');
        bubbles.forEach(function (bubble, i) {
          setTimeout(function () {
            bubble.classList.add('animate');
          }, i * 100);
        });
        bubbleObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  bubbleObserver.observe(bubblePanel);

  // Map connection lines
  var mapObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var lines = mapContainer.querySelectorAll('.connection-line');
        lines.forEach(function (line, i) {
          setTimeout(function () {
            line.classList.add('animate');
          }, i * 300);
        });
        mapObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });
  mapObserver.observe(mapPanel);
});
