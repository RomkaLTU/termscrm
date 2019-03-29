<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $guarded = ['id'];

    protected $with = ['researchAreas','invoices'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class );
    }

    public function invoices() {
        return $this->hasMany( Invoice::class );
    }
}
