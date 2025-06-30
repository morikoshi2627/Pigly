@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('body')
<div class="pigly-whole">
    <div class="pigly-inner">
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
                    <div class="input-area">
                        <div class="form-group">
                            <label class="form-label" for="email">メールアドレス</label>
                            <input class="form-input" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力" required />
                            @error('email')
                            <div class="form__error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">パスワード</label>
                            <input class="form-input" type="password" name="password" placeholder="パスワードを入力" required />
                            @error('password')
                            <div class="form__error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="login-button" type="submit">ログイン</button>
                    </div>
                </form>

                <!-- ログインリンク -->
                <div class="account-link">
                    <a class="account-button" href="{{ route('register.step1') }}">アカウント作成はこちら</a>
                </div>

            </div>
        </main>
    </div>
</div>
@endsection