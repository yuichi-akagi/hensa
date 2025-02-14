<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use File;
use App\Models\Univ;
use App\Models\UnivStat;

class ImportUniv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:univ {file} {kind} {year} {year2?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $kinds = [
        '1' => '私立',
        '2' => '国公立',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = explode("\n",File::get($this->argument('file')));
        $grad_year = $this->argument('year');
        if ( $this->argument('year2') ) {
            $grad_ss_year = $this->argument('year2');
        } else {
            $grad_ss_year = $grad_year;
        }
        if ( $this->argument('kind') ) {
            $kinds = $this->kinds[$this->argument('kind')];
        } 
        foreach( $data as $rec2 ) {
            $rec2 = str_replace(" ","",$rec2);
            $rec = explode("\t",chop($rec2));
            if ( count($rec) < 2 ) {
                continue;
            }
            $name = $rec[0];
            $obj = Univ::firstOrCreate(
            [
                'name' => $name,
            ],
            [
                'name' => $name,
                'kinds' => $kinds,
            ]);
            $obj->save();
            $obj2 = UnivStat::firstOrCreate(
            [
                'univ_id' => $obj->id,
                'faculty_name' => chop($rec[1]),
                'grad_year' => $grad_year,
            ],
            [
                'hs_id' => $obj->id,
                'faculty_name' => chop($rec[1]),
                'grad_year' => $grad_year,
            ]
            );
            $obj2->grad_ss_year = $grad_ss_year;
            $obj2->grad_ss = $rec[2];
            $obj2->save();
        }
        
        
    }
}
