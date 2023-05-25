<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
	protected $todoListService;
    public function __construct(TodoListService $todoListService)
	{
		$this->todoListService = $todoListService;
	}

	public function index()
	{
		return $this->todoListService->index();
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name'=> 'required|string'
		]);

		$this->todoListService->store($request);
	}

	public function Update(Request $request)
	{
		$this->validate($request, [
			'name'=> 'required|string'
		]);

		$this->todoListService->Update($request);
	}

	public function edit($id)
	{
		return response()->json($this->todoListService->edit($id));
	}

	public function changeStatus(Request $request)
	{
		$this->todoListService->changeStatus($request->id);
		return response('Delete Successful..!', 200);
	}
    
	public function delete(Request $request)
	{
		$this->todoListService->delete($request->id);
		return response('Delete Successful..!', 200);
	}
}
