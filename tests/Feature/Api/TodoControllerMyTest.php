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
        $this->artisan('migrate:fresh');
        // モデルの中を綺麗にする。use RefreshDatabaseを使用しない時の対応策
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
            'title' => '新規作成のテストですか？',
            'content' => '新規作成のテストです'
        ];

        // $res＝response
        // 実行 $paramsをJson形式でrouteに渡す
        $res = $this->postJson(route('api.todo.create'), $params);
        // 検証 送信ができたか
        $res->assertOk();

        // Todoモデルから全件取得。1件だけになっているか
        $todos = Todo::all();
        $this->assertCount(1, $todos);
        // $this->assertCount(1, $todos);で配列の数をカウント。

        $todo = $todos->first();
        // first()＝最初のモデルを取得するためのメソッド
        // DBはDatabaseTransactionsのおかげでテスト終了時にロールバックをされている（きれいに）ので、$todosには、$paramsだけが残っている＝最初のモデルは$params
        // 取得した内容が$paramsと一致しているか
        $this->assertEquals($params['title'], $todo->title);
        $this->assertEquals($params['content'], $todo->content);
    }
}
