<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Targetaudience extends Model
{
    protected $table="tbl_target_audience";
    protected $primaryKey="ID_TA";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    //use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'TA_NAME'=>'required',
        'TA'=>'required',
    ];

    public static $pesan=[
        'TA_NAME.required'=>'please fill name',
        'TA.required'=>'please select Type',
    ];


    
}
