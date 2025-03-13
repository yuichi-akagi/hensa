<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hs;
use App\Models\HsStat;
use App\Models\UnivStat;
use App\Models\PassResult;
use App\Models\HsDeptStat;
use DB;

class HsController extends Controller
{
    public function index(Request $request,$year)
    {
        $result = Hs::whereNull('deleted_at')->get();
        $stats = HsStat::select('hs_id',DB::raw('count(id) as cnt'))->groupBy('hs_id')->get();
        $dept_stats = HsDeptStat::select('hs_id',DB::raw('count(id) as cnt'))->groupBy('hs_id')->get();
        foreach ( $result as $rec ) {
            $rec->stat_count = 0;
            foreach ( $stats as $rec2 ) {
                if ( $rec->id == $rec2->hs_id ) {
                    $rec->stat_count = $rec2->cnt;
                }
            }
            $rec->stat_dept_count = 0;
            foreach ( $dept_stats as $rec2 ) {
                if ( $rec->id == $rec2->hs_id ) {
                    $rec->stat_dept_count = $rec2->cnt;
                }
            }
        }
        return view('manage.hs.index')
            ->with('result',$result)
            ->with('year',$year)
        ;
    }

    public function stat_index(Request $request,$year,$hs_id)
    {
        $hs = Hs::find($hs_id);
        $stats = HsStat::where('grad_year','=',$year)->where('hs_id','=',$hs_id)->get();
        $results = PassResult::where('grad_year','=',$year)->where('result','=','進学')->where('hs_id','=',$hs_id)->get();

        $pass_results = PassResult::where('grad_year','=',$year)->whereIn('result',['合格','浪人合格','現役合格'])->where('hs_id','=',$hs_id)->get();
        
        $dept_types = [];
        $univ_ids = [];
        foreacH ( $stats as $rec ) {
            $tmp_results = [];
            foreach ( $results as $rec2 ) {
                if ( $rec2->dept_type == $rec->dept_type ) {
                    $dept_types[] = $rec->dept_type;
                    $tmp_results[] = $rec2;
                    $univ_ids[] = $rec2->univ_id;
                }
            }
            $rec->results = $tmp_results;
            $tmp_results = [];
            foreach ( $pass_results as $rec2 ) {
                if ( $rec2->dept_type == $rec->dept_type ) {
                    $dept_types[] = $rec->dept_type;
                    $tmp_results[] = $rec2;
                    $univ_ids[] = $rec2->univ_id;
                }
            }
            $rec->pass_results = $tmp_results;
        }

        $univ_stats = UnivStat::where('grad_year','=',$year)->whereIn('univ_id',$univ_ids)->get();
        foreacH ( $stats as $rec ) {
            foreach ( $rec->results as $rec2 ) {
                $rec2->grad_ss = null;
                $rec2->grad_ss_year = null;
                foreach ( $univ_stats as $univ ) {
                    if ( $univ->univ_id == $rec2->univ_id && $univ->faculty_name == $rec2->faculty_name ) {
                        $rec2->grad_ss = $univ->grad_ss;
                        $rec2->grad_ss_year = $univ->grad_ss_year;
                    }
                }
            }
            foreach ( $rec->pass_results as $rec2 ) {
                $rec2->grad_ss = null;
                $rec2->grad_ss_year = null;
                foreach ( $univ_stats as $univ ) {
                    if ( $univ->univ_id == $rec2->univ_id && $univ->faculty_name == $rec2->faculty_name ) {
                        $rec2->grad_ss = $univ->grad_ss;
                        $rec2->grad_ss_year = $univ->grad_ss_year;
                    }
                }
            }
        }
            
        $other_results = [];
        foreach ( $results as $rec2 ) {
            if ( in_array($rec2->dept_type,$dept_types) === false ) {
                $other_results[] = $rec2;
            }
        }
        return view('manage.hs.stat_index')
            ->with('year',$year)
            ->with('hs',$hs)
            ->with('stats',$stats)
            ->with('other_results',$other_results)
        ;
    }
}
