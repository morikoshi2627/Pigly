@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.blade.css') }}" />
@endsection

@section('body')
<header class="header">
    <div class="header-inner">
        <nav class="nav-bar">
            <div class="logo">PiGly</div>
            <ul class="nav-links">
                <li>
                    <a class="setting-button" href="{{ route('weight_logs.goal_setting') }}"> <img class="icon-setting" src="{{ asset('storage/images/setting-icon.png') }}" alt="設定">
                        目標体重設定</a>
                </li>
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

<main class="show-edit">
    <div class="show-edit-inner">
        <h2 class="show-edit-title">Weight Log</h2>

        <form action="{{ route('weight_logs.update', ['weightLog' => $weightLog->id]) }}" method="POST" novalidate>
            @csrf

            <div class="edit-form">
                <!-- 日付（カレンダー、当日デフォルト） -->
                <label class="edit-title" for="date">日付</label>
                <input class="edit-input" type="date" name="date" value="{{ old('date', $weightLog->date) }}">
                @error('date')
                <div class="form-error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 体重（数値） -->
                <label class="edit-title" for="weight">体重</label>
                <div class="edit-unit">
                    <input class="edit-input" type="number" step="0.1" name="weight" value="{{ old('weight',  $weightLog->weight) }}">
                    <p>kg</p>
                </div>
                @error('weight')
                <div class="form-error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 摂取カロリー -->
                <label class="edit-title" for="calories">摂取カロリー</label>
                <div class="edit-unit">
                    <input class="edit-input" type="text" name="calories" value="{{ old('calories', $weightLog->calories) }}">
                    <p>kcal</p>
                </div>
                @error('calories')
                <div class="form-error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 運動時間（00:00形式） -->
                <label class="edit-title" for=" exercise_time">運動時間</label>
                <input class="edit-input" type="time" name="exercise_time" value="{{ old('exercise_time', sprintf('%02d:%02d', floor($weightLog->exercise_time / 60), $weightLog->exercise_time % 60)) }}">
                @error('exercise_time')
                <div class="form-error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 運動内容 -->
                <label class="edit-title" for=" exercise_content">運動内容</label>
                <input class="edit-input-content" type="text" name="exercise_content" value="{{ old('exercise_content', $weightLog->exercise_content) }}">
                @error('exercise_content')
                <div class="form-error">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-actions">
                <a class="back-button" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="submit-button" type="submit">更新する</button>
        </form>

        <!-- 削除処理 -->
        <form method="POST" action="{{ route('weight_logs.delete', ['weightLog' => $weightLog->id]) }}" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            <button class="icon-delete" type=" submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                <img src="{{ asset('storage/images/trash-icon.png') }}" alt="削除" style="width: 32px; height: 32px;">
            </button>
        </form>
    </div>
    </div>
</main>
@endsection