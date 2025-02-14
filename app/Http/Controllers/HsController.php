<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valiable;
use App\Models\HsStat;
use App\Models\PassResult;
use App\Models\UnivStat;

class HsController extends Controller
{
    public function index(Request $request,$prefRoma,$hs_id)
    {
        $pref = $this->getPrefCodeByRoma($prefRoma);
        if ( is_null($pref) ) {
            abort(404);
        }
        $hs_stat = HsStat::where('is_show','=',1)->where('hs_id','=',$hs_id)->orderBy('grad_year','DESC')->first();
        if ( ! $hs_stat ) {
            abort(404);
        }
        if ( $hs_stat->hs->prefecture != $pref ) {
            abort(404);
        }
        $pass_results = PassResult::where('grad_year','=',$hs_stat->grad_year)->where('hs_id','=',$hs_stat->hs_id)->where('dept_type','=',$hs_stat->dept_type)->get();
        foreach ( $pass_results as $rec ) {
            $univ_stat = UnivStat::where('grad_year','=',$hs_stat->grad_year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
            if ( ! $univ_stat ) {
                continue;
            }
            $rec->grad_ss = $univ_stat->grad_ss;
            $rec->grad_ss_year = $univ_stat->grad_ss_year;
        }
        
        return view('hs.index')
            ->with('hs_stat',$hs_stat)
            ->with('prefRoma',$prefRoma)
            ->with('pref',$pref)
            ->with('pass_results',$pass_results)
        ;
    }
}
