/**
 * Lazy media helpers:
 * - Native lazy for img[loading=lazy]
 * - data-bg / data-bg-pc / data-bg-mobile for background images
 * - Auto mark below-fold images missing loading attr (skip .no-lazy / [data-no-lazy])
 */
(function () {
  "use strict";

  var rootMargin = "200px 0px";

  function applyBg(el) {
    if (!el || el.getAttribute("data-bg-loaded") === "1") return;

    var bg = el.getAttribute("data-bg");
    var bgPc = el.getAttribute("data-bg-pc");
    var bgMobile = el.getAttribute("data-bg-mobile");

    if (bgPc || bgMobile) {
      var isMobile = window.matchMedia && window.matchMedia("(max-width: 767px)").matches;
      var url = isMobile ? (bgMobile || bgPc || bg) : (bgPc || bgMobile || bg);
      if (url) el.style.backgroundImage = 'url("' + url + '")';
    } else if (bg) {
      el.style.backgroundImage = 'url("' + bg + '")';
    }

    el.setAttribute("data-bg-loaded", "1");
    el.classList.add("is-bg-loaded");
  }

  function observeBg(elements) {
    if (!elements || !elements.length) return;

    if (!("IntersectionObserver" in window)) {
      Array.prototype.forEach.call(elements, applyBg);
      return;
    }

    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          applyBg(entry.target);
          io.unobserve(entry.target);
        });
      },
      { rootMargin: rootMargin, threshold: 0.01 }
    );

    Array.prototype.forEach.call(elements, function (el) {
      io.observe(el);
    });
  }

  function markImagesLazy() {
    var imgs = document.querySelectorAll("img:not([loading]):not(.no-lazy):not([data-no-lazy])");
    Array.prototype.forEach.call(imgs, function (img) {
      if (img.closest(".banner-section, .main-header .logo-box, .cq-fab-booking")) return;
      img.setAttribute("loading", "lazy");
      if (!img.hasAttribute("decoding")) img.setAttribute("decoding", "async");
    });
  }

  function warmBannerSlides() {
    var nodes = document.querySelectorAll(
      ".banner-slider .swiper-slide-active [data-bg], .banner-slider .swiper-slide-next [data-bg], .banner-slider .swiper-slide-prev [data-bg]"
    );
    Array.prototype.forEach.call(nodes, applyBg);
  }

  function bindBannerSwiper() {
    var slider = document.querySelector(".banner-slider");
    if (!slider) return;
    warmBannerSlides();
    setInterval(warmBannerSlides, 1200);
    document.addEventListener("click", function (e) {
      if (e.target.closest(".banner-slider .swiper-button-next, .banner-slider .swiper-button-prev")) {
        setTimeout(warmBannerSlides, 80);
      }
    });
  }

  function init() {
    markImagesLazy();
    observeBg(document.querySelectorAll("[data-bg], [data-bg-pc], [data-bg-mobile]"));
    bindBannerSwiper();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }

  window.ChefQuanLazyMedia = {
    refresh: function (root) {
      var scope = root || document;
      markImagesLazy();
      observeBg(scope.querySelectorAll("[data-bg], [data-bg-pc], [data-bg-mobile]"));
      warmBannerSlides();
    },
  };
})();
