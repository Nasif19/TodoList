<?php
namespace App\Services;

use App\Contracts\TodoListContract;
use App\Models\TodoList;
use Illuminate\Support\Facades\DB;

class TodoListService implements TodoListContract {
    protected $todoList;
    public function __construct(TodoList $todoList)
    {
        $this->todoList = $todoList;
    }

    public function index() {
        return $this->todoList::with('tasks')->whereNull('parent_id')->orderBy('id', 'desc')->get();
    }

    public function store($requestParams) {
		try {
			DB::beginTransaction();
			$todo = new $this->todoList();
	
			$todo->name = $requestParams->name;
			$todo->parent_id = $requestParams->parent_id;
			$todo->user_id = auth()->id();
			$todo->save();

			DB::commit();

			return response('Save Successfully.!', 200);
		} catch (\Throwable $th) {
			DB::rollBack();
		}
    }

    public function Update($requestParams)
    {
		try {
			DB::beginTransaction();
			$todo = $this->todoList::find($requestParams->id);
			$todo->name = $requestParams->name;
			$todo->Update();

			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			
		}
    }

    public function edit($id) {
		return $this->todoList::find($id);
    }

    public function changeStatus($id)
    {
        $todo = $this->todoList::find($id);
        $todo->status = $todo->status==1?0:1;
        return $todo->update();
    }

    public function delete($id) {
        $todo = $this->todoList::find($id);
        if (!$todo->parent_id) $this->todoList::where('parent_id', $todo->id)->delete();
		return $todo->delete();
    }

}