<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Contract extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    protected $with = ['researchAreas','invoices','media'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class );
    }

    public function invoices()
    {
        return $this->hasMany( Invoice::class );
    }

    public function invoice()
    {
        return $this->hasMany( Invoice::class )->where('id', '=', request('invoice_id'))->first();
    }
}
