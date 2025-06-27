<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGly - 体重管理画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

</head>

<body>

    <header class="header">
        <div class="header-inner">
            <nav class="nav-bar">
                <div class="logo">PiGly</div>
                <ul class="nav-links">
                    <li>
                        <a href="{{ route('weight_logs.goal_setting') }}">目標体重設定</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="logout-button" type="submit">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <!-- 体重情報 -->
        <div class="weight-summary">
            <p>目標体重：{{ $target->target_weight ?? '未設定' }}kg</p>
            <p>目標まで：-{{ isset($diff) ? number_format($diff, 1) . 'kg' : '---' }}</p>
            <p>現在体重：{{ $currentWeight->weight ?? '記録なし' }}kg</p>
        </div>

        <div class="log-list">
            <!-- 検索フォーム -->
            <form method="GET" action="{{ route('weight_logs.search') }}" class="search-form">
                <input type="date" name="start_date" value="{{ request('start_date') }}">
                <p>〜</p>
                <input type="date" name="end_date" value="{{ request('end_date') }}">

                <button type="submit" class="search-button">検索</button>

                <!-- 検索条件と件数 -->
                @if(request('start_date') || request('end_date'))
                <p class="search-result">
                    {{ request('start_date') }} ～ {{ request('end_date') }} の検索結果 {{ $weightLogs->total() }}件
                </p>
                @endif

                @if(request('start_date') || request('end_date'))
                <a class="reset-button" href="{{ route('weight_logs.index') }}">リセット</a>
                @endif
            </form>

            <!-- 一覧 -->
            @foreach($weightLogs as $log)
            <div class="list-item">
                <p>日付：{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</p>
                <p>体重：{{ number_format($log->weight, 1) }}kg</p>
                <p>食事摂取カロリー：{{ $log->calories ?? '---' }}kcal</p>
                <p>運動時間：
                    @if($log->exercise_time)
                    {{ sprintf('%02d:%02d', floor($log->exercise_time / 60), $log->exercise_time % 60) }}
                    @else
                    ---
                    @endif
                    <a href="{{ route('weight_logs.edit', ['weightLog' => $log->id]) }}">
                        <img class="icon-pencil" src="{{ asset('storage/images/pencil-icon.png') }}" alt="編集">
                    </a>
            </div>
            @endforeach
        </div>
        <!-- ページネーション -->
        <div class="pagination">
            {{ $weightLogs->appends(request()->query())->links() }}
        </div>
    </main>
    <!-- 登録完了メッセージ -->
    @if(session('success'))
    <p class="success-message">{{ session('success') }}</p>
    @endif

    <!-- モーダルを維持 -->
    <input type="checkbox" id="modal-toggle" class="modal-checkbox" hidden
        {{ count($errors) > 0 ? 'checked' : '' }}>

    <!-- データを追加ボタン -->
    <label class="add-button" for="modal-toggle">データを追加</label>

    <!-- モーダル開閉チェックボックス -->
    <input class="modal-checkbox" type="checkbox" id="modal-toggle" hidden>

    <!-- モーダルウィンドウ本体 -->
    <div class="modal">
        <div class="modal-content">

            <!-- 登録フォーム -->
            <form action="{{ route('weight_logs.store') }}" method="POST" novalidate>
                @csrf
                <label>日付
                    <span class="label-required">必須</span>
                </label>
                <input type="date" name="date" value="{{ old('date') }}" placeholder="年/月/日">
                @error('date')
                <p class="error">{{ $message }}</p>
                @enderror

                <label>体重
                    <span class="label-required">必須</span>
                </label>
                <input type="text" name="weight" value="{{ old('weight') }}" placeholder="50.0">
                <p>kg</p>
                @error('weight')
                <p class="error">{{ $message }}</p>
                @enderror

                <label>摂取カロリー
                    <span class="label-required">必須</span>
                </label>
                <input type="text" name="calories" value="{{ old('calories') }}" placeholder="1200">
                <p>kcal</p>
                @error('calories')
                <p class="error">{{ $message }}</p>
                @enderror

                <label>運動時間
                    <span class="label-required">必須</span>
                </label>
                <input type="time" name="exercise_time" value="{{ old('exercise_time') }}" placeholder="00:00">
                @error('exercise_time')
                <p class="error">{{ $message }}</p>
                @enderror

                <label>運動内容
                    <span class="label-required">必須</span>
                </label>
                <input type="text" name="exercise_content" value="{{ old('exercise_content') }}" placeholder="運動内容を追加">
                @error('exercise_content')
                <p class="error">{{ $message }}</p>
                @enderror

                <a class="back-button" href="{{ route('weight_logs.index') }}">戻る</a>
                <button class="submit-button" type="submit">登録</button>
            </form>
        </div>
    </div>
</body>

</html>