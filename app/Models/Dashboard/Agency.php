<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agency extends Model
{
    protected $table="db_m_agency";
    protected $primaryKey="id_agcy";

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
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
    ];

    function agencypintu(){
        return $this->hasOne('App\Models\Dashboard\Agencypintu','id_agcy')->select(['id_agcy','id_agcyptu','nama_agencypintu']);
    }

    function city(){
        return $this->belongsTo('App\Models\Cam\City','id_city');
    }
}
