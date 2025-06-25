<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PiGly - ログイン画面</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

</head>

<body>
  
  <header class="header">
    <div class="header-inner">
      PiGly
    </div>
  </header>

  <main class="login-content">
    
    <div class="login-inner">

      <!-- タイトル -->
      <h2 class="login-title">ログイン</h2>

      <!-- ログイン用フォーム -->
      <form class="login-link" method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <div class="login-email">
          <input type="email" name="email" required />
          @error('email')
          <div class="form__error">
            {{ $message }}
          </div>
          @enderror
        </div>
        <div class="login-password">
          <input type="password" name="password" required />
          @error('password')
          <div class="form__error">
            {{ $message }}
          </div>
          @enderror
        </div>
        <button class="login-button" type="submit">ログイン</button>
      </form>

      <!-- ログインリンク -->
      <div class="register-login-link">
          <a href="{{ route('register.step1') }}">アカウント作成はこちら</a>
      </div>

    </div>
  </main>
</body>

</html>