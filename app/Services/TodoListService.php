<?php
namespace App\Services;

use App\Contracts\TodoListContract;
use App\Models\TodoList;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class TodoListService implements TodoListContract {
    protected $model;
    public function __construct(TodoList $todoList)
    {
        $this->model = $todoList;
    }

    public function index() {
        return $this->model::with('tasks')->whereNull('parent_id')->orderBy('id', 'desc')->get();
    }

    public function store($requestParams) {
		try {
			DB::beginTransaction();
			$todo = new $this->model();
	
			$todo->name = $requestParams->name;
			$todo->parent_id = $requestParams->parent_id;
			$todo->user_id = auth()->id();
			$todo->save();

			DB::commit();

			return response('Save Successfully.!', 200);
		} catch (QueryException $exception) {
			DB::rollBack();
            throw new InvalidArgumentException($exception->getMessage());
		}
    }

    public function Update($requestParams)
    {
		try {
			DB::beginTransaction();
			$todo = $this->model::find($requestParams->id);
			$todo->name = $requestParams->name;
			$todo->Update();

			DB::commit();
		} catch (QueryException $exception) {
			DB::rollBack();
            throw new InvalidArgumentException($exception->getMessage());
		}
    }

    public function edit($id) {
		return $this->model::find($id);
    }

    public function changeStatus($id)
    {
        $todo = $this->model::find($id);
        $todo->status = $todo->status==1?0:1;
        return $todo->update();
    }

    public function delete($id) {
        $todo = $this->model::find($id);
        if (!$todo->parent_id) $this->model::where('parent_id', $todo->id)->delete();
		return $todo->delete();
    }

}