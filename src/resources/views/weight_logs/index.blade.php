@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<main>
    <div class="index-whole">
        <div class="index-content">
            <!-- 体重情報 -->
            <div class="weight-summary">
                <div class="summary-box">
                    <p class="summary-label">目標体重</p>
                    <p class="summary-value">
                        {{ isset($target->target_weight) ? number_format($target->target_weight, 1) : '未設定' }}<span class="summary-unit">kg</span>
                    </p>
                </div>
                <div class="summary-box">
                    <p class="summary-label">目標まで</p>
                    <p class="summary-value">
                        @if (isset($diff))
                        {{ $diff < 0 ? '-' : '' }}{{ number_format(abs($diff), 1) }}<span class="summary-unit">kg</span>
                        @else
                        ---
                        @endif
                    </p>
                </div>
                <div class="summary-box">
                    <p class="summary-label">現在体重</p>
                    <p class="summary-value">
                        {{ isset($currentWeight->weight) ? number_format($currentWeight->weight, 1) : '記録なし' }}<span class="summary-unit">kg</span>
                    </p>
                </div>
            </div>
            <div class="list-container">
                <div class="log-list">
                    <!-- 検索フォーム -->
                    <form class="search-form" method="GET" action="{{ route('weight_logs.search') }}">
                        <div class="search-left">
                            <input class="date-area" type="date" name="start_date" value="{{ request('start_date') }}" . placeholder="年/月/日">
                            <p>〜</p>
                            <input class="date-area" type="date" name="end_date" value="{{ request('end_date') }}" placeholder="年/月/日">

                            <button type="submit" class="search-button">検索</button>

                            @if(request('start_date') || request('end_date'))
                            <a class="reset-button" href="{{ route('weight_logs.index') }}">リセット</a>
                            @endif
                        </div>

                        <!-- データを追加ボタン -->
                        <div class="search-right">
                            <label class="add-button" for="modal-toggle">データを追加</label>
                        </div>
                    </form>

                    <!-- 検索条件と件数 -->
                    @if(request('start_date') || request('end_date'))
                    <p class="search-result">
                        {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('Y年n月j日') : '' }}
                        ～
                        {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('Y年n月j日') : '' }} の検索結果 {{ $weightLogs->total() }}件
                    </p>
                    @endif

                    <!-- 一覧ヘッダー -->
                    <div class="log-list">
                        <div class="log-header">
                            <span class="log-date">日付</span>
                            <span class="log-weight">体重</span>
                            <span class="log-calories">食事摂取カロリー</span>
                            <span class="log-exercise">運動時間</span>
                            <span class="log-edit">編集</span>
                        </div>

                        <!-- 各ログ -->
                        @foreach($weightLogs as $log)
                        <div class="log-row">
                            <span class="log-date">{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</span>
                            <span class="log-weight">{{ number_format($log->weight, 1) }}kg</span>
                            <span class="log-calories">{{ $log->calories ?? '---' }}kcal</span>
                            <span class="log-exercise">
                                @if($log->exercise_time)
                                {{ sprintf('%02d:%02d', floor($log->exercise_time / 60), $log->exercise_time % 60) }}
                                @else
                                ---
                                @endif
                            </span>
                            <span class="log-edit">
                                <a href="{{ route('weight_logs.edit', ['weightLog' => $log->id]) }}">
                                    <img class="icon-pencil" src="{{ asset('storage/images/pencil-icon.png') }}" alt="編集">
                                </a>
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- ページネーション -->
                <div class="pagination">
                    {{ $weightLogs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
</main>

<!-- モーダルを維持 -->
<input type="checkbox" id="modal-toggle" class="modal-checkbox" hidden
    {{ count($errors) > 0 ? 'checked' : '' }}>

<!-- モーダル開閉チェックボックス -->
<input class="modal-checkbox" type="checkbox" id="modal-toggle" hidden>

<!-- モーダルウィンドウ本体 -->
<div class="modal">
    <div class="modal-content">

        <!-- 登録フォーム -->
        <div class="modal-header">Weight Logを追加
        </div>
        <form class="modal-form" action="{{ route('weight_logs.store') }}" method="POST" novalidate>
            @csrf
            <label class="modal-title">日付
                <span class="label-required">必須</span>
            </label>
            <input class="modal-input" type="date" name="date" value="{{ old('date') }}" placeholder="年/月/日">
            @error('date')
            <p class="error">{{ $message }}</p>
            @enderror

            <label class="modal-title">体重
                <span class="label-required">必須</span>
            </label>
            <div class="input-with-unit">
                <input class="modal-input" type="text" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                <span class="unit">kg</span>
            </div>
            @error('weight')
            <p class="error">{{ $message }}</p>
            @enderror

            <label class="modal-title">摂取カロリー
                <span class="label-required">必須</span>
            </label>
            <div class="input-with-unit">
                <input class="modal-input" type="text" name="calories" value="{{ old('calories') }}" placeholder="1200">
                <span class="unit">kcal</span>
            </div>
            @error('calories')
            <p class="error">{{ $message }}</p>
            @enderror

            <label class="modal-title">運動時間
                <span class="label-required">必須</span>
            </label>
            <input class="modal-input" type="time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="00:00">
            @error('exercise_time')
            <p class="error">{{ $message }}</p>
            @enderror

            <label class="modal-title">運動内容
                <span class="label-required">必須</span>
            </label>
            <input class="modal-input-content" type="text" name="exercise_content" value="{{ old('exercise_content') }}" placeholder="運動内容を追加">
            @error('exercise_content')
            <p class="error">{{ $message }}</p>
            @enderror

            <div class="buttons">
                <a class="back-button" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="submit-button" type="submit">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection