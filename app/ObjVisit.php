<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjVisit extends Model
{
    protected $guarded = ['id'];

    protected $with = ['contract','obj','user'];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id' );
    }

    public function obj()
    {
        return $this->belongsTo( Obj::class, 'object_id', 'id' );
    }

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }
}
