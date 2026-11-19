/* NIA · comportamiento del tema (sin dependencias) */
(function () {
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  function toast(msg) {
    var t = $('#toast'); if (!t) return;
    t.textContent = msg; t.hidden = false;
    clearTimeout(toast.timer); toast.timer = setTimeout(function () { t.hidden = true; }, 2800);
  }

  /* Diálogos: menú móvil y búsqueda */
  document.addEventListener('click', function (e) {
    var opener = e.target.closest('[data-open]');
    if (opener) {
      var d = document.getElementById(opener.getAttribute('data-open'));
      if (d && d.showModal) { e.preventDefault(); d.showModal(); var q = $('input[type=search]', d); if (q) q.focus(); }
      return;
    }
    if (e.target.closest('[data-close]')) { var dlg = e.target.closest('dialog'); if (dlg) dlg.close(); }
    var demo = e.target.closest('[data-demo]');
    if (demo && demo.getAttribute('href') === '#') { e.preventDefault(); toast(demo.getAttribute('data-demo')); }
  });
  $$('dialog').forEach(function (d) { d.addEventListener('click', function (e) { if (e.target === d) d.close(); }); });
  $$('#mobile-nav a').forEach(function (a) { a.addEventListener('click', function () { $('#mobile-nav').close(); }); });

  /* Suscripción de demostración */
  $$('[data-demo-form]').forEach(function (f) {
    f.addEventListener('submit', function (e) { e.preventDefault(); f.reset(); toast('¡Gracias! (demostración: no se guardó el correo)'); });
  });

  /* Collage del hero: duplica cada columna para un bucle continuo */
  $$('.collage-track').forEach(function (track) {
    if (track.children.length > 1) return;
    var set = track.firstElementChild; if (!set) return;
    var copy = set.cloneNode(true);
    copy.setAttribute('aria-hidden', 'true');
    $$('img', copy).forEach(function (i) { i.alt = ''; });
    track.appendChild(copy);
  });

  /* Aviso al agregar al carrito por AJAX (WooCommerce dispara este evento con jQuery) */
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function () { toast('Agregado al carrito'); });
  }
})();
