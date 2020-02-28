<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DbInternal extends Model
{
    protected $table="db_d_internal_detail";
    protected $primaryKey="ID";

    const CREATED_AT ="INSERT_DATE";
    const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    protected $dates = ['DELETED_AT'];

    protected $fillable = [
        'insert_user',
        'update_user'
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
