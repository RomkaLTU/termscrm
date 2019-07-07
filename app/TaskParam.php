<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskParam extends Model
{
    protected $guarded = ['id'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class );
    }
}
