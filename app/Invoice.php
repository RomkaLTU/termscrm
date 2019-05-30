<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Artisan;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'contract_invoices';

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

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
