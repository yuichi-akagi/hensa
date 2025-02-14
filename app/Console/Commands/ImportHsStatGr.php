<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use App\Models\Hs;
use App\Models\HsStat;

class ImportHsStatGr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hs_stat_gr {file} {year}';

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
        $department_type = null;
        $school = null;
        $grad_year = $this->argument('year');
        $adm_year = $grad_year - 3;
        foreach( $data as $rec2 ) {
            $rec2 = str_replace(" ","",$rec2);
            $rec = explode("\t",chop($rec2));
            if ( count($rec) < 2 ) {
                continue;
            }

            $obj = Hs::where('name','=',$rec[0])->orWhere('pattern','like','%/' . $rec[0] . '/%')->firstOrNew();
            if ( ! $obj->id ) {
                continue;
            }
            $dept_name = chop($rec[1]);
            $obj2 = HsStat::firstOrCreate(
            [
                'hs_id' => $obj->id,
                'dept_type' => $dept_name,
                'grad_year' => $grad_year,
                'adm_year' => $adm_year
            ],
            [
                'hs_id' => $obj->id,
                'dept_type' => $dept_name,
                'grad_year' => $grad_year,
                'adm_year' => $adm_year
            ]
            );
            $obj2->grad_university_count = chop($rec[2]);
            $obj2->grad_count = chop($rec[3]);
            $obj2->save();
        

        }

    }
}
