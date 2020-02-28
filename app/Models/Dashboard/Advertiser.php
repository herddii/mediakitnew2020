<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertiser extends Model
{
    protected $table="db_m_advertiser";
    protected $primaryKey="id_adv";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
    protected $fillable = [
        'insert_user',
        'update_user'
    ];

    public $timestamps = false;
    public static $rules=[
        'name'=>'required',
        'idtype'=>'required',
        'isgroup'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idtype.required'=>'please choose type advertiser',
        'isgroup.required'=>'please choose is group',
    ];

    function sam(){
        return $this->hasOne('App\Models\Sam\Sam','id_advg');
    }
    
    function produk(){
        return $this->hasOne('App\Models\Dashboard\Produk','id_produk');
    }

    function advertisertype(){
        return $this->belongsTo('App\Models\Dashboard\Advertisertype','id_typeadv');
    }

    function city(){
        return $this->belongsTo('App\Models\Cam\City','id_city');
    }
}
