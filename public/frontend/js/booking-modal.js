(function ($) {
  "use strict";

  function openBookingModal(e) {
    if (e) e.preventDefault();
    if (!$ || !$.fn.modal) return;
    $("#bookNowModal").modal("show");
  }

  $(document).on("click", "[data-open-booking], .js-open-booking", openBookingModal);

  $("#bookNowModal").on("shown.bs.modal", function () {
    var first = document.getElementById("book_now_name");
    if (first) first.focus();
  });
})(window.jQuery);
