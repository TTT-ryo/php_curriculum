<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

/**
 * TodoController class
 */

class TodoController extends Controller
{
    /**
     * @var Todo
     */
    private Todo $todo;

    /**
     * constructor function
     * @param Todo $todo
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $todos = $this->todo->all();
        $todos = $this->todo->orderby('updated_at', 'desc')->paginate(5);
        // return view('layouts.app');
        return view('todo.index', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     * create function
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     * store function
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);

        $this->todo->fill($validated)->save();

        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * edit function
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $todo = $this->todo->findOrFail($id);
        return view('todo.edit',['todo' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     * update function
     * @param Request $request
     * @param int $id
     * @param \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->findOrFail($id)->update($validated);
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     * destroy function
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->todo->findOrFail($id)->delete();
        return redirect()->route('todo.index');
    }
}
