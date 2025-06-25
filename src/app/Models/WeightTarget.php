<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightTarget extends Model
{
    use HasFactory;
    
    //　テーブル名は単数形で（テスト要件に沿い） 
    protected $table = 'weight_target';

    protected $fillable = ['user_id', 'target_weight'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
