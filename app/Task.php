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

    public function author()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'task_user')->orderBy('created_at', 'desc')
            ->withPivot('task_id', 'user_id', 'status')->withTimestamps()
            ->as('meta');
    }
}
