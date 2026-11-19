/* NIA · comportamiento del tema (sin dependencias) */
(function () {
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function toast(msg) {
    var t = $('#toast'); if (!t) return;
    t.textContent = msg; t.hidden = false;
    clearTimeout(toast.timer); toast.timer = setTimeout(function () { t.hidden = true; }, 3200);
  }
  window.niaToast = toast;
  function openDialog(id) {
    var d = document.getElementById(id);
    if (!d || !d.showModal) return false;
    $$('dialog[open]').forEach(function (x) { if (x !== d) x.close(); });
    if (!d.open) d.showModal();
    var q = $('input[type=search]', d); if (q) q.focus();
    return true;
  }
  window.niaOpen = openDialog;

  /* Diálogos: menú móvil, búsqueda y carrito */
  document.addEventListener('click', function (e) {
    var opener = e.target.closest('[data-open]');
    if (opener) { if (openDialog(opener.getAttribute('data-open'))) e.preventDefault(); return; }
    if (e.target.closest('[data-close]')) { var dlg = e.target.closest('dialog'); if (dlg) dlg.close(); }
    var demo = e.target.closest('[data-demo]');
    if (demo && demo.getAttribute('href') === '#') { e.preventDefault(); toast(demo.getAttribute('data-demo')); }
  });
  $$('dialog').forEach(function (d) { d.addEventListener('click', function (e) { if (e.target === d) d.close(); }); });
  $$('#mobile-nav a').forEach(function (a) { a.addEventListener('click', function () { $('#mobile-nav').close(); }); });
  $$('[data-demo-form]').forEach(function (f) {
    f.addEventListener('submit', function (e) { e.preventDefault(); f.reset(); toast('¡Gracias! (demostración: no se guardó el correo)'); });
  });

  /* Carrito lateral: se abre al agregar (AJAX de WooCommerce) o tras agregar desde la ficha */
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function () { openDialog('cart'); });
  }
  var added = $('.woocommerce-message');
  if (added && /carrito|cart/i.test(added.textContent) && $('#cart')) { setTimeout(function () { openDialog('cart'); }, 300); }

  /* Collage del hero: duplica cada columna para un bucle continuo */
  $$('.collage-track').forEach(function (track) {
    if (track.children.length > 1) return;
    var set = track.firstElementChild; if (!set) return;
    var copy = set.cloneNode(true);
    copy.setAttribute('aria-hidden', 'true');
    $$('img', copy).forEach(function (i) { i.alt = ''; });
    track.appendChild(copy);
  });

  /* Cinta de obras: duplica el set para un desplazamiento continuo */
  $$('.obras-track').forEach(function (track) {
    if (track.children.length > 1) return;
    var copy = track.firstElementChild.cloneNode(true);
    copy.setAttribute('aria-hidden', 'true');
    $$('img', copy).forEach(function (i) { i.alt = ''; });
    track.appendChild(copy);
  });

  /* Preguntas frecuentes: abrir y cerrar con animación suave (una a la vez) */
  $$('[data-faq]').forEach(function (list) {
    list.addEventListener('click', function (e) {
      var btn = e.target.closest('.faq-q'); if (!btn) return;
      var item = btn.closest('.faq-item'), open = !item.classList.contains('is-open');
      $$('.faq-item', list).forEach(function (it) { it.classList.remove('is-open'); it.querySelector('.faq-q').setAttribute('aria-expanded', 'false'); });
      if (open) { item.classList.add('is-open'); btn.setAttribute('aria-expanded', 'true'); }
    });
  });

  /* ---------- Telar animado de la sección A medida ---------- */
  var loom = $('[data-loom]');
  if (loom) {
    var canvas = $('canvas', loom), ctx = canvas.getContext('2d');
    var steps = $$('.loom-steps li');
    var layers = $$('[data-layer]', loom);
    var pctEl = $('[data-loom-pct]', loom);
    var COLS = 24, ROWS = 30;
    var C = { k: '#1d1b19', y: '#ffcc29', w: '#f4efe6', g: '#8c8780' };
    /* Patrón: rombos escalonados zapotecos con borde y franjas, en amarillo, negro y crudo */
    function cell(x, y) {
      if (x < 1 || x > COLS - 2 || y < 1 || y > ROWS - 2) return C.k;
      if (y === 3 || y === ROWS - 4) return C.y;
      var cx = (COLS - 1) / 2, cy = (ROWS - 1) / 2;
      var d = Math.abs(x - cx) + Math.abs(y - cy) * 0.82;
      var band = Math.floor(d / 2.2);
      if (band > 6) return (x + y) % 4 === 0 ? C.g : C.w;
      return [C.y, C.k, C.w, C.k, C.y, C.w, C.k][band];
    }
    var DPR = Math.min(window.devicePixelRatio || 1, 2), W = 0, H = 0, cw = 0, ch = 0, ox = 0, oy = 0;
    function resize() {
      var r = canvas.getBoundingClientRect();
      W = Math.round(r.width); H = Math.round(r.height);
      canvas.width = W * DPR; canvas.height = H * DPR;
      ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
      cw = Math.floor((W * 0.76) / COLS); ch = Math.floor((H * 0.8) / ROWS);
      var s = Math.min(cw, ch * 1.25); cw = s; ch = s * 0.8;
      ox = Math.round((W - cw * COLS) / 2); oy = Math.round((H - ch * ROWS) / 2);
    }
    /* Línea de tiempo (segundos): idea, color, cotización, tejido, envío */
    var T = [0, 3, 6, 9, 17.5, 21];
    function phaseAt(t) { for (var i = 4; i >= 0; i--) if (t >= T[i]) return i; return 0; }
    function draw(t) {
      var ph = phaseAt(t);
      ctx.clearRect(0, 0, W, H);
      var rw = cw * COLS, rh = ch * ROWS;
      /* Urdimbre (hilos verticales) */
      ctx.strokeStyle = 'rgba(244,239,230,.22)'; ctx.lineWidth = 1;
      for (var i = 0; i <= COLS; i++) { var xx = ox + i * cw + 0.5; ctx.beginPath(); ctx.moveTo(xx, oy - 18); ctx.lineTo(xx, oy + rh + 18); ctx.stroke(); }
      /* Contorno del diseño (idea) */
      if (ph <= 2) {
        var k = Math.min(1, t / 2.4);
        ctx.save(); ctx.setLineDash([6, 6]); ctx.strokeStyle = '#ffcc29'; ctx.lineWidth = 1.5;
        var per = 2 * (rw + rh), len = per * k;
        ctx.beginPath(); ctx.moveTo(ox, oy);
        var pts = [[ox + rw, oy], [ox + rw, oy + rh], [ox, oy + rh], [ox, oy]], seg = [rw, rh, rw, rh], acc = 0, px = ox, py = oy;
        for (var s = 0; s < 4 && acc < len; s++) {
          var take = Math.min(seg[s], len - acc), f = take / seg[s];
          var nx = px + (pts[s][0] - px) * f, ny = py + (pts[s][1] - py) * f;
          ctx.lineTo(nx, ny); acc += take; px = pts[s][0]; py = pts[s][1];
        }
        ctx.stroke(); ctx.restore();
      }
      /* Vista previa del color (diseño): patrón tenue */
      var woven = 0;
      if (ph === 1 || ph === 2) {
        ctx.globalAlpha = ph === 1 ? Math.min(1, (t - T[1]) / 1.4) * 0.6 : 0.6;
        for (var y = 0; y < ROWS; y++) for (var x = 0; x < COLS; x++) { ctx.fillStyle = cell(x, y); ctx.fillRect(ox + x * cw, oy + y * ch, cw - 1, ch - 1); }
        ctx.globalAlpha = 1;
      }
      /* Tejido: de abajo hacia arriba, fila por fila */
      if (ph >= 3) {
        var p = ph === 3 ? (t - T[3]) / (T[4] - T[3]) : 1;
        woven = p * ROWS;
        var full = Math.floor(woven);
        for (var y2 = 0; y2 < full; y2++) { var ry = ROWS - 1 - y2; for (var x2 = 0; x2 < COLS; x2++) { ctx.fillStyle = cell(x2, ry); ctx.fillRect(ox + x2 * cw, oy + ry * ch, cw, ch); } }
        if (full < ROWS) {
          var ry2 = ROWS - 1 - full, partial = woven - full, n = Math.floor(partial * COLS);
          var dir = full % 2 === 0;
          for (var c = 0; c < n; c++) { var xc = dir ? c : COLS - 1 - c; ctx.fillStyle = cell(xc, ry2); ctx.fillRect(ox + xc * cw, oy + ry2 * ch, cw, ch); }
          /* Lanzadera */
          var sx = dir ? ox + n * cw : ox + (COLS - n) * cw;
          ctx.fillStyle = '#ffcc29'; ctx.fillRect(sx - 18, oy + ry2 * ch + ch / 2 - 3, 36, 6);
          ctx.fillStyle = '#1d1b19'; ctx.fillRect(sx - 10, oy + ry2 * ch + ch / 2 - 1, 20, 2);
        }
        if (pctEl) pctEl.textContent = Math.round(p * 100);
        /* Peine (batán) que baja con cada fila */
        if (ph === 3) { var by = oy + (ROWS - full) * ch - 4; ctx.fillStyle = 'rgba(244,239,230,.55)'; ctx.fillRect(ox - 14, by, rw + 28, 3); }
      }
      /* Envío: flecos */
      if (ph === 4) {
        ctx.strokeStyle = '#f4efe6'; ctx.lineWidth = 1;
        for (var f2 = 0; f2 < COLS; f2 += 1) { var fx = ox + f2 * cw + cw / 2; ctx.beginPath(); ctx.moveTo(fx, oy + rh); ctx.lineTo(fx, oy + rh + 14); ctx.stroke(); ctx.beginPath(); ctx.moveTo(fx, oy); ctx.lineTo(fx, oy - 14); ctx.stroke(); }
      }
      /* Pasos y capas */
      steps.forEach(function (li, i) {
        li.classList.toggle('is-active', i === ph);
        li.classList.toggle('is-done', i < ph);
        var bar = li.querySelector('.step-bar');
        var prog = i < ph ? 1 : i > ph ? 0 : Math.min(1, (t - T[i]) / (T[i + 1] - T[i]));
        if (bar) bar.style.transform = 'scaleX(' + prog + ')';
      });
      layers.forEach(function (l) { l.classList.toggle('is-on', +l.getAttribute('data-layer') === ph); });
    }
    var start = performance.now(), offset = 0, running = false, raf = 0, visible = false;
    function loop(now) {
      var t = ((now - start) / 1000 + offset) % T[5];
      draw(t);
      if (running) raf = requestAnimationFrame(loop);
    }
    function play() { if (running || reduce) return; running = true; start = performance.now(); raf = requestAnimationFrame(loop); }
    function pause(now) { if (!running) return; running = false; cancelAnimationFrame(raf); offset = (((now || performance.now()) - start) / 1000 + offset) % T[5]; }
    steps.forEach(function (li, i) {
      li.querySelector('button').addEventListener('click', function () {
        pause(); offset = T[i] + (i === 3 ? 2.5 : 0.01); draw(offset);
        if (visible) play();
      });
    });
    resize();
    /* Si el lienzo se midió antes de que cargaran los estilos, volver a medir */
    if ('ResizeObserver' in window) { new ResizeObserver(function () { resize(); if (!running) draw(offset || 0.01); }).observe(canvas); }
    window.addEventListener('load', function () { resize(); if (!running) draw(offset || 0.01); });
    if (reduce) { draw(T[4] + 0.5); }
    else {
      draw(0);
      if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (es) { es.forEach(function (en) { visible = en.isIntersecting; visible ? play() : pause(); }); }, { threshold: 0.25 }).observe(loom);
      } else { visible = true; play(); }
    }
    window.addEventListener('resize', function () { resize(); if (!running) draw(offset); });
  }

  /* ---------- Tienda: filtros, chips, orden y conteo (en el navegador) ---------- */
  var shop = $('[data-shop]');
  if (shop) {
    var grid = $('ul.products', shop);
    var items = grid ? $$('li.product', grid) : [];
    var original = items.slice();
    var facets = $$('[data-facet]', shop);
    var countEl = $('[data-shop-count]', shop), chipsEl = $('[data-shop-chips]', shop), empty = $('[data-shop-empty]', shop), sortEl = $('[data-shop-sort]', shop);
    function data(li) { var c = li.querySelector('.card'); return c ? c.dataset : {}; }
    function match(d, key, val) {
      if (key === 'cat') return d.cat === val;
      if (key === 'size' || key === 'style') return (' ' + (d.tags || '') + ' ').indexOf(' ' + val + ' ') > -1;
      if (key === 'stock') return d.stock === val;
      if (key === 'price') { var r = val.split('-'), p = +d.price; return p >= +r[0] && p <= +r[1]; }
      return true;
    }
    function selected() { var s = {}; facets.forEach(function (f) { s[f.dataset.facet] = $$('input:checked', f).map(function (i) { return i.value; }); }); return s; }
    function passes(li, sel, skip) {
      var d = data(li);
      for (var k in sel) { if (k === skip || !sel[k].length) continue; if (!sel[k].some(function (v) { return match(d, k, v); })) return false; }
      return true;
    }
    function apply() {
      var sel = selected(), shown = 0;
      items.forEach(function (li) { var ok = passes(li, sel); li.hidden = !ok; if (ok) shown++; });
      if (countEl) countEl.textContent = shown + (shown === 1 ? ' pieza' : ' piezas');
      if (empty) empty.hidden = shown > 0;
      facets.forEach(function (f) {
        var key = f.dataset.facet;
        $$('input', f).forEach(function (inp) {
          var n = items.filter(function (li) { return passes(li, sel, key) && match(data(li), key, inp.value); }).length;
          var c = f.querySelector('[data-count-for="' + key + ':' + inp.value + '"]'); if (c) c.textContent = n;
          inp.disabled = !n && !inp.checked; inp.closest('label').classList.toggle('is-off', !n && !inp.checked);
        });
      });
      if (chipsEl) {
        chipsEl.innerHTML = '';
        facets.forEach(function (f) { $$('input:checked', f).forEach(function (inp) {
          var b = document.createElement('button'); b.type = 'button'; b.className = 'chip-btn';
          b.innerHTML = inp.closest('label').querySelector('.facet-label').textContent + ' <span aria-hidden="true">×</span>';
          b.addEventListener('click', function () { inp.checked = false; apply(); }); chipsEl.appendChild(b);
        }); });
        if (chipsEl.children.length > 1) { var all = document.createElement('button'); all.type = 'button'; all.className = 'chip-clear'; all.textContent = 'Quitar todo'; all.addEventListener('click', function () { $$('input', shop).forEach(function (i) { i.checked = false; }); apply(); }); chipsEl.appendChild(all); }
      }
    }
    function sort() {
      var v = sortEl ? sortEl.value : '';
      var list = original.slice();
      if (v) { var k = v.split('-')[0], asc = v.split('-')[1] === 'asc'; list.sort(function (a, b) { var x = +data(a)[k], y = +data(b)[k]; return asc ? x - y : y - x; }); }
      list.forEach(function (li) { grid.appendChild(li); });
    }
    facets.forEach(function (f) { f.addEventListener('change', apply); });
    if (sortEl) sortEl.addEventListener('change', sort);
    $$('[data-filters-open]', shop).forEach(function (b) { b.addEventListener('click', function () { shop.classList.add('filters-open'); document.body.classList.add('no-scroll'); }); });
    $$('[data-filters-close]', shop).forEach(function (b) { b.addEventListener('click', function () { shop.classList.remove('filters-open'); document.body.classList.remove('no-scroll'); }); });
    apply();
  }
})();
