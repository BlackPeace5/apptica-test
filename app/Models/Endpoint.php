<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $connection = "pgsql";

    protected $table = "endpoints";

    protected $fillable = [
        "application_id",
        "country_id",
        "data",
    ];

    protected $hidden = [
        "id",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        "data"=> "json",
        "application_id"=>'integer',
        'country_id'=>'integer',
        'created_at'=>'datetime',
        'updated_at'=> 'datetime'
    ];

    public function getDataAttribute($value) {
        return collect(json_decode($value, true))->mapWithKeys(function ($items, $key) {
            return [$key => collect($items)->flatten()->min()];
        });
    }

}
