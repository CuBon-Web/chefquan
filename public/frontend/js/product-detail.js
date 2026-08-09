(function () {
  "use strict";

  function ready(fn) {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", fn);
    } else {
      fn();
    }
  }

  function formatMoney(value) {
    var num = Number(value || 0);
    return num.toLocaleString("vi-VN") + "₫";
  }

  function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute("content") : "";
  }

  function showToast(message, isError) {
    var toast = document.getElementById("pd-toast");
    if (!toast) {
      toast = document.createElement("div");
      toast.id = "pd-toast";
      toast.className = "pd-toast";
      toast.setAttribute("aria-live", "polite");
      document.body.appendChild(toast);
    }
    toast.textContent = message || "";
    toast.classList.toggle("is-error", !!isError);
    toast.classList.add("is-show");
    clearTimeout(showToast._timer);
    showToast._timer = setTimeout(function () {
      toast.classList.remove("is-show");
    }, 2600);
  }

  function initGallery() {
    if (typeof Swiper === "undefined") return;

    var mainEl = document.querySelector(".product-detail-gallery-main");
    var thumbsEl = document.querySelector(".product-detail-gallery-thumbs");
    if (!mainEl) return;

    var thumbsSwiper = null;
    if (thumbsEl) {
      thumbsSwiper = new Swiper(thumbsEl, {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
          0: { slidesPerView: 3.5 },
          576: { slidesPerView: 4 },
          992: { slidesPerView: 5 },
        },
      });
    }

    new Swiper(mainEl, {
      spaceBetween: 10,
      speed: 500,
      loop: mainEl.querySelectorAll(".swiper-slide").length > 1,
      navigation: {
        nextEl: mainEl.querySelector(".product-detail-gallery-next"),
        prevEl: mainEl.querySelector(".product-detail-gallery-prev"),
      },
      thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : undefined,
    });
  }

  function initTabs() {
    var nav = document.querySelector(".product-detail-tabs__nav");
    if (!nav) return;

    var buttons = nav.querySelectorAll("button[data-tab]");
    var panels = document.querySelectorAll(".product-detail-tabs__panel");

    buttons.forEach(function (btn) {
      btn.addEventListener("click", function () {
        var tabId = btn.getAttribute("data-tab");
        buttons.forEach(function (b) {
          b.classList.toggle("active", b === btn);
        });
        panels.forEach(function (panel) {
          panel.classList.toggle("active", panel.id === tabId);
        });
      });
    });
  }

  function initPurchase() {
    var form = document.getElementById("product-purchase-form");
    if (!form) return;

    var qtyInput = form.querySelector(".pd-quantity-input");
    var minusBtn = form.querySelector(".pd-qty-minus");
    var plusBtn = form.querySelector(".pd-qty-plus");
    var addCartBtn = form.querySelector(".pd-btn--cart");
    var buyNowBtn = form.querySelector(".pd-btn--buy");
    var priceCurrent = document.getElementById("pd-price-current");
    var priceOld = document.getElementById("pd-price-old");

    var productId = form.getAttribute("data-product-id");
    var addCartUrl = form.getAttribute("data-add-cart-url");
    var checkoutUrl = form.getAttribute("data-checkout-url");
    var statusVariant = Number(form.getAttribute("data-status-variant") || 0);
    var originalPrice = Number(form.getAttribute("data-original-price") || 0);
    var salePrice = Number(form.getAttribute("data-sale-price") || 0);

    var variants = [];
    var variantOptions = [];
    try {
      variants = JSON.parse(form.getAttribute("data-variants") || "[]") || [];
    } catch (e) {
      variants = [];
    }
    try {
      variantOptions = JSON.parse(form.getAttribute("data-variant-options") || "[]") || [];
    } catch (e) {
      variantOptions = [];
    }

    function clampQty(value) {
      var qty = parseInt(value, 10);
      if (isNaN(qty) || qty < 1) qty = 1;
      if (qty > 999) qty = 999;
      return qty;
    }

    function getSelectedValues() {
      var values = [];
      form.querySelectorAll(".pd-variant-group").forEach(function (group) {
        var checked = group.querySelector('input[type="radio"]:checked');
        values.push(checked ? checked.value : "");
      });
      return values;
    }

    function updateSelectedLabels() {
      form.querySelectorAll(".pd-variant-group").forEach(function (group) {
        var checked = group.querySelector('input[type="radio"]:checked');
        var label = group.querySelector(".pd-variant-selected");
        if (label) label.textContent = checked ? checked.value : "";
      });
    }

    function findMatchedVariant(selected) {
      if (!selected.length || selected.some(function (v) { return !v; })) {
        return null;
      }

      var joinedSlash = selected.join(" / ");
      var joinedDash = selected.join("-");
      var joinedComma = selected.join(", ");

      for (var i = 0; i < variants.length; i++) {
        var version = String(variants[i].version || "").trim();
        if (
          version === joinedSlash ||
          version === joinedDash ||
          version === joinedComma ||
          version === selected.join(" ")
        ) {
          return variants[i];
        }
      }

      for (var j = 0; j < variants.length; j++) {
        var ver = String(variants[j].version || "");
        var allMatch = selected.every(function (val) {
          return ver.indexOf(val) !== -1;
        });
        if (allMatch) return variants[j];
      }

      if (selected.length === 1) {
        for (var k = 0; k < variants.length; k++) {
          if (String(variants[k].version || "") === selected[0]) {
            return variants[k];
          }
        }
      }

      return null;
    }

    function updatePrice() {
      if (!priceCurrent) return;

      if (statusVariant === 1 && variants.length) {
        var matched = findMatchedVariant(getSelectedValues());
        if (matched && matched.price > 0) {
          priceCurrent.textContent = formatMoney(matched.price);
          if (priceOld) {
            if (originalPrice > matched.price) {
              priceOld.textContent = formatMoney(originalPrice);
              priceOld.style.display = "";
            } else {
              priceOld.style.display = "none";
            }
          }
          return matched;
        }
      }

      var current =
        salePrice > 0 && (originalPrice <= 0 || salePrice < originalPrice)
          ? salePrice
          : originalPrice;
      priceCurrent.textContent = current > 0 ? formatMoney(current) : "Liên hệ";
      if (priceOld) {
        if (salePrice > 0 && originalPrice > salePrice) {
          priceOld.textContent = formatMoney(originalPrice);
          priceOld.style.display = "";
        } else {
          priceOld.style.display = "none";
        }
      }
      return null;
    }

    function getPayloadPrice(matched) {
      if (matched && matched.price > 0) return matched.price;
      if (salePrice > 0 && (originalPrice <= 0 || salePrice < originalPrice)) {
        return salePrice;
      }
      return originalPrice > 0 ? originalPrice : 0;
    }

    function setLoading(isLoading) {
      if (addCartBtn) addCartBtn.disabled = !!isLoading;
      if (buyNowBtn) buyNowBtn.disabled = !!isLoading;
    }

    function addToCart(redirectCheckout) {
      if (statusVariant === 1 && variants.length) {
        var selected = getSelectedValues();
        if (selected.some(function (v) { return !v; })) {
          showToast("Vui lòng chọn phân loại sản phẩm", true);
          return;
        }
        var matchedCheck = findMatchedVariant(selected);
        if (!matchedCheck) {
          showToast("Phân loại không hợp lệ", true);
          return;
        }
      }

      var matched = updatePrice();
      var quantity = clampQty(qtyInput ? qtyInput.value : 1);
      if (qtyInput) qtyInput.value = quantity;

      var selectedValues = getSelectedValues().filter(Boolean);
      var variantText = selectedValues.join(" / ");

      var body = new FormData();
      body.append("product_id", productId);
      body.append("quantity", quantity);
      body.append("price", getPayloadPrice(matched));
      body.append("variant", variantText);
      body.append("_token", getCsrfToken());

      setLoading(true);
      fetch(addCartUrl, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": getCsrfToken(),
          Accept: "application/json",
        },
        body: body,
        credentials: "same-origin",
      })
        .then(function (res) {
          return res.json().then(function (data) {
            return { ok: res.ok, data: data };
          });
        })
        .then(function (result) {
          setLoading(false);
          if (!result.ok || !result.data || !result.data.success) {
            showToast(
              (result.data && result.data.message) || "Không thể thêm vào giỏ hàng",
              true
            );
            return;
          }

          showToast(result.data.message || "Đã thêm vào giỏ hàng");

          if (typeof result.data.cart_count !== "undefined") {
            document.querySelectorAll(".cart-count, .js-cart-count").forEach(function (el) {
              el.textContent = result.data.cart_count;
              el.setAttribute("data-count", result.data.cart_count);
              el.hidden = Number(result.data.cart_count) < 1;
            });
          }

          if (redirectCheckout) {
            window.location.href = checkoutUrl || result.data.redirect_checkout || "/thanh-toan.html";
          }
        })
        .catch(function () {
          setLoading(false);
          showToast("Có lỗi xảy ra, vui lòng thử lại", true);
        });
    }

    if (minusBtn && qtyInput) {
      minusBtn.addEventListener("click", function () {
        qtyInput.value = clampQty(Number(qtyInput.value) - 1);
      });
    }
    if (plusBtn && qtyInput) {
      plusBtn.addEventListener("click", function () {
        qtyInput.value = clampQty(Number(qtyInput.value) + 1);
      });
    }
    if (qtyInput) {
      qtyInput.addEventListener("change", function () {
        qtyInput.value = clampQty(qtyInput.value);
      });
    }

    form.querySelectorAll('.pd-variant-option input[type="radio"]').forEach(function (input) {
      input.addEventListener("change", function () {
        updateSelectedLabels();
        updatePrice();
      });
    });

    if (addCartBtn) {
      addCartBtn.addEventListener("click", function () {
        addToCart(false);
      });
    }
    if (buyNowBtn) {
      buyNowBtn.addEventListener("click", function () {
        addToCart(true);
      });
    }

    updateSelectedLabels();
    updatePrice();
  }

  function initCompare() {
    var btn = document.querySelector(".product-detail-page .js-compare-product-add");
    if (!btn) return;

    btn.addEventListener("click", function (e) {
      e.preventDefault();
      var sidebar = document.querySelector(".compare-sidebar");
      var addUrl = sidebar ? sidebar.getAttribute("data-add-url") : "";
      if (!addUrl) {
        showToast("Chức năng so sánh chưa sẵn sàng", true);
        return;
      }

      var body = new FormData();
      body.append("id", btn.getAttribute("data-product-id") || "");
      body.append("slug", btn.getAttribute("data-compare") || "");
      body.append("type", btn.getAttribute("data-type") || "");
      body.append("_token", getCsrfToken());

      fetch(addUrl, {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": getCsrfToken(),
          Accept: "application/json",
        },
        body: body,
        credentials: "same-origin",
      })
        .then(function (res) {
          return res.json().catch(function () {
            return {};
          });
        })
        .then(function (data) {
          showToast((data && data.message) || "Đã thêm vào danh sách so sánh");
          if (sidebar && sidebar.classList) {
            var box = sidebar.querySelector(".sidebarAllMainCompare");
            if (box) box.classList.add("active");
          }
        })
        .catch(function () {
          showToast("Không thể thêm so sánh", true);
        });
    });
  }

  ready(function () {
    if (!document.querySelector(".product-detail-page")) return;
    initGallery();
    initTabs();
    initPurchase();
    initCompare();
  });
})();
