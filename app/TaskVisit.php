<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskVisit extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function task()
    {
        return $this->belongsTo( ObjTask::class, 'task_id', 'id' );
    }

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id',  'id' );
    }
}
