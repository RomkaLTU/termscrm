<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Obj extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id','media'];

    protected $with = ['researchAreas'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class )->withPivot('user_id');
    }

    public function contract()
    {
        return $this->belongsToMany( Contract::class );
    }
}
