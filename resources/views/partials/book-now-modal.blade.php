@php
    $bookingPhone = trim((string) ($setting->phone1 ?? ''));
    $bookingMinDate = now()->format('Y-m-d');
@endphp
<div class="modal fade cq-booking-modal" id="bookNowModal" tabindex="-1" role="dialog" aria-labelledby="bookNowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered cq-booking-modal__dialog" role="document">
    <div class="modal-content cq-booking-modal__content">
      <button type="button" class="cq-booking-modal__close" data-dismiss="modal" aria-label="Đóng">
        <span aria-hidden="true">&times;</span>
      </button>

      <div class="cq-booking-modal__grid">
        <aside class="cq-booking-modal__aside">
          <div class="cq-booking-modal__aside-inner">
            <p class="cq-booking-modal__eyebrow">Reservation</p>
            <h2 class="cq-booking-modal__aside-title">Đặt bàn</h2>
            <p class="cq-booking-modal__aside-text">
              Để lại thông tin, Chef Quân sẽ liên hệ xác nhận bàn trong thời gian sớm nhất.
            </p>
            @if($bookingPhone !== '')
            <a href="tel:{{ $bookingPhone }}" class="cq-booking-modal__hotline">
              <span>Hotline</span>
              <strong>{{ $bookingPhone }}</strong>
            </a>
            @endif
            @if(!empty($setting->address1))
            <p class="cq-booking-modal__address">{{ $setting->address1 }}</p>
            @endif
          </div>
        </aside>

        <div class="cq-booking-modal__main">
          <div class="cq-booking-modal__header">
            <h3 class="cq-booking-modal__title" id="bookNowModalLabel">Thông tin đặt bàn</h3>
            <p class="cq-booking-modal__subtitle">Vui lòng điền đầy đủ để chúng tôi chuẩn bị tốt nhất cho quý khách.</p>
          </div>

          <div class="cq-booking-modal__alerts">
            @if(session('success') && session('open_book_now_modal'))
            <div class="cq-booking-alert cq-booking-alert--success">{{ session('success') }}</div>
            @endif
            @if(session('error') && session('open_book_now_modal'))
            <div class="cq-booking-alert cq-booking-alert--error">{{ session('error') }}</div>
            @endif
            @if(isset($errors) && $errors->any() && old('book_now_modal'))
            <div class="cq-booking-alert cq-booking-alert--error">
              <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>

          <form action="{{ route('postcontact') }}" method="post" class="cq-booking-form" id="cqBookingForm">
            @csrf
            <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
            <input type="hidden" name="book_now_modal" value="1">

            <div class="cq-booking-form__row">
              <div class="cq-booking-field">
                <label for="book_now_name">Họ và tên *</label>
                <input type="text" id="book_now_name" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn A" required autocomplete="name">
              </div>
              <div class="cq-booking-field">
                <label for="book_now_phone">Số điện thoại *</label>
                <input type="tel" id="book_now_phone" name="phone" value="{{ old('phone') }}" placeholder="09xx xxx xxx" required autocomplete="tel">
              </div>
            </div>

            <div class="cq-booking-field">
              <label for="book_now_email">Email</label>
              <input type="email" id="book_now_email" name="email" value="{{ old('email') }}" placeholder="email@example.com" autocomplete="email">
            </div>

            <div class="cq-booking-form__row cq-booking-form__row--3">
              <div class="cq-booking-field">
                <label for="book_now_date">Ngày *</label>
                <input type="date" id="book_now_date" name="booking_date" value="{{ old('booking_date') }}" min="{{ $bookingMinDate }}" required>
              </div>
              <div class="cq-booking-field">
                <label for="book_now_time">Giờ *</label>
                <select id="book_now_time" name="booking_time" required>
                  <option value="">Chọn giờ</option>
                  @foreach (['10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00'] as $time)
                  <option value="{{ $time }}" {{ old('booking_time') === $time ? 'selected' : '' }}>{{ $time }}</option>
                  @endforeach
                </select>
              </div>
              <div class="cq-booking-field">
                <label for="book_now_guests">Số khách *</label>
                <select id="book_now_guests" name="guests" required>
                  <option value="">Chọn</option>
                  @for ($i = 1; $i <= 20; $i++)
                  <option value="{{ $i }}" {{ (string) old('guests') === (string) $i ? 'selected' : '' }}>{{ $i }} khách</option>
                  @endfor
                </select>
              </div>
            </div>

            <div class="cq-booking-field">
              <label for="book_now_mess">Ghi chú</label>
              <textarea id="book_now_mess" name="mess" rows="3" placeholder="Yêu cầu đặc biệt (sinh nhật, bàn gần cửa sổ...)">{{ old('mess') }}</textarea>
            </div>

            <button type="submit" class="cq-booking-submit">
              <span>Gửi yêu cầu đặt bàn</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@if(session('open_book_now_modal') || (isset($errors) && $errors->any() && old('book_now_modal')))
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (window.jQuery && jQuery.fn.modal) {
      jQuery('#bookNowModal').modal('show');
    }
  });
</script>
@endif
