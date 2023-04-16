<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TodoControllerMyTest extends Controller
{
    private Todo $todo;
    // Todoクラスのオブジェクトしか代入できないようにする。コードの可読性と型不一致によるエラーを防止

    // __constructで初期化処理
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
        // $todoに$this->todoを代入
    }

    /**
     * Store anewly created resource in storage
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * 
     * store()でRequestの$requestからHTTPリクエストに含まれた情報を取得する。今回であれば、testControllerの$paramsを取得して、validationをかけていく
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->fill($validated)->save();

        return ['message' => '失敗してください'];
    }
}
