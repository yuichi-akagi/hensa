<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\HsStat;
use App\Models\UnivStat;
use App\Models\PassResult;

class CalcHsStatGradSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:hs_stat_grad_ss {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year');
        $hs_stats = HsStat::where('grad_year','=',$year)->get();
        foreach ( $hs_stats as $hs_stat ) {
            if ( ! $hs_stat->grad_count ) {
                continue;
            }
            $pass_results = PassResult::where('grad_year','=',$year)->where('hs_id','=',$hs_stat->hs_id)->where('dept_type','=',$hs_stat->dept_type)->where('result','=','進学')->get();
            if ( count($pass_results) == 0 ) {
                continue;
            }
            $ss = 0;
            $grad_ss_year = null;
            $count = 0;
            foreach ( $pass_results as $rec ) {
                $univ_stat = UnivStat::where('grad_year','=',$year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
                if ( ! $univ_stat ) {
                    continue;
                }
                $ss += $univ_stat->grad_ss * $rec->grad_count;
                $count += $rec->grad_count;
                $grad_ss_year = $univ_stat->grad_ss_year;
            }
            if ( $count != $hs_stat->grad_university_count ) {
                $ss += 45 * ($hs_stat->grad_university_count - $count);
            }
            if ( $hs_stat->grad_count - $hs_stat->grad_university_count  > 0 ) {
                $ss += 45 * ($hs_stat->grad_count - $hs_stat->grad_university_count);

            }
            $hs_stat->grad_ss = ($ss / $hs_stat->grad_count);
            $hs_stat->grad_ss_year = $grad_ss_year;
            $hs_stat->save();
        }
        foreach ( $hs_stats as $hs_stat ) {
            if ( ! $hs_stat->grad_count ) {
                continue;
            }
            $pass_results = PassResult::where('grad_year','=',$year)->where('hs_id','=',$hs_stat->hs_id)->where('dept_type','=',$hs_stat->dept_type)->whereIn('result',['合格','現役合格','浪人合格'])->get();
            if ( count($pass_results) == 0 ) {
                continue;
            }
print_r($pass_results);
            $pass_ss = 0;
            $pass_ss_year = null;
            $count = 0;
            foreach ( $pass_results as $rec ) {
                $univ_stat = UnivStat::where('grad_year','=',$year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
                if ( ! $univ_stat ) {
                    continue;
                }
                if ( $rec->result == '合格' ) {
                    $pass_ss += $univ_stat->grad_ss * $rec->grad_count * 0.9;
                } elseif ( $rec->result == '現役合格' ) {
                    $pass_ss += $univ_stat->grad_ss * $rec->grad_count;
                } elseif ( $rec->result == '浪人合格' ) {
                    $pass_ss += $univ_stat->grad_ss * $rec->grad_count * 0.8;
                }
                $count += $rec->grad_count;
                $pass_ss_year = $univ_stat->grad_ss_year;
            }
            $hs_stat->pass_ss = ($pass_ss / $count);
            $hs_stat->pass_ss_year = $grad_ss_year;
            $hs_stat->save();
        }
        //
    }
}
