<?php

namespace App\Models\Dashboard\Kpi;

use Illuminate\Database\Eloquent\Model;

class Targetgen extends Model
{
    protected $connection="mysql4";
    protected $table="master_gen";
    protected $guarded = [];

    public $timestamps=false;

    public function am(){
        return $this->belongsTo('App\Models\User','id_am','USER_ID')
            ->select(
                [
                    'USER_ID',
                    'USER_NAME',
                    'POSITION',
                    'ID_BU',
                    'ID_SECTION',
                    'ID_DEPARTEMENT',
                    'IMAGES'
                ]
            );
    }
}
