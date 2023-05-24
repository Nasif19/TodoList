<?php
namespace App\Contracts;

interface TodoList {
    public function index(object $requestParams);
    public function creatAndUpdate(object $requestParams);
    public function edit(int $id);
    public function delete(int $id);
}