<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Obj extends Model implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;

    protected $guarded = ['id','media'];

    protected $with = ['researchAreas','region','contract'];

    public function researchAreas()
    {
        return $this->belongsToMany( ResearchArea::class )->withPivot('user_id');
    }

    public function contract()
    {
        return $this->belongsToMany( Contract::class );
    }

    public function region()
    {
        return $this->belongsTo( Region::class );
    }
}
