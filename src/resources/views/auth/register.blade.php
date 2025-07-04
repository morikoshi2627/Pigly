@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('body')
<div class="pigly-whole">
    <div class="pigly-inner">
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
                    <div class="input-area">
                        <div class="form-group">
                            <label class="form-label" for="name">お名前</label>
                            <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="名前を入力" required>
                            @error('name')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">メールアドレス</label>
                            <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力" required>
                            @error('email')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password">パスワード</label>
                            <input class="form-input" type="password" id="password" name="password" placeholder="パスワードを入力" required>
                            @error('password')
                            <div class="form-error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="form-submit" type="submit">次に進む</button>
                    </div>
                </form>

                <!-- ログインリンク -->
                <div class="register-login-link">
                    <a class="login-button" href="{{ route('login') }}">ログインはこちら</a>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection