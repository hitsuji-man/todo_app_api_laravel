<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TODOテーブルのカラムを定義します
     * id: 自動採番のID
     * title: TODOのタイトル
     * description: TODOの詳細説明
     * prioriry: 優先度(低:1, 中:2, 高:3)
     * due_date: 期限日
     * completed: 完了フラグ
     * timestamps: 作成日時と更新日時
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('priority')->default(2);
            $table->date('due_date');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
