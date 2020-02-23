<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    //
    public function scopePersonal($query)
    {
        $query->where('user_id', Auth::id());
    }
}
