<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParamGroup extends Model
{
    protected $guarded = ['id'];

    protected $with = ['taskparams'];

    public function taskparams()
    {
        return $this->belongsToMany( TaskParam::class );
    }
}
