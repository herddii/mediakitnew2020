<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Produk extends Model
{
    protected $connection="mysql";
    protected $table="db_m_product";
    protected $primaryKey="id_produk";

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
        'idcategory'=>'required',
        'idsector'=>'required',
        'idbrand'=>'required',
        'idadvertiser'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idcategory.required'=>'please choose category',
        'idsector.required'=>'please choose sector',
        'idbrand.required'=>'please choose brand',
        'idadvertiser.required'=>'please choose advertiser',
    ];
    
    function category(){
        return $this->belongsTo('App\Models\Dashboard\Category','id_category')
            ->select(['id_category','name_category']);
    }
    function ta(){
        return $this->belongsTo('App\Models\Dashboard\Targetaudience','id_ta')
            ->select(['ID_TA','TA_NAME']);
    }
    function sector(){
        return $this->belongsTo('App\Models\Dashboard\Sector','id_sector')
            ->select(['id_sector','name_sector']);
    }
    function brand(){
        return $this->belongsTo('App\Models\Dashboard\Brand','id_brand');
    }
    function advertiser(){
        return $this->belongsTo('App\Models\Dashboard\Advertiser','id_adv');
    }
    function aprun(){
        return $this->hasOne('App\Models\Dashboard\Aprun','id_produk');
    }

    function account(){
        return $this->hasOne('App\Models\Dashboard\Account','id_produk')
            ->select(['id_targetaccount','id_produk','id_agcyptu','id_agcyptu_run']);
    }
}
