<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Billcom_detail extends Model
{
    protected $table="billcom_detail";
    protected $primaryKey="id_billcom_detail";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";

    function billcom_relasi(){
    	return $this->belongsTo('App\Models\Dashboard\Billcom_relasi','id_billcom_relasi','id_billcom_relasi')->select('*');
    }
    function billcom_type(){
    	return $this->hasOne('App\Models\Dashboard\Billcom_type','id_billcom_type','id_billcom_type')->select(['id_billcom_type','billcom_type']);
    }
}