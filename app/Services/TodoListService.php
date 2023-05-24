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
        return $this->todoList::all();
    }

    public function store($requestParams) {
		try {
			DB::beginTransaction();
			$todo = new $this->todoList();
	
			$todo->name = $requestParams->name;
			$todo->date = $requestParams->date?date('Y-m-d', strtotime($requestParams->date)):null;
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

    public function delete($id) {
		$this->todoList::find($id)->delete();
    }

}