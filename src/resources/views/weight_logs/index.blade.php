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
      PiGly
    </div>
  </header>

  <main class="wight-logs-content">

    <div class="wight-logs-inner">
      <div class="header-buttons">
        <a class=" target-edit-button" href="{{ route('weight_logs.goal_setting') }}">目標体重を変更</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="logout-button" type="submit">ログアウト</button>
        </form>

        <!-- 体重情報 -->
        <div class="weight-summary">
          <p>目標体重：{{ $target->target_weight ?? '未設定' }}kg</p>
          <p>現在体重：{{ $currentWeight->weight ?? '記録なし' }}kg</p>
          <p>差分：{{ isset($diff) ? number_format($diff, 1) . 'kg' : '---' }}</p>
        </div>

        <!-- 一覧 -->
        <div class="log-list">
          @foreach($weightLogs as $log)
          <div class="log-item">
            <p>日付：{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</p>
            <p>体重：{{ number_format($log->weight, 1) }}kg</p>
            <p>カロリー：{{ $log->calories ?? '---' }}kcal</p>
            <p>運動時間：
              @if($log->exercise_time)
              {{ floor($log->exercise_time / 60) }}時間{{ $log->exercise_time % 60 }}分
              @else
              ---
              @endif
              <img class="icon-pencil" src="{{ asset('storage/images/定番ペンのフリーアイコン素材 1.png') }}" alt="編集">
          </div>
          @endforeach
        </div>

        <!-- ページネーション -->
        <div class="pagination">
          {{ $weightLogs->links() }}
        </div>
      </div>



      <button class="btn btn-add-log">データを追加</button>

    </div>
  </main>
</body>

</html>


<!-- <p>運動内容：{{ $log->exercise_content ?? '---' }}</p> -->
<!-- <a href="{{ route('weight_logs.update', $log->id) }}" class="btn-edit"> -->