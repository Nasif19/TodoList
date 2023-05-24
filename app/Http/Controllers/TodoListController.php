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
		return response()->json($this->edit($id));
	}

	public function delete($id)
	{
		$this->delete($id);
		return response('Delete Successful..!', 200);
	}
}
