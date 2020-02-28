<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agencypintu extends Model
{
    protected $table="db_m_agencypintu";
    protected $primaryKey="id_agcyptu";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
    public $timestamps = false;
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idagency'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idagency.required'=>'please choose agency',
    ];

    function agency(){
        return $this->belongsTo('App\Models\Dashboard\Agency','id_agcy')
            ->select(['id_agcy','name_agency']);
    }

    function sam(){
        return $this->hasOne('App\Models\Sam\Sam','id_apu');
    }

    function agencypintu(){
        return $this->hasOne('App\Models\Dashboard\Aprun','id_agcyptu');
    }

    function agencypinturun(){
        return $this->hasOne('App\Models\Dashboard\Aprun','id_agcyptu_run');
    }

    function account(){
        return $this->hasOne('App\Models\Dashboard\Account','id_agcyptu_run');
    }

    public function cam(){
        return $this->hasOne('App\Models\Cam\Cam', 'id_cam');
    }

    function city(){
        return $this->belongsTo('App\Models\Cam\City','id_city');
    }
}
