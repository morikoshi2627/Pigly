<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGly - 会員登録画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />

</head>

<body>
    
    <header class="header">
        <div class="header-inner">
            PiGly
        </div>
    </header>

    <main class="register-title-content">
        
      <div class="register-inner">

            <!-- タイトル -->
            <h2 class="register-title">新規会員登録</h2>
            <p class="register-title-sub">STEP1 アカウント情報の登録</p>

            <!-- フォーム  -->
            <form class="register-form" action="{{ route('register.perform') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">お名前</label>
                    <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="名前を入力" required>
                    @error('name')
                    <div class="form__error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">メールアドレス</label>
                    <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力" required>
                    @error('email')
                    <div class="form__error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">パスワード</label>
                    <input class="form-input" type="password" id="password" name="password" placeholder="パスワードを入力" required>
                    @error('password')
                    <div class="form__error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="form-submit" type="submit">次に進む</button>
                </div>
            </form>

            <!-- ログインリンク -->
            <div class="register-login-link">
                <a href="{{ route('login') }}">ログインはこちら</a>
            </div>

        </div>
    </main>
</body>

</html>