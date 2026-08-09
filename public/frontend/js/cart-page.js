(function () {
  "use strict";

  var routes = window.cartPageRoutes || {};
  var cartRoot = document.querySelector(".js-cart");
  if (!cartRoot) return;

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

  function updateCountLabels(count) {
    document.querySelectorAll(".js-cart-count-label").forEach(function (el) {
      el.textContent = count + " sản phẩm";
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

  function reloadIfEmpty(count) {
    if (Number(count) <= 0) {
      window.location.reload();
    }
  }

  function updateQty(itemEl, nextQty) {
    var key = itemEl.getAttribute("data-cart-key");
    if (!key || !routes.update) return;

    postForm(routes.update, { id: key, quantity: nextQty })
      .then(function (result) {
        if (!result.ok || !result.data || !result.data.success) return;

        var qtyInput = itemEl.querySelector(".js-quantity");
        var lineTotal = itemEl.querySelector(".js-line-total");
        if (qtyInput) qtyInput.value = result.data.quantity;
        if (lineTotal) lineTotal.textContent = formatMoney(result.data.line_total);

        document.querySelectorAll(".js-cart-total").forEach(function (el) {
          el.textContent = formatMoney(result.data.total);
        });
        updateHeaderCount(result.data.cart_count);
        updateCountLabels(result.data.cart_count);
      })
      .catch(function () {});
  }

  cartRoot.addEventListener("click", function (e) {
    var minus = e.target.closest(".cart-qty__btn--minus");
    var plus = e.target.closest(".cart-qty__btn--plus");
    var remove = e.target.closest(".cart-item__remove");
    var itemEl = e.target.closest(".cart-item");
    if (!itemEl) return;

    if (minus || plus) {
      var input = itemEl.querySelector(".js-quantity");
      var current = Math.max(1, parseInt(input && input.value, 10) || 1);
      var next = minus ? Math.max(1, current - 1) : current + 1;
      if (next !== current) updateQty(itemEl, next);
      return;
    }

    if (remove && routes.remove) {
      var key = itemEl.getAttribute("data-cart-key");
      postForm(routes.remove, { id: key })
        .then(function (result) {
          if (!result.ok || !result.data || !result.data.success) return;
          itemEl.remove();
          document.querySelectorAll(".js-cart-total").forEach(function (el) {
            el.textContent = formatMoney(result.data.total);
          });
          updateHeaderCount(result.data.cart_count);
          updateCountLabels(result.data.cart_count);
          reloadIfEmpty(result.data.cart_count);
        })
        .catch(function () {});
    }
  });

  var clearBtn = document.querySelector(".js-clearcart");
  if (clearBtn && routes.clear) {
    clearBtn.addEventListener("click", function () {
      if (!window.confirm("Bạn chắc chắn muốn xóa tất cả sản phẩm trong giỏ?")) return;
      postForm(routes.clear, {})
        .then(function (result) {
          if (!result.ok || !result.data || !result.data.success) return;
          updateHeaderCount(0);
          window.location.reload();
        })
        .catch(function () {});
    });
  }
})();
