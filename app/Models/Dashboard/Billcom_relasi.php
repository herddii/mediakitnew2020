<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class Billcom_relasi extends Model
{
    protected $table="billcom_relasi";
    protected $primaryKey="id_billcom_relasi";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";

    // function billcom_target(){
    // 	return $this->belongsTo('App\Models\Dashboard\Billcom_target','id_billcom_target','id_billcom_target')->select('*');
    // }
   function billcom_detail(){
   	return $this->hasMany('App\Models\Dashboard\Billcom_detail','id_billcom_relasi','id_billcom_relasi')->select('*');
   }

   function db_m_agency(){
    	return $this->belongsTo('App\Models\Dashboard\Agency','id_agency','id_agcy')->select(['id_agcy','name_agency']);
    }
    function db_m_advertiser(){
    	return $this->hasMany('App\Models\Dashboard\Advertiser','id_adv','id_adv')->select(['id_adv', 'nama_adv']);
    }
}