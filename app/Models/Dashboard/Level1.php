<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Level1 extends Model
{
    protected $connection="mysql";
    protected $table="db_m_proglevel1";
    protected $primaryKey="id_level1";

    use SoftDeletes;
    protected $dates = ['deleted_at'];
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

    function level2(){
        return $this->hasOne('App\Models\Dashboard\Level1','id_level1');
    }
    function programariana(){
        return $this->hasOne('App\Models\Dashboard\Programariana','id_level1');
    }
    function banner(){
        return $this->hasOne('App\Models\Dashboard\Banner','id_level1');
    }
}
