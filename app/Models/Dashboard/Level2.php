<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Level2 extends Model
{
    protected $connection="mysql";
    protected $table="db_m_proglevel2";
    protected $primaryKey="id_level2";

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
        return $this->belongsTo('App\Models\Dashboard\Level1','id_level1');
    }
    function programariana(){
        return $this->hasOne('App\Models\Dashboard\Programariana','id_level2');
    }
    function programgen(){
        return $this->hasOne('App\Models\Dashboard\Programgen','id_level2');
    }
}
