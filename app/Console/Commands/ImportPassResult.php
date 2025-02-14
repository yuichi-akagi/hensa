<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use File;
use App\Models\Hs;
use App\Models\Univ;
use App\Models\PassResult;

class ImportPassResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pass_result {file}';

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
        foreach( $data as $rec2 ) {
            $rec2 = str_replace(" ","",$rec2);
            //高校  学科    学科    大学    学部    年  実績    数
            if ( strpos($rec2,"\t") === false ) {
                continue;
            }
            list($hs_name,$dept_type,$dept_name,$univ_name,$f_name,$year,$result,$num) = explode("\t",chop($rec2));
            if ( ! $num ) {
                continue;
            }
            $hs = Hs::where('name','=',$hs_name)->first();
            if ( ! $hs ) {
                print "[" . $hs_name . "] is not found.\n";
                continue;
            }
            $univ = Univ::where('name','=',$univ_name)->first();
            if ( ! $univ ) {
                print "[" . $univ_name . "] is not found.\n";
                continue;
            }
            $obj = PassResult::firstOrCreate([
                'hs_id' => $hs->id,
                'dept_type' => $dept_type,
                'dept_name' => $dept_name,
                'univ_id' => $univ->id,
                'faculty_name' => $f_name,
                'grad_year' => $year,
                'result' => $result,
            ],[
                'hs_id' => $hs->id,
                'dept_type' => $dept_type,
                'dept_name' => $dept_name,
                'univ_id' => $univ->id,
                'faculty_name' => $f_name,
                'grad_year' => $year,
                'result' => $result,
            ]);
            $obj->grad_count = $num;
            $obj->save();
        }
    }
}
