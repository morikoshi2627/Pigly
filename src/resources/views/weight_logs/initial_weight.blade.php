@extends('layouts.base')

@section('css')
<link rel="stylesheet" href="{{ asset('css/initial_weight.css') }}" />
@endsection

@section('body')
<div class="pigly-whole">
    <div class="pigly-inner">
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
                    <div class="input-area">
                        <div class="form-group">
                            <label class="form-label" for="weight">現在の体重</label>
                            <div class="input-with-unit">
                                <input class="form-input" type="number" name="weight" id="weight" step="0.1" value="{{ old('weight') }}" placeholder="現在の体重を入力" required>
                                <p class="unit">kg</p>
                            </div>

                            @error('weight')
                            <div class="form__error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="target_weight">目標の体重</label>
                            <div class="input-with-unit">
                                <input class="form-input" type="number" name="target_weight" id="target_weight" step="0.1" value="{{ old('target_weight') }}" placeholder="目標の体重を入力" required>
                                <p class="unit">kg</p>
                            </div>
                            @error('target_weight')
                            <div class="form__error">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="form-submit" type="submit">アカウント作成</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection