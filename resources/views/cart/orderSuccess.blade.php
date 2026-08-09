<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Đặt hàng thành công" />
    <title>Đặt hàng thành công</title>
    <link rel="shortcut icon" href="{{ $setting->favicon }}" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --burgundy: #3c0202;
            --gold: rgb(230, 177, 95);
            --cream: #f9f0df;
            --cream-soft: #fffaf3;
            --success: #2f7d4a;
            --success-soft: #eef8f1;
            --text-sub: rgba(60, 2, 2, 0.62);
            --line: rgba(60, 2, 2, 0.1);
            --shadow: 0 22px 48px rgba(60, 2, 2, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Urbanist", "Segoe UI", sans-serif;
            color: var(--burgundy);
            background:
                radial-gradient(circle at top right, rgba(230, 177, 95, 0.28) 0%, transparent 42%),
                linear-gradient(160deg, #fff8ec 0%, var(--cream) 45%, #f3e4c8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .success-card {
            width: 100%;
            max-width: 760px;
            background: var(--cream-soft);
            border: 1px solid var(--line);
            border-radius: 22px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .success-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, #fffdf8 0%, #fff6e8 100%);
        }

        .success-header img {
            max-height: 46px;
            width: auto;
            object-fit: contain;
        }

        .badge-success {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--burgundy);
            background: rgba(230, 177, 95, 0.22);
            border: 1px solid rgba(230, 177, 95, 0.55);
            padding: 7px 12px;
            border-radius: 999px;
            text-transform: uppercase;
        }

        .success-body {
            padding: 36px 28px 30px;
            text-align: center;
        }

        .icon-wrap {
            width: 92px;
            height: 92px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: var(--success-soft);
            border: 1px solid rgba(47, 125, 74, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrap svg {
            width: 54px;
            height: 54px;
        }

        h1 {
            margin: 0;
            font-family: "Fraunces", Georgia, serif;
            font-size: 34px;
            line-height: 1.25;
            font-weight: 600;
            color: var(--burgundy);
        }

        .subtitle {
            margin: 12px auto 0;
            max-width: 540px;
            color: var(--text-sub);
            font-size: 16px;
            line-height: 1.7;
        }

        .info-strip {
            margin: 24px auto 0;
            max-width: 560px;
            border: 1px dashed rgba(230, 177, 95, 0.7);
            border-radius: 14px;
            background: rgba(230, 177, 95, 0.1);
            padding: 14px 16px;
            color: rgba(60, 2, 2, 0.72);
            font-size: 14px;
            line-height: 1.6;
        }

        .actions {
            margin-top: 28px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            min-width: 180px;
            height: 48px;
            border-radius: 12px;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f0c987 0%, var(--gold) 100%);
            color: var(--burgundy);
            box-shadow: 0 12px 26px rgba(230, 177, 95, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(230, 177, 95, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--burgundy);
            border-color: rgba(60, 2, 2, 0.18);
        }

        .btn-outline:hover {
            border-color: rgba(230, 177, 95, 0.7);
            background: rgba(230, 177, 95, 0.12);
        }

        .footer-note {
            margin-top: 18px;
            color: rgba(60, 2, 2, 0.45);
            font-size: 13px;
        }

        @media (max-width: 640px) {
            body { padding: 14px; }
            .success-card { border-radius: 18px; }
            .success-header,
            .success-body {
                padding-left: 16px;
                padding-right: 16px;
            }
            h1 { font-size: 26px; }
            .subtitle { font-size: 15px; }
            .btn { width: 100%; }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .success-card {
                box-shadow: none;
                border: 0;
            }
            .actions { display: none; }
        }
    </style>
</head>
<body>
    <section class="success-card">
        <header class="success-header">
            <a href="{{ route('home') }}">
                <img src="{{ $setting->logo }}" alt="{{ config('app.name') }}">
            </a>
            <span class="badge-success">Đặt hàng thành công</span>
        </header>

        <div class="success-body">
            <div class="icon-wrap">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="11" stroke="#2f7d4a" stroke-width="1.5"></circle>
                    <path d="M7 12.5L10.2 15.7L17 8.8" stroke="#2f7d4a" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>

            <h1>Cảm ơn bạn đã đặt hàng</h1>
            <p class="subtitle">
                Đơn hàng của bạn đã được ghi nhận. Đội ngũ Chef Quân sẽ liên hệ xác nhận trong thời gian sớm nhất.
            </p>

            <div class="info-strip">
                Bạn có thể kiểm tra email hoặc số điện thoại để nhận thông tin cập nhật đơn hàng.
            </div>

            <div class="actions">
                <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
                <a href="{{ route('allProduct') }}" class="btn btn-outline">Tiếp tục mua sắm</a>
            </div>

            <div class="footer-note">Chúc bạn ngon miệng cùng Chef Quân.</div>
        </div>
    </section>
</body>
</html>
