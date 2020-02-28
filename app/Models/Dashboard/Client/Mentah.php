<?php

namespace App\Models\Dashboard\Client;

use Illuminate\Database\Eloquent\Model;

class Mentah extends Model
{
    protected $connection="mysql3";
    protected $table="dashboard_client";

    public function channel()
    {
        return $this->belongsTo('App\Models\Mediakit\Channel','id_channel')
            ->select(
                [
                    'id_channel',
                    'name_channel',
                    'id_bu',
                    'tier',
                    'group_name',
                    'type',
                    'img',
                    'website',
                    'keterangan'
                ]
            );
    }

    public function advertiser()
    {
        return $this->belongsTo('App\Models\Mediakit\Advertiser','id_adv')
            ->select(
                [
                    'id_adv',
                    'nama_adv',
                    'id_typeadv',
                    'id_demography'
                ]
            );
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Dashboard\Produk','id_product','id_produk')
            ->select(
                [
                    'id_produk',
                    'nama_produk',
                    'id_category',
                    'id_sector',
                    'id_brand',
                    'id_adv',
                    'id_ta'
                ]
            );
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Dashboard\Programariana','id_program','id_program_ariana')
            ->select(
                [
                    'id_program_ariana',
                    'name',
                    'id_level2',
                    'id_channel',
                    'daypart1',
                    'daypart2'
                ]
            );
    }

    public function sector()
    {
        return $this->belongsTo('App\Models\Dashboard\Sector','id_sector')
            ->select(
                [
                    'id_sector',
                    'name_sector',
                    'filter'
                ]
            );
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Dashboard\Category','id_category')
            ->select(
                [
                    'id_category',
                    'name_category'
                ]
            );
    }

    public function level1()
    {
        return $this->belongsTo('App\Models\Dashboard\Level1','id_level1')
            ->select(
                [
                    'id_level1',
                    'name_level1'
                ]
            );
    }

    public function level2()
    {
        return $this->belongsTo('App\Models\Dashboard\Level2','id_level2')
            ->select(
                [
                    'id_level2',
                    'name_level2',
                    'id_level1'
                ]
            );
    }
}