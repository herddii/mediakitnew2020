<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Programgen extends Model
{
    protected $table="db_m_proggen";
    protected $primaryKey="id_proggen";

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'insert_user',
        'update_user'
    ];
    public static $rules=[
        'name'=>'required',
        'idlevel2'=>'required',
    ];

    public static $pesan=[
        'name.required'=>'please fill name',
        'idlevel2.required'=>'please choose Level2',
    ];

    public function level2(){
        return $this->belongsTo('App\Models\Dashboard\Level2','id_level2')
            ->select(['id_level2','name_level2','id_level1']);
    }

    public function bu(){
        return $this->belongsTo('App\Bu','id_bu','ID_BU')
            ->select(['ID_BU','BU_FULL_NAME','BU_SHORT_NAME','IMAGE']);
    }
}
