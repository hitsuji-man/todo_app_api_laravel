<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Todo APIコントローラー
 * TODOリストのREST API操作を管理するコントローラー
 */
class TodoController extends Controller
{
    /**
     * TODOの一覧を取得
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        // クエリパラメータによるフィルタリング
        $query = Todo::query();

        // 完了状態でフィルタリング
        if ($request->has('completed')) {
            $query->where('completed', $request->boolean('completed'));
        }

        // 優先度でフィルタリング
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // 並び順の設定
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        // 有効なソートフィールドのみ許可
        $allowedSortFields = ['title', 'priority', 'due_date', 'created_at', 'updated_at'];
        if (in_array($sortField, $allowedSortFields, true)) {
            $query->orderBy($sortField, $sortDirection);
        }

        // データの取得と変換
        $todos = $query->get();

        return TodoResource::collection($todos);
    }

    /**
     * 新しいTODOを作成
     *
     * @param Request $request
     * @return TodoResource
     */
    public function store(Request $request)
    {
        // dd($request->all());
        dd('store reached');

        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|integer|min:1|max:3',
            'due_date' => 'nullable|date',
            'completed' => 'nullable|boolean',
        ]);

        // due_dateをCarbonに変換（nullチェック付き）
        if (!empty($validated['due_date'])) {
            $validated['due_date'] = Carbon::parse($validated['due_date']);
        }

        // completed デフォルト false
        if (!isset($validated['completed'])) {
            $validated['completed'] = false;
        }

        // TODOの作成
        $todo = Todo::create($validated);

        return new TodoResource($todo);
    }

    /**
     * 指定されたTODOの詳細を取得
     *
     * @param Todo $todo
     * @return TodoResource
     */
    public function show(Todo $todo)
    {
        return new TodoResource($todo);
    }

    /**
     * 指定されたTODOを更新
     *
     * @param Request $request
     * @param Todo $todo
     */
    public function update(Request $request, Todo $todo)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|nullable|integer|min:1|max:3',
            'due_date' => 'nullable|date',
            'completed' => 'sometimes|boolean',
        ]);

        // TODOの更新
        $todo->update($validated);

        return new TodoResource($todo);
    }

    /**
     * 指定されたTODOを削除
     *
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully'], 200);
    }

    /**
     * 完了状態を切り替える
     *
     * @param Todo $todo
     * @return TodoResource
     */
    public function toggleComplete(Todo $todo) {
        $todo->completed = !$todo->completed;
        $todo->save();

        return new TodoResource($todo);
    }
}
