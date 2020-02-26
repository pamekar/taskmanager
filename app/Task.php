<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'start_at', 'end_at'];

    public function scopePersonal($query)
    {
        $query->where('user_id', Auth::id());
    }
}
