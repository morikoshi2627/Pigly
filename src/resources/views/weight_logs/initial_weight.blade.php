<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGly - 初期体重登録</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/initial_weight.css') }}" />

</head>

<body>
    
  <header class="header">
        <div class="header-inner">
            PiGly
        </div>
    </header>

    <main class="initial-weight-content">
        
      <div class="initial-weight-inner">

            <!-- タイトル -->
            <h2 class="initial-weight-title">新規会員登録</h2>
            <p class="initial-weight-title-sub">STEP2 体重データの入力</p>

            <!-- 登録フォーム  -->
            <form class="initial-weight-form" action="{{ route('register.step2') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label" for="weight">現在の体重</label>
                    <input class="form-input" type="number" name="weight" id="weight" step="0.1" value="{{ old('weight') }}" required>
                    <p>kg</p>
                    @error('weight')
                    <div class="form__error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="target_weight">目標の体重</label>
                    <input class="form-input" type="number" name="target_weight" id="target_weight" step="0.1" value="{{ old('target_weight') }}" required>
                    <p>kg</p>
                    @error('target_weight')
                    <div class="form__error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="form-submit" type="submit">アカウント作成</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>