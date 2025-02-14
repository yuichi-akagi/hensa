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
            $pass_results = PassResult::where('grad_year','=',$year)->where('hs_id','=',$hs_stat->hs_id)->where('dept_type','=',$hs_stat->dept_type)->get();
            if ( count($pass_results) == 0 ) {
                continue;
            }
            $ss = 0;
            $grad_ss_year = null;
            foreach ( $pass_results as $rec ) {
                $univ_stat = UnivStat::where('grad_year','=',$year)->where('faculty_name','=',$rec->faculty_name)->where('univ_id','=',$rec->univ_id)->first();
                if ( ! $univ_stat ) {
                    continue;
                }
                $ss += $univ_stat->grad_ss * $rec->grad_count;
                $grad_ss_year = $univ_stat->grad_ss_year;
            }
            if ( $hs_stat->grad_count - $hs_stat->grad_university_count  > 0 ) {
                $ss += 45 * ($hs_stat->grad_count - $hs_stat->grad_university_count);

            }
            $hs_stat->grad_ss = ($ss / $hs_stat->grad_count);
            $hs_stat->grad_ss_year = $grad_ss_year;
            $hs_stat->save();
            

        }
        //
    }
}
