<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Advertisercluster extends Model
{
    protected $table="db_m_advertiser_cluster";
    protected $primaryKey="id";

    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idagency'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idagency.required'=>'please choose agency',
    ];

    function agency(){
        return $this->belongsTo('App\Models\Dashboard\Advertiser', 'id_adv');
    }
}
