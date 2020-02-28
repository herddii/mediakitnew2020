<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }
	public function index(Request $request){
		return view('dashboard.dashboard');
	}

	public function channel(Request $request){
		try {
            $var = \DB::table('db_m_channel as a')->select('*')->where('a.keterangan','internal')->get();
            return response($var,200);
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect(route('users.index'));
        }
	}

	public function store(Excel $excel, Request $request){
		$file1 = $request->file('file_pertama');
		$file2 = $request->file('file_kedua');
		$reader1 = \Excel::load($file1);
		$reader2 = \Excel::load($file2);
		$array_1 = [];
		$array_2 = [];
		$results1 = $reader1->noHeading()->get()->toArray();
		$results2 = $reader2->noHeading()->get()->toArray();
		$hasil = [];
		$sheetArray[] = array();
		foreach ($results1 as $v) {
			for($s=1; $s<count($v);$s++){
				array_push($array_1,$v[$s]);
			}
		}
		for($s2=1; $s2<count($results2[0]);$s2++){
           	// return $results2[$s2];
			$b = strpos_arr($results2[0][$s2][1],$array_1);
			array_push($hasil,$b);
		}
		$c = Excel::create('investor', function($excel) use ($hasil, $results2) {
			$excel->sheet('mySheet', function($sheet) use ($hasil, $results2) {
				$sheetArray = array();

			// Add the headers
			$sheetArray[] = array('No','Nama','Nilai','Values');
			// Add the results

			for($i=0; $i<count($hasil); $i++){
				$sheetArray[] = array($i+1,$results2[0][$i+1][1],$results2[0][$i+1][2],$hasil[$i]);
			}

			// Generating the sheet from the array
			$sheet->fromArray($sheetArray);
			});
		})->store('xlsx', 'public/reports/', true);
	}

	public function getIndex(Request $request,$id_kategori){
        try {
            $isi_portal = \DB::table('portal_berita as b')
            ->leftJoin('portal_bankfoto as c','c.id_portal','b.id_portal')
            ->where('b.id_kategori',$id_kategori)
            // ->where('b.type_video','CITRAPARIWARA') 
            ->whereNull('b.deleted_at')
            ->orderBy('b.created_at','DESC')
            ->groupBy('b.id_portal')
            ->paginate(6);
            return response($isi_portal,200);
        } catch (\Exception $e){
            return response($e->getMessage);
        } 
    }

    public function tv_rating(Request $request){

        // return $tanggal=\DB::select("select DATE_ADD('2019-01-31', INTERVAL -11 DAY) as tgl");
        $ta=$request->input('ta');
        $periode='Daily';
        $daypart=$request->input('daypartnya');
        $tier=$request->input('tier');

        if($tier==1){
            $tiernya='AND b.tier=1';
        }else if($tier==2){
            $tiernya='AND b.tier=2';
        }else if($tier==3){
            $tiernya='AND b.tier=3';
        }else if($tier==4){
            $tiernya='AND b.tier=4';
        }else if($tier==5){
            $tiernya='';
        }else{
            $tiernya='AND a.id_channel in (1,2,3,4)';
        }

        if($daypart=='PT'){
            $daypartnya='AND c.daypart1 = "PT"';
        }elseif($daypart=='NPT'){
            $daypartnya='AND c.daypart1 = "NPT"';
        }else{
            $daypartnya='';
        }

        switch ($periode) {
            case 'Daily':
                $periodeStatus='Daily';

                $cariTgl=\App\Models\Dashboard\FilterPeriode::where('type','=','TV-PERFORMANCE')->first();
                $mintgl=\DB::select("select DATE_ADD('2019-10-29', INTERVAL -11 DAY) as kemarin");
                $kemarin=$mintgl[0]->kemarin;
                $sekarang=$cariTgl->periode;

                $tanggal=\DB::select("select a.tanggal from tv_rating a where a.tanggal BETWEEN '$kemarin' AND '$sekarang' and a.id_ta=1 group by a.tanggal");
                
                $satu=$tanggal[0]->tanggal;
                $dua=$tanggal[1]->tanggal;
                $tiga=$tanggal[2]->tanggal;
                $empat=$tanggal[3]->tanggal;
                $lima=$tanggal[4]->tanggal;
                $enam=$tanggal[5]->tanggal;
                $tujuh=$tanggal[6]->tanggal;
                $delapan=$tanggal[7]->tanggal;
                $sembilan=$tanggal[8]->tanggal;
                $sepuluh=$tanggal[9]->tanggal;
                $sebelas=$tanggal[10]->tanggal;
                if (isset($tanggal[11])) {
                    $duabelas=$tanggal[11]->tanggal;
                }else{
                    $duabelas='';
                }
                
                return $rating=\DB::select("select b.id_channel,b.name_channel,b.tier,
                    ROUND(AVG(if(a.tanggal='$satu',a.tvr,NULL)),2) AS rating1
                    FROM tv_rating a
                    LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                    LEFT JOIN master_hour c on c.jam = a.jam
                    WHERE a.id_ta=1 AND a.tanggal BETWEEN '$kemarin' AND '$sekarang'  
                    $daypartnya
                    GROUP BY  a.id_channel");
            break;

            case 'Weekly':
                $periodeStatus='Weekly';

                $cariTgl=\App\Models\Dashboard\FilterPeriode::where('type','=','TV-PERFORMANCE')->first();
                $maxTahun= date('Y', strtotime($cariTgl->periode));
                $minTahun=$maxTahun-1;

                $maxntgl=\DB::select("select max(week(a.tanggal)+1) mingguKe from tv_rating a where a.tahun='$maxTahun'");

                $kemarin=$maxntgl[0]->mingguKe - 11;
                $sekarang=$maxntgl[0]->mingguKe;
                if($kemarin<0){

                    if($kemarin== -1){
                        $satu=52;
                        $dua=1;
                        $tiga=2;
                        $empat=3;
                        $lima=4;
                        $enam=5;
                        $tujuh=6;
                        $delapan=7;
                        $sembilan=8;
                        $sepuluh=9;
                        $sebelas=10;
                        $duabelas=11;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$maxTahun;
                        $date3='W '.$tiga.' - '.$maxTahun;
                        $date4='W '.$empat.' - '.$maxTahun;
                        $date5='W '.$lima.' - '.$maxTahun;
                        $date6='W '.$enam.' - '.$maxTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -2){
                        $satu=51;
                        $dua=52;
                        $tiga=1;
                        $empat=2;
                        $lima=3;
                        $enam=4;
                        $tujuh=5;
                        $delapan=6;
                        $sembilan=7;
                        $sepuluh=8;
                        $sebelas=9;
                        $duabelas=10;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$maxTahun;
                        $date4='W '.$empat.' - '.$maxTahun;
                        $date5='W '.$lima.' - '.$maxTahun;
                        $date6='W '.$enam.' - '.$maxTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -3){
                        $satu=50;
                        $dua=51;
                        $tiga=52;
                        $empat=1;
                        $lima=2;
                        $enam=3;
                        $tujuh=4;
                        $delapan=5;
                        $sembilan=6;
                        $sepuluh=7;
                        $sebelas=8;
                        $duabelas=9;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$maxTahun;
                        $date5='W '.$lima.' - '.$maxTahun;
                        $date6='W '.$enam.' - '.$maxTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -4){
                        $satu=49;
                        $dua=50;
                        $tiga=51;
                        $empat=52;
                        $lima=1;
                        $enam=2;
                        $tujuh=3;
                        $delapan=4;
                        $sembilan=5;
                        $sepuluh=6;
                        $sebelas=7;
                        $duabelas=8;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$maxTahun;
                        $date6='W '.$enam.' - '.$maxTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -5){
                        $satu=48;
                        $dua=49;
                        $tiga=50;
                        $empat=51;
                        $lima=52;
                        $enam=1;
                        $tujuh=2;
                        $delapan=3;
                        $sembilan=4;
                        $sepuluh=5;
                        $sebelas=6;
                        $duabelas=7;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$maxTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -6){
                        $satu=47;
                        $dua=48;
                        $tiga=49;
                        $empat=50;
                        $lima=51;
                        $enam=52;
                        $tujuh=1;
                        $delapan=2;
                        $sembilan=3;
                        $sepuluh=4;
                        $sebelas=5;
                        $duabelas=6;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$maxTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -7){
                        $satu=46;
                        $dua=47;
                        $tiga=48;
                        $empat=49;
                        $lima=50;
                        $enam=51;
                        $tujuh=52;
                        $delapan=1;
                        $sembilan=2;
                        $sepuluh=3;
                        $sebelas=4;
                        $duabelas=5;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$minTahun;
                        $date8='W '.$delapan.' - '.$maxTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -8 ){
                        $satu=45;
                        $dua=46;
                        $tiga=47;
                        $empat=48;
                        $lima=49;
                        $enam=50;
                        $tujuh=51;
                        $delapan=52;
                        $sembilan=1;
                        $sepuluh=2;
                        $sebelas=3;
                        $duabelas=4;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$minTahun;
                        $date8='W '.$delapan.' - '.$minTahun;
                        $date9='W '.$sembilan.' - '.$maxTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -9){
                        $satu=44;
                        $dua=45;
                        $tiga=46;
                        $empat=47;
                        $lima=48;
                        $enam=49;
                        $tujuh=50;
                        $delapan=51;
                        $sembilan=52;
                        $sepuluh=1;
                        $sebelas=2;
                        $duabelas=3;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$minTahun;
                        $date8='W '.$delapan.' - '.$minTahun;
                        $date9='W '.$sembilan.' - '.$minTahun;
                        $date10='W '.$sepuluh.' - '.$maxTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -10){
                        $satu=43;
                        $dua=44;
                        $tiga=45;
                        $empat=46;
                        $lima=47;
                        $enam=48;
                        $tujuh=49;
                        $delapan=50;
                        $sembilan=51;
                        $sepuluh=52;
                        $sebelas=1;
                        $duabelas=2;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$minTahun;
                        $date8='W '.$delapan.' - '.$minTahun;
                        $date9='W '.$sembilan.' - '.$minTahun;
                        $date10='W '.$sepuluh.' - '.$minTahun;
                        $date11='W '.$sebelas.' - '.$maxTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -11){
                        $satu=42;
                        $dua=43;
                        $tiga=44;
                        $empat=45;
                        $lima=46;
                        $enam=47;
                        $tujuh=48;
                        $delapan=49;
                        $sembilan=50;
                        $sepuluh=51;
                        $sebelas=52;
                        $duabelas=1;

                        $date1='W '.$satu.' - '.$minTahun;
                        $date2='W '.$dua.' - '.$minTahun;
                        $date3='W '.$tiga.' - '.$minTahun;
                        $date4='W '.$empat.' - '.$minTahun;
                        $date5='W '.$lima.' - '.$minTahun;
                        $date6='W '.$enam.' - '.$minTahun;
                        $date7='W '.$tujuh.' - '.$minTahun;
                        $date8='W '.$delapan.' - '.$minTahun;
                        $date9='W '.$sembilan.' - '.$minTahun;
                        $date10='W '.$sepuluh.' - '.$minTahun;
                        $date11='W '.$sebelas.' - '.$minTahun;
                        $date12='W '.$duabelas.' - '.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }

                    $tanggal = array($date1,$date2,$date3,$date4,$date5,$date6,$date7,$date8,$date9,$date10,$date11,$date12);

                }else{
                    $minggu=\DB::select("select week(a.tanggal)+1 mingguKe from tv_rating a where week(a.tanggal)+1 BETWEEN $kemarin AND $sekarang and a.id_ta=$ta and a.tahun='$maxTahun' group by week(a.tanggal)+1");

                    $satu=$minggu[0]->mingguKe;
                    $dua=$minggu[1]->mingguKe;
                    $tiga=$minggu[2]->mingguKe;
                    $empat=$minggu[3]->mingguKe;
                    $lima=$minggu[4]->mingguKe;
                    $enam=$minggu[5]->mingguKe;
                    $tujuh=$minggu[6]->mingguKe;
                    $delapan=$minggu[7]->mingguKe;
                    $sembilan=$minggu[8]->mingguKe;
                    $sepuluh=$minggu[9]->mingguKe;
                    $sebelas=$minggu[10]->mingguKe;
                    $duabelas=$minggu[11]->mingguKe;

                    $date1='W '.$satu.' - '.$maxTahun;
                    $date2='W '.$dua.' - '.$maxTahun;
                    $date3='W '.$tiga.' - '.$maxTahun;
                    $date4='W '.$empat.' - '.$maxTahun;
                    $date5='W '.$lima.' - '.$maxTahun;
                    $date6='W '.$enam.' - '.$maxTahun;
                    $date7='W '.$tujuh.' - '.$maxTahun;
                    $date8='W '.$delapan.' - '.$maxTahun;
                    $date9='W '.$sembilan.' - '.$maxTahun;
                    $date10='W '.$sepuluh.' - '.$maxTahun;
                    $date11='W '.$sebelas.' - '.$maxTahun;
                    $date12='W '.$duabelas.' - '.$maxTahun;

                    $rating=\DB::select("select b.id_channel,b.name_channel,
                        ROUND(AVG(if(week(a.tanggal)+1='$satu' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating1,
                        ROUND(AVG(if(week(a.tanggal)+1='$dua' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating2,
                        ROUND(AVG(if(week(a.tanggal)+1='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                        ROUND(AVG(if(week(a.tanggal)+1='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                        ROUND(AVG(if(week(a.tanggal)+1='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                        ROUND(AVG(if(week(a.tanggal)+1='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                        ROUND(AVG(if(week(a.tanggal)+1='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                        ROUND(AVG(if(week(a.tanggal)+1='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                        ROUND(AVG(if(week(a.tanggal)+1='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                        ROUND(AVG(if(week(a.tanggal)+1='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                        ROUND(AVG(if(week(a.tanggal)+1='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                        ROUND(AVG(if(week(a.tanggal)+1='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                        FROM tv_rating a
                        LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                        LEFT JOIN master_hour c on c.jam = a.jam
                        WHERE a.id_ta=$ta and b.id_channel is not null
                        $tiernya
                        $daypartnya
                        GROUP BY a.id_channel");

                    $tanggal = array($date1,$date2,$date3,$date4,$date5,$date6,$date7,$date8,$date9,$date10,$date11,$date12);
                }
            break;

            case 'Monthly':
                $periodeStatus='Monthly';
                
                $cariTgl=\App\Models\Dashboard\FilterPeriode::where('type','=','TV-PERFORMANCE')->first();
                $maxTahun= date('Y', strtotime($cariTgl->periode));
                $minTahun=$maxTahun-1;

                $maxbln=\DB::select("select max(MONTH(a.tanggal)) bulan from tv_rating a where a.tahun='$maxTahun'");
                $kemarin=$maxbln[0]->bulan - 12;
                $sekarang=$maxbln[0]->bulan;

                if($kemarin<0){

                    if($kemarin== -1){
                        $satu=12;
                        $dua=1;
                        $tiga=2;
                        $empat=3;
                        $lima=4;
                        $enam=5;
                        $tujuh=6;
                        $delapan=7;
                        $sembilan=8;
                        $sepuluh=9;
                        $sebelas=10;
                        $duabelas=11;

                        $date1= 'Des-'.$minTahun;
                        $date2= 'Jan-'.$maxTahun;
                        $date3= 'Feb-'.$maxTahun;
                        $date4= 'Mar-'.$maxTahun;
                        $date5= 'Apr-'.$maxTahun;
                        $date6= 'Mei-'.$maxTahun;
                        $date7= 'Jun-'.$maxTahun;
                        $date8= 'Jul-'.$maxTahun;
                        $date9= 'Aug-'.$maxTahun;
                        $date10='Sep-'.$maxTahun;
                        $date11='Okt-'.$maxTahun;
                        $date12='Nov-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -2){
                        $satu=11;
                        $dua=12;
                        $tiga=1;
                        $empat=2;
                        $lima=3;
                        $enam=4;
                        $tujuh=5;
                        $delapan=6;
                        $sembilan=7;
                        $sepuluh=8;
                        $sebelas=9;
                        $duabelas=10;

                        $date1= 'Nov-'.$minTahun;
                        $date2= 'Des-'.$minTahun;
                        $date3= 'Jan-'.$maxTahun; 
                        $date4= 'Feb-'.$maxTahun;
                        $date5= 'Mar-'.$maxTahun;
                        $date6= 'Apr-'.$maxTahun;
                        $date7= 'Mei-'.$maxTahun;
                        $date8= 'Jun-'.$maxTahun;
                        $date9= 'Jul-'.$maxTahun;
                        $date10='Aug-'.$maxTahun;
                        $date11='Sep-'.$maxTahun;
                        $date12='Okt-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -3){
                        $satu=10;
                        $dua=11;
                        $tiga=12;
                        $empat=1;
                        $lima=2;
                        $enam=3;
                        $tujuh=4;
                        $delapan=5;
                        $sembilan=6;
                        $sepuluh=7;
                        $sebelas=8;
                        $duabelas=9;

                        $date1= 'Okt-'.$minTahun; 
                        $date2= 'Nov-'.$minTahun; 
                        $date3= 'Des-'.$minTahun; 
                        $date4= 'Jan-'.$maxTahun;
                        $date5= 'Feb-'.$maxTahun;
                        $date6= 'Mar-'.$maxTahun;
                        $date7= 'Apr-'.$maxTahun;
                        $date8= 'Mei-'.$maxTahun;
                        $date9= 'Jun-'.$maxTahun;
                        $date10='Jul-'.$maxTahun;
                        $date11='Aug-'.$maxTahun;
                        $date12='Sep-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -4){
                        $satu=9;
                        $dua=10;
                        $tiga=11;
                        $empat=12;
                        $lima=1;
                        $enam=2;
                        $tujuh=3;
                        $delapan=4;
                        $sembilan=5;
                        $sepuluh=6;
                        $sebelas=7;
                        $duabelas=8;

                        $date1= 'Sep-'.$minTahun; 
                        $date2= 'Okt-'.$minTahun; 
                        $date3= 'Nov-'.$minTahun; 
                        $date4= 'Des-'.$minTahun; 
                        $date5= 'Jan-'.$maxTahun;
                        $date6= 'Feb-'.$maxTahun;
                        $date7= 'Mar-'.$maxTahun;
                        $date8= 'Apr-'.$maxTahun;
                        $date9= 'Mei-'.$maxTahun;
                        $date10='Jun-'.$maxTahun;
                        $date11='Jul-'.$maxTahun;
                        $date12='Aug-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -5){
                        $satu=8;
                        $dua=9;
                        $tiga=10;
                        $empat=11;
                        $lima=12;
                        $enam=1;
                        $tujuh=2;
                        $delapan=3;
                        $sembilan=4;
                        $sepuluh=5;
                        $sebelas=6;
                        $duabelas=7;

                        $date1= 'Aug-'.$minTahun; 
                        $date2= 'Sep-'.$minTahun; 
                        $date3= 'Okt-'.$minTahun; 
                        $date4= 'Nov-'.$minTahun; 
                        $date5= 'Des-'.$minTahun; 
                        $date6= 'Jan-'.$maxTahun;
                        $date7= 'Feb-'.$maxTahun;
                        $date8= 'Mar-'.$maxTahun;
                        $date9= 'Apr-'.$maxTahun;
                        $date10='Mei-'.$maxTahun;
                        $date11='Jun-'.$maxTahun;
                        $date12='Jul-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -6){
                        $satu=7;
                        $dua=8;
                        $tiga=9;
                        $empat=10;
                        $lima=11;
                        $enam=12;
                        $tujuh=1;
                        $delapan=2;
                        $sembilan=3;
                        $sepuluh=4;
                        $sebelas=5;
                        $duabelas=6;

                        $date1= 'Jul-'.$minTahun; 
                        $date2= 'Aug-'.$minTahun; 
                        $date3= 'Sep-'.$minTahun; 
                        $date4= 'Okt-'.$minTahun; 
                        $date5= 'Nov-'.$minTahun; 
                        $date6= 'Des-'.$minTahun; 
                        $date7= 'Jan-'.$maxTahun;
                        $date8= 'Feb-'.$maxTahun;
                        $date9= 'Mar-'.$maxTahun;
                        $date10='Apr-'.$maxTahun;
                        $date11='Mei-'.$maxTahun;
                        $date12='Jun-'.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -7){
                        $satu=6;
                        $dua=7;
                        $tiga=8;
                        $empat=9;
                        $lima=10;
                        $enam=11;
                        $tujuh=12;
                        $delapan=1;
                        $sembilan=2;
                        $sepuluh=3;
                        $sebelas=4;
                        $duabelas=5;

                        $date1= 'Jun-'.$minTahun; 
                        $date2= 'Jul-'.$minTahun; 
                        $date3= 'Aug-'.$minTahun; 
                        $date4= 'Sep-'.$minTahun; 
                        $date5= 'Okt-'.$minTahun; 
                        $date6= 'Nov-'.$minTahun; 
                        $date7= 'Des-'.$minTahun; 
                        $date8= 'Jan-'.$maxTahun;
                        $date9= 'Feb-'.$maxTahun;
                        $date10='Mar-'.$maxTahun;
                        $date11='Apr-'.$maxTahun;
                        $date12='Mei-'.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -8 ){
                        $satu=5;
                        $dua=6;
                        $tiga=7;
                        $empat=8;
                        $lima=9;
                        $enam=10;
                        $tujuh=11;
                        $delapan=12;
                        $sembilan=1;
                        $sepuluh=2;
                        $sebelas=3;
                        $duabelas=4;

                        $date1= 'Mei-'.$minTahun; 
                        $date2= 'Jun-'.$minTahun; 
                        $date3= 'Jul-'.$minTahun; 
                        $date4= 'Aug-'.$minTahun; 
                        $date5= 'Sep-'.$minTahun; 
                        $date6= 'Okt-'.$minTahun; 
                        $date7= 'Nov-'.$minTahun; 
                        $date8= 'Des-'.$minTahun; 
                        $date9= 'Jan-'.$maxTahun;
                        $date10='Feb-'.$maxTahun;
                        $date11='Mar-'.$maxTahun;
                        $date12='Apr-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -9){
                        $satu=4;
                        $dua=5;
                        $tiga=6;
                        $empat=7;
                        $lima=8;
                        $enam=9;
                        $tujuh=10;
                        $delapan=11;
                        $sembilan=12;
                        $sepuluh=1;
                        $sebelas=2;
                        $duabelas=3;

                        $date1= 'Apr-'.$minTahun; 
                        $date2= 'Mei-'.$minTahun; 
                        $date3= 'Jun-'.$minTahun; 
                        $date4= 'Jul-'.$minTahun; 
                        $date5= 'Aug-'.$minTahun; 
                        $date6= 'Sep-'.$minTahun; 
                        $date7= 'Okt-'.$minTahun; 
                        $date8= 'Nov-'.$minTahun; 
                        $date9= 'Des-'.$minTahun; 
                        $date10='Jan-'.$maxTahun;
                        $date11='Feb-'.$maxTahun;
                        $date12='Mar-'.$maxTahun;
                        
                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -10){
                        $satu=3;
                        $dua=4;
                        $tiga=5;
                        $empat=6;
                        $lima=7;
                        $enam=8;
                        $tujuh=9;
                        $delapan=10;
                        $sembilan=11;
                        $sepuluh=12;
                        $sebelas=1;
                        $duabelas=2;

                        $date1= 'Mar-'.$minTahun;
                        $date2= 'Apr-'.$minTahun;
                        $date3= 'Mei-'.$minTahun;
                        $date4= 'Jun-'.$minTahun;
                        $date5= 'Jul-'.$minTahun;
                        $date6= 'Aug-'.$minTahun;
                        $date7= 'Sep-'.$minTahun;
                        $date8= 'Okt-'.$minTahun;
                        $date9= 'Nov-'.$minTahun;
                        $date10='Des-'.$minTahun;
                        $date11='Jan-'.$maxTahun;
                        $date12='Feb-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }elseif($kemarin== -11){
                        $satu=2;
                        $dua=3;
                        $tiga=4;
                        $empat=5;
                        $lima=6;
                        $enam=7;
                        $tujuh=8;
                        $delapan=9;
                        $sembilan=10;
                        $sepuluh=11;
                        $sebelas=12;
                        $duabelas=1;

                        $date1='Feb-'.$minTahun;
                        $date2='Mar-'.$minTahun;
                        $date3='Apr-'.$minTahun;
                        $date4='Mei-'.$minTahun;
                        $date5='Jun-'.$minTahun;
                        $date6='Jul-'.$minTahun;
                        $date7='Aug-'.$minTahun;
                        $date8='Sep-'.$minTahun;
                        $date9='Okt-'.$minTahun;
                        $date10='Nov-'.$minTahun;
                        $date11='Des-'.$minTahun;
                        $date12='Jan-'.$maxTahun;

                        $rating=\DB::select("select b.id_channel,b.name_channel,
                            ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating1,
                            ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating2,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating3,
                            ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating4,
                            ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating5,
                            ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating6,
                            ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating7,
                            ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating8,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating9,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating10,
                            ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$minTahun',a.tvr,NULL)),2) AS rating11,
                            ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                            FROM tv_rating a
                            LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                            LEFT JOIN master_hour c on c.jam = a.jam
                            WHERE a.id_ta=$ta and b.id_channel is not null
                            $tiernya
                            $daypartnya 
                            GROUP BY a.id_channel");
                    }

                    $tanggal = array($date1,$date2,$date3,$date4,$date5,$date6,$date7,$date8,$date9,$date10,$date11,$date12);

                }else{
                    $bulan=\DB::select("select MONTH(a.tanggal) bulan from tv_rating a where MONTH(a.tanggal) BETWEEN $kemarin AND $sekarang and a.id_ta=$ta and a.tahun='$maxTahun' group by MONTH(a.tanggal)");

                    $satu=$bulan[0]->bulan;
                    $dua=$bulan[1]->bulan;
                    $tiga=$bulan[2]->bulan;
                    $empat=$bulan[3]->bulan;
                    $lima=$bulan[4]->bulan;
                    $enam=$bulan[5]->bulan;
                    $tujuh=$bulan[6]->bulan;
                    $delapan=$bulan[7]->bulan;
                    $sembilan=$bulan[8]->bulan;
                    $sepuluh=$bulan[9]->bulan;
                    $sebelas=$bulan[10]->bulan;
                    $duabelas=$bulan[11]->bulan;

                    $date1=  $satu.'-'.$maxTahun;
                    $date2=  $dua.'-'.$maxTahun;
                    $date3=  $tiga.'-'.$maxTahun;
                    $date4=  $empat.'-'.$maxTahun;
                    $date5=  $lima.'-'.$maxTahun;
                    $date6=  $enam.'-'.$maxTahun;
                    $date7=  $tujuh.'-'.$maxTahun;
                    $date8=  $delapan.'-'.$maxTahun;
                    $date9=  $sembilan.'-'.$maxTahun;
                    $date10= $sepuluh.'-'.$maxTahun;
                    $date11= $sebelas.'-'.$maxTahun;
                    $date12= $duabelas.'-'.$maxTahun;

                    $rating=\DB::select("select b.id_channel,b.name_channel,
                        ROUND(AVG(if(MONTH(a.tanggal)='$satu' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating1,
                        ROUND(AVG(if(MONTH(a.tanggal)='$dua' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating2,
                        ROUND(AVG(if(MONTH(a.tanggal)='$tiga' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating3,
                        ROUND(AVG(if(MONTH(a.tanggal)='$empat' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating4,
                        ROUND(AVG(if(MONTH(a.tanggal)='$lima' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating5,
                        ROUND(AVG(if(MONTH(a.tanggal)='$enam' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating6,
                        ROUND(AVG(if(MONTH(a.tanggal)='$tujuh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating7,
                        ROUND(AVG(if(MONTH(a.tanggal)='$delapan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating8,
                        ROUND(AVG(if(MONTH(a.tanggal)='$sembilan' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating9,
                        ROUND(AVG(if(MONTH(a.tanggal)='$sepuluh' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating10,
                        ROUND(AVG(if(MONTH(a.tanggal)='$sebelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating11,
                        ROUND(AVG(if(MONTH(a.tanggal)='$duabelas' and a.tahun='$maxTahun',a.tvr,NULL)),2) AS rating12
                        FROM tv_rating a
                        LEFT JOIN db_m_channel b ON b.id_channel = a.id_channel
                        LEFT JOIN master_hour c on c.jam = a.jam
                        WHERE a.id_ta=$ta and b.id_channel is not null
                        $tiernya
                        $daypartnya
                        GROUP BY a.id_channel");

                    $tanggal = array($date1,$date2,$date3,$date4,$date5,$date6,$date7,$date8,$date9,$date10,$date11,$date12);
                }
            break;

            default:
            break;
        }

        return array(
            'rating'=>$rating,
            'tanggal'=>$tanggal,
            'periodeStatus'=>$periodeStatus,
            'daypart'=>$daypart,
            'ta'=>$ta
        ); 

    }

    public function market_share(Request $request){
        $type = $request->input('type');
        return $var=\DB::select('select a.ADVERTISER,
            sum(if(a.UNIT = "RCTI",a.NET ,0)) as RCTI, 
            sum(if(a.UNIT = "MNCTV",a.NET ,0)) as MNCTV,
            sum(if(a.UNIT = "GTV",a.NET ,0)) as GTV,
            a.AGENCY_PINTU, a.UNIT,
            MONTHNAME(STR_TO_DATE(a.MONTH, "%m")) as bulan
            from tbl_dashboard as a 
            group by a.'.$type.'
            ORDER BY a.NET DESC
            limit 5');
    }

    public function list_top_program(Request $request){

        $channelnya=0;
        $ta=$request->input('ta');
        $start_periode= '2019-10-29';
        $end_periode= '2019-10-29';

        // $tiers=\App\Models\Mediakit\Channel::find();

        if($channelnya==8){
            $channel='and a.id_channel = 4';
            $data=\App\Models\Mediakit\Channel::find(4);
            $judul=$data->name_channel;
        }elseif($channelnya==1 || $channelnya==2 || $channelnya==3){
            $channel='and a.id_channel ='.$channelnya;
            $data=\App\Models\Mediakit\Channel::find($channelnya);
            $judul=$data->name_channel;
        }elseif($channelnya==0){
            $channel='and a.id_channel in (1,2,3,4)';
            $judul='MNCGROUP';
        }elseif($channelnya==9){
            $channel='and d.tier=1';
            $judul='TIER 1';
        }elseif($channelnya==10){
            $channel='and d.tier=2';
            $judul='TIER 2';
        }elseif($channelnya==11){
            $channel='and d.tier=3';
            $judul='TIER 3';
        }elseif($channelnya==12){
            $channel='and d.tier=4';
            $judul='TIER 4';
        }elseif($channelnya==13){
            $channel='';
            $judul='ALL TV';
        }

        $allgenre=\DB::select("select (@cnt := @cnt + 1) AS no,semua.* from (
            select data.name, data.id_program_ariana, data.name_channel,data.id_channel, data.id_level2,data.daypart1, data.tier,data.thousands,
                    data.id_level1, data.tvr, sum(data.tvr_dipilih) tvr_dipilih, data.shares,
                    sum(data.ta1) ta1, sum(data.ta13) ta13,  sum(data.ta14) ta14, sum(data.ta15) ta15, 
                    sum(data.ta16) ta16,  sum(data.ta17) ta17, sum(data.ta18) ta18, sum(data.ta19) ta19
                    from
                        (select b.name,a.id_program_ariana, d.name_channel, d.id_channel,d.tier, b.id_level2, f.id_level1,g.daypart1,a.thousands,
                            ROUND(sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,2) as tvr, 
                            sum(a.total_thousands)/ sum(a.tot_pot_thousands) as shares,
                            ROUND(if(c.id_ta='$ta',sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) tvr_dipilih,
                            ROUND(if(c.id_ta=1,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta1,
                            ROUND(if(c.id_ta=13,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta13,
                            ROUND(if(c.id_ta=14,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta14,
                            ROUND(if(c.id_ta=15,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta15,
                            ROUND(if(c.id_ta=16,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta16,
                            ROUND(if(c.id_ta=17,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta17,
                            ROUND(if(c.id_ta=18,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta18,
                            ROUND(if(c.id_ta=19,sum(a.total_thousands)/sum(a.duration)/ AVG(a.populasi) * 100,0),2) ta19
                            from program_rating a
                            left join program_ariana b on b.id_program_ariana = a.id_program_ariana
                            left join ta c on c.id_ta = a.id_ta
                            left join db_m_channel d on d.id_channel = a.id_channel
                            left join program_ariana_level2 e on e.id_level2 = b.id_level2
                            left join program_ariana_level1 f on f.id_level1 = e.id_level1
                            left join master_hour g on g.jam = a.jam
                            where c.id_ta in (1,13,14,15,16,17,18,19) and date_format(a.tanggal,'%Y-%m-%d') between '$start_periode'  and '$end_periode' $channel
                            group by a.id_program_ariana, c.id_ta ) 
                    as data 
                    group by data.id_program_ariana 
            ) as semua 
            CROSS JOIN (SELECT @cnt := 0) AS dummy
            order by semua.tvr_dipilih desc, semua.thousands desc limit 5");

        return array(
            'allgenre'=>$allgenre,
            'judul'=>$judul
        ); 
    }

}

