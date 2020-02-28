<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class KlienHandling extends Model
{
    protected $table="db_m_advertiser";
    protected $primaryKey="ID_ADV";

    const CREATED_AT ="INSERT_DATE";
    const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    protected $dates = ['DELETED_AT'];
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
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
        return $this->hasOne('App\Models\Sam\Sam','ID_ADVG');
    }
    
    function produk(){
        return $this->hasOne('App\Models\Dashboard\Produk','ID_PRODUK');
    }

    function advertisertype(){
        return $this->belongsTo('App\Models\Dashboard\Advertisertype','ID_ADVTYPE');
    }
}
