<?php

namespace App\Models\Dashboard\Kpi;

use Illuminate\Database\Eloquent\Model;

class Mentahgen extends Model
{
    protected $connection="mysql4";
    protected $table="mentah_gen";
    protected $guarded = [];

    public $timestamps=false;
}
