<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Todo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TodoControllerMyTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();
        // setUp()メソッドは、テストメソッドを実行する前に準備をするためのメソッド（変数の初期化等）
    }

    /**
     * @test
     * testアノテーションをつけて初めてテストとしてphpunitに認識される
     * function () ()の前にテスト内容を記載してわかりやすくすることもできる。書き方の一つ
     * 
     * POSTされる内容が不十分
     */
    public function TodoMy新規作成()
    {
        $params = [
            'title' => 'テスト：失敗させます',
            // 'content' => 'テストです'
        ];

        // $res＝response
        // 実行
        $res = $this->postJson(route('api.todo.create'), $params);
        // 検証
        $res->assertOk();
        $todos = Todo::all();

        $this->assertCount(1, $todos);
        // $this->assertCount(1, $todos);で配列の数をカウント。

        $todo = $todos->first();
        // first()＝最初のモデルを取得するためのメソッド
        // DBはDatabaseTransactionsのおかげでテスト終了時にロールバックをされている（きれいに）ので、$todosには、$paramsだけが残っている＝最初のモデルは$params

        $this->assertEquals($params['title'], $todo->title);
        // $this->assertEquals($params['content'], $todo->content);
    }
}
