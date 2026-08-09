(function () {
  "use strict";

  var root = document.getElementById("checkout-page");
  if (!root) return;

  var updateUrl = root.getAttribute("data-update-url");
  var removeUrl = root.getAttribute("data-remove-url");
  var cartUrl = root.getAttribute("data-cart-url");
  var shippingFee = Number(root.getAttribute("data-shipping-fee") || 0);

  function csrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute("content") : "";
  }

  function formatMoney(value) {
    var n = Math.round(Number(value) || 0);
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "₫";
  }

  function updateHeaderCount(count) {
    document.querySelectorAll(".cart-count, .js-cart-count").forEach(function (el) {
      el.textContent = count;
      el.setAttribute("data-count", count);
      el.hidden = Number(count) < 1;
    });
  }

  function postForm(url, data) {
    var body = new FormData();
    Object.keys(data).forEach(function (key) {
      body.append(key, data[key]);
    });
    body.append("_token", csrfToken());

    return fetch(url, {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": csrfToken(),
        Accept: "application/json",
      },
      body: body,
      credentials: "same-origin",
    }).then(function (res) {
      return res.json().then(function (json) {
        return { ok: res.ok, data: json };
      });
    });
  }

  function refreshTotals(subtotal) {
    var grand = Number(subtotal || 0) + shippingFee;
    var subEl = document.getElementById("checkout-subtotal-display");
    var shipEl = document.getElementById("checkout-shipping-display");
    var totalEl = document.getElementById("checkout-total-display");
    var hiddenTotal = document.getElementById("checkout-total-money");
    if (subEl) subEl.textContent = formatMoney(subtotal);
    if (shipEl) shipEl.textContent = formatMoney(shippingFee);
    if (totalEl) totalEl.textContent = formatMoney(grand);
    if (hiddenTotal) hiddenTotal.value = grand;
  }

  function updateQty(id, qty) {
    if (!updateUrl) return;
    postForm(updateUrl, { id: id, quantity: qty })
      .then(function (result) {
        if (!result.ok || !result.data || !result.data.success) return;
        var line = document.getElementById("line-total-" + id);
        var input = document.querySelector('.js-qty-input[data-id="' + id + '"]');
        if (line) line.textContent = formatMoney(result.data.line_total);
        if (input) input.value = result.data.quantity;
        refreshTotals(result.data.total);
        updateHeaderCount(result.data.cart_count);
      })
      .catch(function () {});
  }

  root.addEventListener("click", function (e) {
    var minus = e.target.closest(".js-qty-minus");
    var plus = e.target.closest(".js-qty-plus");
    var remove = e.target.closest(".js-remove-item");

    if (minus || plus) {
      var btn = minus || plus;
      var id = btn.getAttribute("data-id");
      var input = document.querySelector('.js-qty-input[data-id="' + id + '"]');
      var current = Math.max(1, parseInt(input && input.value, 10) || 1);
      var next = minus ? Math.max(1, current - 1) : current + 1;
      if (next !== current) updateQty(id, next);
      return;
    }

    if (remove && removeUrl) {
      var removeId = remove.getAttribute("data-id");
      postForm(removeUrl, { id: removeId })
        .then(function (result) {
          if (!result.ok || !result.data || !result.data.success) return;
          var row = document.getElementById("checkout-item-" + removeId);
          if (row) row.remove();
          refreshTotals(result.data.total);
          updateHeaderCount(result.data.cart_count);
          if (Number(result.data.cart_count) <= 0) {
            window.location.href = cartUrl || "/gio-hang.html";
          }
        })
        .catch(function () {});
    }
  });

  document.querySelectorAll(".js-payment-choice").forEach(function (input) {
    input.addEventListener("change", function () {
      var hidden = document.getElementById("checkout-payment-method");
      if (hidden) hidden.value = input.value;
    });
  });
})();
