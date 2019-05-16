<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Contract extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $guarded = ['id'];

    protected $with = ['invoices','media'];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            Artisan::call('check:contracts');
        });

        self::updated(function($model){
            Artisan::call('check:contracts');
        });

        self::deleted(function($model){
            Artisan::call('check:contracts');
        });
    }

    public function invoices()
    {
        return $this->hasMany( Invoice::class );
    }

    public function invoice()
    {
        return $this->hasMany( Invoice::class )->where('id', '=', request('invoice_id'))->first();
    }

    public function objs()
    {
        return $this->belongsToMany( Obj::class );
    }

    public function getValidityExtendTillValueAttribute($value)
    {
        if ( !empty($value) && empty($this->validity_extended) ) {
            return $value . ' (neaktyvi)';
        }

        return $value;
    }

    public function getContractStatusAttribute($value)
    {
        $label = $value;

        switch ($value)
        {
            case 'sustabdyta':
                $label = 'Sustabdyta';
                break;
            case 'ivykdyta':
                $label = 'Įvykdyta';
                break;
        }

        return ( $this->validity == 'unlimited' ? 'Neterminuota' : ucfirst($label) );
    }

    public function getValidityValueAttribute($value)
    {
        return ( $this->validity == 'unlimited' ? '-' : $value );
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
}
