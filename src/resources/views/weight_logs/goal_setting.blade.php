@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/goal_setting.css') }}" />
@endsection

@section('body')
<header class="header">
    <div class="header-inner">
        <nav class="nav-bar">
            <div class="logo">PiGly</div>
            <ul class="nav-links">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="logout-button" type="submit"><img class="icon-logout" src="{{ asset('storage/images/logout-icon.png') }}" alt="設定">ログアウト</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main class="goal-setting">
    <div class="goal-setting-inner">
        <div class="goal-setting-title">
            <h2>目標体重設定</h2>
        </div>
        <form method="POST" action="{{ route('weight_logs.goal_setting.update') }}">
            @csrf
            <div class="form-group">
                <input class="form-area" type="text" id="target_weight" name="target_weight"
                    value="{{ old('target_weight', isset($target->target_weight) ? number_format($target->target_weight, 1) : '') }}">
                <p class="goal-unit">kg</p>
            </div>
            @error('target_weight')
            <p class="error">{{ $message }}</p>
            @enderror


            <div class="form-actions">
                <a class="back-button" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="submit-button" type="submit">更新する</button>
            </div>
        </form>
    </div>
</main>
@endsection