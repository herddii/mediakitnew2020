<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brand extends Model
{
    protected $table="db_m_brand";
    protected $primaryKey="id_brand";

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
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idcategory.required'=>'please choose category',
        'idsector.required'=>'please choose sector',
    ];


    function sam(){
        return $this->hasOne('App\Models\Sam\Sam','id_brand');
    }

    function produk(){
        return $this->hasOne('App\Models\Dashboard\Produk','id_brand')
            ->select(['id_produk','nama_produk','id_produk','id_sector','id_brand','id_adv','id_ta']);
    }

    function produks(){
        return $this->hasMany('App\Models\Dashboard\Produk','id_brand');
    }

    function category(){
        return $this->belongsTo('App\Models\Dashboard\Category','id_category')
            ->select(['id_category','name_category']);
    }
    
    function sector(){
        return $this->belongsTo('App\Models\Dashboard\Sector','id_sector')
            ->select(['id_sector','name_sector']);
    }
}
