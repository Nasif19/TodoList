<?php
namespace App\Services;

use App\Contracts\TodoList as ContractsTodoList;
use App\Models\TodoList;

class TodoListService implements ContractsTodoList {
    protected $todoList;
    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function index(object $requestParams) {
        return $this->todoList::with('tasks')->where('user_id', auth()->id)->get();
    }

    public function creatAndUpdate(object $requestParams) {
        if ($requestParams->id) {
            $todo = $this->todoList::find($requestParams->id);
        } else {
            $todo = new $this->todoList();
            $todo->user_id = auth()->id();
        }

        $todo->save();

        if ($requestParams->tasks) {

        }
    }

    public function storeAndUpdateTasks()
    {
        
    }

    public function edit(int $id) {

    }

    public function delete(int $id) {

    }

}