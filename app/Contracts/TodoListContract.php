<?php
namespace App\Contracts;

interface TodoListContract {
    public function index();
    public function store(object $requestParams);
    public function update(object $requestParams);
    public function edit(int $id);
    public function delete(int $id);
}