<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResearchArea extends Model
{
    protected $guarded = ['id'];

    public function contracts()
    {
        return $this->belongsToMany( Contract::class );
    }
}
