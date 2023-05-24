<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

	protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserScope);
    }
}
