<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertisertype extends Model
{
    protected $table="db_m_advertiser_type";
    protected $primaryKey="id_advtype";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
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

    
    function advertiser(){
        return $this->hasOne('App\Models\Dashboard\Advertiser','ID_TYPEADV');
    }
}
