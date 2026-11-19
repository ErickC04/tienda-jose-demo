/* NIA · carrito de demostración para la versión estática (GitHub Pages).
   Guarda el carrito en el navegador y lo muestra en el carrito lateral del tema. El pago no se procesa. */
(function () {
  var KEY = 'nia-demo-cart';
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var money = function (n) { return '$' + Math.round(n).toLocaleString('en-US') + '&nbsp;MXN'; };
  var esc = function (s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); };
  function load() { try { return JSON.parse(localStorage.getItem(KEY)) || []; } catch (e) { return []; } }
  function save(c) { try { localStorage.setItem(KEY, JSON.stringify(c)); } catch (e) {} }
  var cart = load();
  function toast(m) { if (window.niaToast) window.niaToast(m); }
  function render() {
    var box = $('#cart .widget_shopping_cart_content');
    var count = cart.reduce(function (a, i) { return a + i.q; }, 0);
    document.querySelectorAll('.cart-count').forEach(function (el) { el.textContent = count; });
    if (!box) return;
    if (!cart.length) { box.innerHTML = '<p class="woocommerce-mini-cart__empty-message">Tu carrito está vacío.</p><p style="text-align:center"><a class="btn" href="' + (document.querySelector('.nav a') || { href: '#' }).href + '">Ver piezas en stock</a></p>'; return; }
    var total = 0;
    box.innerHTML = '<ul class="woocommerce-mini-cart cart_list product_list_widget">' + cart.map(function (i, k) {
      total += i.p * i.q;
      return '<li class="woocommerce-mini-cart-item mini_cart_item">' +
        '<a href="#" class="remove" data-rm="' + k + '" aria-label="Quitar ' + esc(i.n) + '">×</a>' +
        '<a href="' + esc(i.u || '#') + '"><img src="' + esc(i.img) + '" alt="">' + esc(i.n) + '</a>' +
        (i.s ? '<dl class="variation"><dt>Medida:</dt> <dd>' + esc(i.s) + '</dd></dl>' : '') +
        '<span class="quantity"><span class="nia-qty"><button type="button" data-q="' + k + ':-1" aria-label="Quitar uno">−</button><b>' + i.q + '</b><button type="button" data-q="' + k + ':1" aria-label="Agregar uno">+</button></span> × ' + money(i.p) + '</span>' +
        '</li>';
    }).join('') + '</ul>' +
      '<p class="woocommerce-mini-cart__total total"><strong>Subtotal:</strong> <span class="amount">' + money(total) + '</span></p>' +
      '<p class="nia-demo-note">Envío calculado al pagar. Vista de demostración: el pago se activa en la tienda real.</p>' +
      '<p class="woocommerce-mini-cart__buttons buttons"><a href="#" class="button checkout wc-forward" data-demo-pay>Finalizar compra</a><a href="#" class="button wc-forward" data-close-cart>Seguir comprando</a></p>';
  }
  function add(item) {
    var f = cart.find(function (i) { return i.n === item.n && i.s === item.s; });
    if (f) f.q++; else cart.push(item);
    save(cart); render();
    if (window.niaOpen) window.niaOpen('cart');
  }
  document.addEventListener('click', function (e) {
    var a = e.target.closest('.add_to_cart_button');
    if (a) {
      e.preventDefault(); e.stopImmediatePropagation();
      var card = a.closest('.card');
      add({ n: a.dataset.niaName || (card && card.querySelector('.card-title').textContent.trim()), p: +a.dataset.niaPrice || 0, s: a.dataset.niaSize || '', img: a.dataset.niaImg || '', u: card ? card.querySelector('.card-title a').href : '#', q: 1 });
      return;
    }
    var rm = e.target.closest('[data-rm]');
    if (rm) { e.preventDefault(); cart.splice(+rm.dataset.rm, 1); save(cart); render(); return; }
    var q = e.target.closest('[data-q]');
    if (q) { var p = q.dataset.q.split(':'); var it = cart[+p[0]]; it.q += +p[1]; if (it.q < 1) cart.splice(+p[0], 1); save(cart); render(); return; }
    if (e.target.closest('[data-demo-pay]')) { e.preventDefault(); toast('Vista de demostración: el pago con tarjeta, OXXO o transferencia se activa en la tienda real.'); return; }
    if (e.target.closest('[data-close-cart]')) { e.preventDefault(); var d = $('#cart'); if (d) d.close(); return; }
    var acct = e.target.closest('a[aria-label="Cuenta"]');
    if (acct) { e.preventDefault(); toast('Vista de demostración: las cuentas de cliente se activan en la tienda real.'); }
  }, true);
  /* Ficha de producto: toma nombre, medida elegida, precio e imagen */
  document.addEventListener('submit', function (e) {
    var f = e.target;
    if (f.matches('form.cart')) {
      e.preventDefault(); e.stopImmediatePropagation();
      var sel = f.querySelector('select[name^="attribute_"]');
      if (sel && !sel.value) { toast('Elige una medida primero.'); return; }
      var priceText = (f.querySelector('.woocommerce-variation-price .amount') || document.querySelector('.summary .price ins .amount') || document.querySelector('.summary .price .amount') || {}).textContent || '0';
      var img = document.querySelector('.woocommerce-product-gallery__image img');
      add({ n: (document.querySelector('.product_title') || {}).textContent || 'Pieza', p: +priceText.replace(/[^\d.]/g, '') || 0, s: sel ? sel.value : ((document.querySelector('.specs dd') && '') || ''), img: img ? (img.currentSrc || img.src) : '', u: location.href, q: 1 });
      return;
    }
    if (f.getAttribute('role') === 'search') {
      e.preventDefault();
      location.href = (document.querySelector('.nav a') || { href: './' }).href;
    }
  }, true);
  render();
})();
