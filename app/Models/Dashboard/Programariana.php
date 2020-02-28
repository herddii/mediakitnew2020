<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Programariana extends Model
{
    protected $connection="mysql";
    protected $table="program_ariana";
    protected $primaryKey="id_program_ariana";

    // const CREATED_AT ="INSERT_DATE";
    // const UPDATED_AT ="UPDATE_DATE";
    // use SoftDeletes;
    // protected $dates = ['DELETED_AT'];
    // protected $fillable = [
    //     'insert_user',
    //     'update_user'
    // ];
    public static $rules=[
        'name'=>'required',
        'idlevel1'=>'required',
        'idlevel2'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idlevel1.required'=>'please choose level1',
        'idlevel2.required'=>'please choose level2',
    ];

    function level1(){
        return $this->belongsTo('App\Models\Dashboard\Level1','ID_LEVEL1');
    }
    function level2(){
        return $this->belongsTo('App\Models\Dashboard\Level2','ID_LEVEL2');
    }
}
