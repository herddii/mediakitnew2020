<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Billcom_target extends Model
{
    protected $table="billcom_target";
    protected $primaryKey="id_billcom_target";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";

    function billcom_relasi(){
    	return $this->hasMany('App\Models\Dashboard\billcom_relasi','id_billcom_target','id_billcom_target')->select('*')->whereNull('deleted_at');
    }
    function billcom_header(){
    	return $this->hasMany('App\Models\Dashboard\billcom_header','id_billcom_header','id_billcom_header')->select('*');
    }
}