<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valiable;
use App\Models\HsStat;
use App\Models\PassResult;
use App\Models\UnivStat;
use DB;

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
        $results = PassResult::where('grad_year','=',$hs_stat->grad_year)->where('hs_id','=',$hs_stat->hs_id)->where('dept_type','=',$hs_stat->dept_type)->where('result','=','進学')->get();
        foreach ( $results as $rec ) {
            $univ_stat = UnivStat::where('grad_year','=',$hs_stat->grad_year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
            if ( ! $univ_stat ) {
                continue;
            }
            $rec->grad_ss = $univ_stat->grad_ss;
            $rec->grad_ss_year = $univ_stat->grad_ss_year;
        }
        $tmp = [];
        foreach ( $results as $rec ) {
            $key = sprintf("%04d%02d%04d",$rec->grad_count,$rec->grad_ss,$rec->id);
            if ( in_array($rec->univ->name ,['私大','国公立大学'])) {
                $key = sprintf("%04d%02d%04d",0,$rec->grad_ss,$rec->id);
            }
            $tmp[$key] = $rec;
        }
        krsort($tmp);
        reset($tmp);
        $results = $tmp;

        $pass_results = PassResult::where('grad_year','=',$hs_stat->grad_year)
            ->where('hs_id','=',$hs_stat->hs_id)
            ->where('dept_type','=',$hs_stat->dept_type)
            ->whereIn('result',['合格','浪人合格','現役合格'])
            ->select('univ_id','faculty_name','grad_year',DB::raw("sum(grad_count) as grad_count"))->groupBy('univ_id','faculty_name','grad_year')->get();
        foreach ( $pass_results as $rec ) {
            $univ_stat = UnivStat::where('grad_year','=',$hs_stat->grad_year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
            if ( ! $univ_stat ) {
                continue;
            }
            $rec->grad_ss = $univ_stat->grad_ss;
            $rec->grad_ss_year = $univ_stat->grad_ss_year;
        }
        $tmp = [];
        foreach ( $pass_results as $rec ) {
            $key = sprintf("%04d%02d%04d",$rec->grad_count,$rec->grad_ss,$rec->univ_id);
            $tmp[$key] = $rec;
        }
        krsort($tmp);
        reset($tmp);
        $pass_results = $tmp;

        return view('hs.index')
            ->with('hs_stat',$hs_stat)
            ->with('prefRoma',$prefRoma)
            ->with('pref',$pref)
            ->with('pass_results',$pass_results)
            ->with('results',$results)
        ;
    }


    public function univ_grad_count_json(Request $request)
    {
        $univ_stats = HsStat::where('hs_id','=',$request->hs_id)->where('dept_type','=',$request->dept_type)->orderBy('grad_year','ASC')->get();
        $tmp = [];
        foreach ( $univ_stats as $rec ) {
            if ( $rec->grad_count ) {
                $tmp[] = (object) [
                    'year' => $rec->grad_year . '年',
                    'line' => round($rec->grad_university_count / $rec->grad_count * 100,2),
                    'bar1' => $rec->grad_count,
                    'bar2' => $rec->grad_university_count, 
                ];
            }
        }
        return $tmp;
    }

    public function ss_line_json(Request $request)
    {
        $pass_results = PassResult::where('grad_year','=',$request->year)->where('hs_id','=',$request->hs_id)->where('dept_type','=',$request->dept_type)->get();

        $tmp = [];

        foreach ( $pass_results as $rec ) {
            $univ_stat = UnivStat::where('grad_year','=',$request->year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
            if ( ! $univ_stat ) {
                continue;
            }
            $x = round($univ_stat->grad_ss);
            if ( isset($tmp[$x]) === false ) {
                $tmp[$x] = (object)['y1' => 0,'y2' => 0];
            }
            if ( $rec->result == '進学' ) {
                $tmp[$x]->y2 += $rec->grad_count;
            } elseif ( in_array($rec->result,['合格','現役合格','浪人合格']) ) {
                $tmp[$x]->y1 += $rec->grad_count;
            }
        }
        $result = [];
        ksort($tmp);
        reset($tmp);
        foreach ( $tmp as $key => $rec ) {
            $result[] = ['x' => $key,'y1' => $rec->y1,'y2' => $rec->y2];
        }
        return $result;
    }


    public function univ_json(Request $request)
    {
        $pass_results = PassResult::where('grad_year','=',$request->year)->where('result','=','進学')->where('hs_id','=',$request->hs_id)->where('dept_type','=',$request->dept_type)->get();
        $total = 0;
        foreach ( $pass_results as $rec ) {
            $total += $rec->grad_count;
        }
        $tmp = [];
        foreach ( $pass_results as $rec ) {
            $key = sprintf("%04d%02d%04d",$rec->grad_count,$rec->grad_ss,$rec->id);
            $tmp[$key] = $rec;
        }
        krsort($tmp);
        reset($tmp);
        $json = [];
        $others = (object) ['name' => 'その他','value' => 0,'percentage' => 0];
        foreach ( $tmp as $rec ) {
            $name = $rec->univ->name;
            if ( $rec->faculty_name != '不明' ) {
                $name .= '（' . $rec->faculty_name . '）';
            }
            if ( in_array($rec->univ->name,['国公立大学','私大']) ) {
                $others->value += $rec->grad_count;
                $others->percentage = round($others->value / $total * 100,2);
                continue;
            }
            if ( count($json) > 10 || $rec->grad_count / $total < 0.05 ) {
                $others->value += $rec->grad_count;
                $others->percentage = round($others->value / $total * 100,2);
            } else {
                $json[] = (object)['name' => $name,'value' => $rec->grad_count,'percentage' => round($rec->grad_count / $total * 100,2)];
            }
        }
        if ( $others->value ) {
            $json[] = $others;
        }
        return $json;
    }

    public function univ2_json(Request $request)
    {
        $pass_results = PassResult::where('grad_year','=',$request->year)
            ->where('hs_id','=',$request->hs_id)
            ->where('dept_type','=',$request->dept_type)
            ->whereIn('result',['合格','浪人合格','現役合格'])
            ->select('univ_id','faculty_name','grad_year',DB::raw("sum(grad_count) as grad_count"))->groupBy('univ_id','faculty_name','grad_year')->get();

        $total = 0;
        foreach ( $pass_results as $rec ) {
            $total += $rec->grad_count;
        }
        $tmp = [];
        foreach ( $pass_results as $rec ) {
            $key = sprintf("%04d%04d",$rec->grad_count,$rec->univ_id);
            $tmp[$key] = $rec;
        }
        krsort($tmp);
        reset($tmp);
        $json = [];
        $others = (object) ['name' => 'その他','value' => 0,'percentage' => 0];
        foreach ( $tmp as $rec ) {
            $name = $rec->univ->name;
            if ( $rec->faculty_name != '不明' ) {
                $name .= '（' . $rec->faculty_name . '）';
            }
            if ( count($json) > 10 || $rec->grad_count / $total < 0.05 ) {
                $others->value += $rec->grad_count;
                $others->percentage = round($others->value / $total * 100,2);
            } else {
                $json[] = (object)['name' => $name,'value' => $rec->grad_count,'percentage' => round($rec->grad_count / $total * 100,2)];
            }
        }
        if ( $others->value ) {
            $json[] = $others;
        }
        return $json;
    }
}
