<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Model
{
    protected $table="db_m_progbanner";
    //protected $primaryKey="ID_PROGBANNER";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idlevel1'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idlevel1.required'=>'please choose level1',
    ];

    function level1(){
        return $this->belongsTo('App\Models\Dashboard\Level1','id_level1')
            ->select(['id_level1','name_level1']);
    }
}
