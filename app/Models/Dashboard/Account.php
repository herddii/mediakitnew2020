<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Account extends Model
{
    use SoftDeletes;

    protected $table="db_d_target_account";
    protected $primaryKey="id_targetaccount";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    //protected $dates = ['DELETED_AT'];
    protected $fillable = [
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

    public function sam(){
        return $this->belongsTo('App\Models\Sam\Sam','pic_am');
    }

    public function am(){
        return $this->hasOne('App\Models\Dashboard\Accountam','id_targetaccount')
            ->where('id_bu',\Auth::user()->ID_BU)
            ->select(['id_targetaccount_am','id_targetaccount','id_am_run','ntc','id_bu']);
    }

    public function accountam(){
        return $this->hasOne('App\Models\Dashboard\Accountam','id_targetaccount')
            ->where('id_bu',\Auth::user()->ID_BU)
            ->select(['id_targetaccount_am','id_targetaccount','id_am_run','id_bu']);
    }

    public function produk(){
        return $this->belongsTo('App\Models\Dashboard\Produk','id_produk')
            ->select(['id_produk','nama_produk','id_category','id_sector','id_brand','id_adv']);
    }

    public function agencypintu(){
        return $this->belongsTo('App\Models\Dashboard\Agencypintu','id_agcyptu')
            ->select(['id_agcyptu','nama_agencypintu','id_agcy']);
    }

    public function agencypinturun(){
        return $this->belongsTo('App\Models\Dashboard\Agencypintu','id_agcyptu_run')
            ->select(['id_agcyptu','nama_agencypintu','id_agcy']);
    }
}
