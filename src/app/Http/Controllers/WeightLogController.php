<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InitialWeightRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreWeightLogRequest;
use App\Http\Requests\UpdateTargetRequest;
use App\Http\Requests\UpdateWeightLogRequest;


class WeightLogController extends Controller
{
    // 体重管理画面（一覧画面）
    public function index()
    {
        $user = Auth::user();

        // 目標体重の取得
        $target = WeightTarget::where('user_id', $user->id)->first();

        // 体重ログの取得（最新日付順で8件ずつページネート）
        $weightLogs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(8);

        // 最新の体重（1件目）を取得
        $currentWeight = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->first();

        // 目標体重との差を計算（nullチェック付き）
        $diff = null;
        if ($target && $currentWeight) {
            $diff = $target->target_weight - $currentWeight->weight;
        }

        return view('weight_logs.index', compact('target', 'currentWeight', 'diff', 'weightLogs'));
    }

    // 登録後に初期体重登録画面
    public function createInitial()
    {
        return view('weight_logs.initial_weight');
    }

    // フォームリクエスト使用
    public function storeInitial(InitialWeightRequest $request)
    {
        $user = Auth::user();

        // 現在の体重を weight_logs に保存
        WeightLog::create([
            'user_id' => $user->id,
            'weight' => $request->weight,
            'date' => now()->toDateString(),
        ]);

        // 目標体重を weight_target に保存
        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        return redirect()->route('weight_logs.index');
    }

    // 検索機能
    public function search(Request $request)
    {
        $user = Auth::user();

        $query = WeightLog::where('user_id', $user->id);

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $weightLogs = $query->orderBy('date', 'desc')->paginate(8);

        $target = WeightTarget::where('user_id', $user->id)->first();
        $currentWeight = WeightLog::where('user_id', $user->id)->orderBy('date', 'desc')->first();
        $diff = ($target && $currentWeight) ? $target->target_weight - $currentWeight->weight : null;

        return view('weight_logs.index', compact('weightLogs', 'target', 'currentWeight', 'diff'));
    }

    // モーダルウィンドウ（登録機能画面）
    public function store(StoreWeightLogRequest $request)
    {
        // 入力された時間（例: "01:30"）を分に変換
        $exerciseTime = $this->convertTimeToMinutes($request->exercise_time);

         WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $exerciseTime,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()->route('weight_logs.index');
    }

    // "HH:MM"形式の時間を「分」に変換
    private function convertTimeToMinutes(?string $time): ?int
    {
        if (!$time) return null;

        [$hours, $minutes] = explode(':', $time);
        return ((int)$hours * 60) + (int)$minutes;
    }


    // 目標体重変更画面
    public function editTarget()
    {
        $user = Auth::user();
        $target = WeightTarget::where('user_id', $user->id)->first();

        return view('weight_logs.goal_setting', compact('target'));
    }

    // 目標体重の更新処理
    public function updateTarget(UpdateTargetRequest $request)
    {
        $user = Auth::user();

        WeightTarget::updateOrCreate(
            ['user_id' => $user->id],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight_logs.index');
    }

    // 情報更新画面
    public function show(WeightLog $weightLog)
    {
        return view('weight_logs.show', compact('weightLog'));
    }

    public function edit(WeightLog $weightLog)
    {
        return view('weight_logs.edit', compact('weightLog'));
    }

    public function update(UpdateWeightLogRequest $request, WeightLog $weightLog)
    {
        // 入力された時間（例: "01:30"）を分に変換
        $exerciseTime = $this->convertTimeToMinutes($request->exercise_time);

        // データの更新
        $weightLog->update([
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' =>  $exerciseTime,
            'exercise_content' => $request->exercise_content,
        ]);

        // 一覧画面へリダイレクト
        return redirect()->route('weight_logs.index');
    }

    // 削除処理
    public function destroy(WeightLog $weightLog)
    {
        $weightLog->delete();
        return redirect()->route('weight_logs.index');
    }

}