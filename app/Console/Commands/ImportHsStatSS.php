<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use App\Models\Hs;
use App\Models\HsStat;
use App\Models\HsDeptStat;


class ImportHsStatSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hs_stat_ss {file} {year} {ss_year}';

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
        $data = explode("\n",File::get($this->argument('file')));
        $adm_year = $this->argument('year');
        $grad_year = $this->argument('year') + 3;
        $adm_ss_year = $this->argument('ss_year');
        
        foreach( $data as $rec2 ) {
            $rec2 = str_replace(" ","",$rec2);
            if ( strpos($rec2,"\t") === false ) {
                continue;
            }
            list($hs_name,$dept_type,$dept_name,$ss) = explode("\t",chop($rec2));

            $hs = Hs::where('name','=',$hs_name)->first();
            if ( ! $hs ) {
                print "[" . $hs_name . "] is not found.\n";
                continue;
            }
            if ( $dept_name ) {
                $obj = HsDeptStat::firstOrCreate([
                    'hs_id' => $hs->id,
                    'dept_type' => $dept_type,
                    'dept_name' => $dept_name,
                    'adm_year' => $adm_year,
                ],[
                    'hs_id' => $hs->id,
                    'dept_type' => $dept_type,
                    'dept_name' => $dept_name,
                    'adm_year' => $adm_year,
                ]);
                $obj->adm_ss_year = $adm_ss_year;
                $obj->adm_ss = $ss;
                $obj->save();
            } else {
                $obj = HsStat::firstOrCreate([
                    'hs_id' => $hs->id,
                    'dept_type' => $dept_type,
                    'adm_year' => $adm_year,
                    'grad_year' => $grad_year,
                ],[
                    'hs_id' => $hs->id,
                    'dept_type' => $dept_type,
                    'adm_year' => $adm_year,
                    'grad_year' => $grad_year,
                ]);
                $obj->adm_ss_year = $adm_ss_year;
                $obj->adm_ss = $ss;
                $obj->save();
            }
        }
    }
}
