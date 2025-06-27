<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGly - 情報更新画面</title>
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

    <main class="show-edit">
        <div class="show-edit-inner">
            <h2>Weight Log</h2>

            <form action="{{ route('weight_logs.update', ['weightLog' => $weightLog->id]) }}" method="POST">
                @csrf

                <!-- 日付（カレンダー、当日デフォルト） -->
                <label for="date">日付</label>
                <input type="date" name="date" value="{{ old('date', $weightLog->date) }}">
                @error('date')
                <div class="form__error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 体重（数値） -->
                <label for="weight">体重</label>
                <input type="number" step="0.1" name="weight" value="{{ old('weight',  $weightLog->weight) }}">
                <p>kg</p>
                @error('weight')
                <div class="form__error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 摂取カロリー -->
                <label for="weight">摂取カロリー</label>
                <input type="text" name="calories" value="{{ old('calories', $weightLog->calories) }}">
                <p>kcal</p>
                @error('calories')
                <div class="form__error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 運動時間（00:00形式） -->
                <label for="exercise_time">運動時間</label>
                <input type="time" name="exercise_time" value="{{ old('exercise_time', sprintf('%02d:%02d', floor($weightLog->exercise_time / 60), $weightLog->exercise_time % 60)) }}">
                @error('exercise_time')
                <div class="form__error">
                    {{ $message }}
                </div>
                @enderror

                <!-- 運動内容 -->
                <label for="exercise_content">運動内容</label>
                <input type="text" name="exercise_content" value="{{ old('exercise_content', $weightLog->exercise_content) }}">
                @error('exercise_content')
                <div class="form__error">
                    {{ $message }}
                </div>
                @enderror

                <div class="form-actions">
                    <button type="submit">更新する</button>
                    <a class="back-button" href="{{ route('weight_logs.index') }}">戻る
                    </a>
                </div>
            </form>

            <!-- 削除処理 -->
            <form method="POST" action="{{ route('weight_logs.delete', ['weightLog' => $weightLog->id]) }}" style="display: inline;" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                    <img src="{{ asset('storage/images/trash-icon.png') }}" alt="削除" style="width: 32px; height: 32px;">
                </button>
            </form>

        </div>
    </main>
</body>

</html>