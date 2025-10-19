<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * TodoリソースクラスはAPIレスポンスの形式を定義します
 */
class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * リソースを配列に変換
         *
         * @return array<string, mixed>
         */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => [
                'value' => $this->priority,
                'label' => $this->priorityLabel()
            ],
            'due_date' => $this->due_date ? $this->due_date->format('Y-m-d') : null,
            'completed' => $this->completed,
            'is_overdue' => $this->isOverdue(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
