<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Accountam extends Model
{
    protected $table="db_d_target_account_am";
    protected $primaryKey="id_targetaccount_am";

    //const CREATED_AT ="INSERT_DATE";
    //const UPDATED_AT ="UPDATE_DATE";
    use SoftDeletes;
    //protected $dates = ['DELETED_AT'];
    protected $fillable = [
        'insert_user',
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

    public function account(){
        return $this->belongsTo('App\Models\Dashboard\Account','id_targetaccount')
            ->select(['id_targetaccount','id_produk','id_agcyptu','id_agcyptu_run']);
    }
    public function user(){
        return $this->belongsTo('App\Models\User','id_am_run','user_id')
            ->select(['user_id','user_name','active']);
    }
    public function user2(){
        return $this->hasOne('App\Models\User','USER_ID','id_am_run')
            ->select(['ID_USER','USER_ID','user_name','first_name','last_name','id_bu','active']);
    }
    public function run(){
        return $this->belongsTo('App\Models\User','id_am_run','USER_ID')
            ->select(['USER_ID','ID_USER','user_name','first_name','last_name','id_bu','active']);
    }
}
