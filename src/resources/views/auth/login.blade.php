<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="site-title">FashionablyLate</h1>
            <a href="/register" class="register-btn">register</a>
        </div>
    </header>
    <main>
        <div class="container">
            <h2 class="login-title">Login</h2>
            <div class="login-box">
                <form method="POST" action="/login" novalidate>
                    @csrf
                    <div class="form-group">
                        <label class="form-label">メールアドレス</label>
                        <input type="email" name="email" class="form-input" placeholder="例: test@example.com">
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">パスワード</label>
                        <input type="password" name="password" class="form-input" placeholder="例: coachtech1106" >
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="submit-btn-wrapper">
                        <button type="submit" class="submit-btn">ログイン</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>