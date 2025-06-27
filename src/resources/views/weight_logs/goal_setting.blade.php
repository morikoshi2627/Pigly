<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGly - 目標体重変更画面</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />

</head>

<body>

  <header class="header">
    <div class="header-inner">
      <nav class="nav-bar">
        <div class="logo">PiGly</div>
        <ul class="nav-links">
            <!-- <li>
                <a class="target-edit" href="{{ route('weight_logs.goal_setting') }}">目標体重設定 
                </a>
            </li> -->
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

  <main class="goal-setting">
    <div class="goal-setting-inner">
      <h2>目標体重の設定</h2>

      <form method="POST" action="{{ route('weight_logs.goal_setting.update') }}">
        @csrf
        <div class="form-group">
          <label for="target_weight">目標体重（kg）</label>
          <input type="text" id="target_weight" name="target_weight" value="{{ old('target_weight', $target->target_weight ?? '') }}">
        </div>

        <div class="form-actions">
          <button type="submit">更新する</button>
          <a href="{{ route('weight_logs.index') }}">戻る
          </a>
        </div>
      </form>
    </div>
  </main>
</body>

</html>