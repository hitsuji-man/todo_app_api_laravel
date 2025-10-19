<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Todoモデルの定義
 * Todosテーブルとのやりとりを管理するモデルクラスです
 */
class Todo extends Model
{
    use HasFactory;

    /**
     * 一括代入可能なカラムを指定
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'due_date',
        'completed'
    ];

    /**
     * 属性のデータ型をキャスト
     */
    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
        'priority' => 'integer',
    ];

    /**
     * 優先度のラベルを取得
     */
    public function priorityLabel() {
        return match($this->priority) {
            1 => '低',
            2 => '中',
            3 => '高',
            default => '未設定',
        };
    }

    /**
     * 期限切れかどうかを判定
     */
    public function isOverdue() {
        if (!$this->due_date || $this->completed) {
            return false;
        }
        return Carbon::parse($this->due_date)->isPast();
    }
}
