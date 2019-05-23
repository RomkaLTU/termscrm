<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjTask extends Model
{
    protected $guarded = ['id'];

    public function taskParams()
    {
        return $this->belongsToMany( TaskParam::class );
    }

    public function paramGroups()
    {
        return $this->belongsToMany( ParamGroup::class );
    }
}
