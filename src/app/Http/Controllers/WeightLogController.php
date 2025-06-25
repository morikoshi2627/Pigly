<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InitialWeightRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;

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
            $diff = $currentWeight->weight - $target->target_weight;
        }

        // ページネーションで8件ずつ取得
        $weightLogs = WeightLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(8);

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
}