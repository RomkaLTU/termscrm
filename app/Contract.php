<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $guarded = ['id'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class );
    }
}