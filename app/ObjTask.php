<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjTask extends Model
{
    protected $guarded = ['id'];

    protected $with = ['contract','obj','researchArea','visits'];

    public function contract()
    {
        return $this->belongsTo( Contract::class );
    }

    public function researchArea()
    {
        return $this->belongsTo( ResearchArea::class );
    }

    public function obj()
    {
        return $this->belongsTo( Obj::class, 'object_id' );
    }

    public function taskParams()
    {
        return $this->belongsToMany( TaskParam::class );
    }

    public function paramGroups()
    {
        return $this->belongsToMany( ParamGroup::class );
    }

    public function visits()
    {
        return $this->hasMany( TaskVisit::class, 'task_id' );
    }
}
