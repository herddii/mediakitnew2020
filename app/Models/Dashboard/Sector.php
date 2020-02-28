<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sector extends Model
{
    protected $connection="mysql";
    protected $table="db_m_sector";
    protected $primaryKey="id_sector";

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
        'idcategory'=>'required',
        'idsector'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idcategory.required'=>'please choose category',
        'idsector.required'=>'please choose sector',
    ];

    function produk(){
        return $this->hasOne('App\Models\Dashboard\Produk','ID_SECTOR');
    }

    function brand(){
        return $this->hasOne('App\Models\Dashboard\Brand','ID_SECTOR');
    }
    
}