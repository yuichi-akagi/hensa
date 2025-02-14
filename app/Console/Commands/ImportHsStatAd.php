<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use App\Models\Hs;
use App\Models\HsStat;

class ImportHsStatAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hs_stat_ad {file} {year} {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $types = [
        '1' => '普通科',
        '2' => '理数科',
        '3' => '外国語科',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = explode("\n",File::get($this->argument('file')));
        $adm_year = $this->argument('year');
        $grad_year = $this->argument('year') + 3;
        $type = null;
        $base_col = 1;
        if ( $this->argument('type') ) {
            $type = $this->types[$this->argument('type')];
            $base_col = 0;
        } 
        
        foreach( $data as $rec2 ) {
            $rec2 = str_replace(" ","",$rec2);
            $rec = explode("\t",chop($rec2));
            if ( count($rec) < 2 ) {
                continue;
            }
            if ( $base_col == 1 ) {
                if ( chop($rec[0]) ) {
                    $type = chop($rec[0]) . '科';
                }
            }
            $school = $rec[$base_col];
            $recruit_count = $rec[$base_col + 2];
            $adm_count = $rec[$base_col + 2];

            $obj = Hs::where('name','=',$school)->orWhere('pattern','like','%/' . $school . '/%')->firstOrNew();
            if ( ! $obj->id ) {
                continue;
            }
            //print $obj->name . "\n";

            $obj2 = HsStat::firstOrCreate(
            [
                'hs_id' => $obj->id,
                'dept_type' => $type,
                'grad_year' => $grad_year,
                'adm_year' => $adm_year
            ],
            [
                'hs_id' => $obj->id,
                'dept_type' => $type,
                'grad_year' => $grad_year,
                'adm_year' => $adm_year
            ]
            );

            $obj2->adm_count = $adm_count;
            $obj2->recruit_count = $recruit_count;
            $obj2->save();
        }
        
    }
}
