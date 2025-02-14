<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Hs as ModelHs;
use File;
use App\Valiable;

class ImportHs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hs {file}';

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
        $prefectures = Valiable::get('parameter_001');
        foreach ( $data as $rec ) {
            $list = explode("\t",$rec);
            if ( count($list) > 4 ) {
                $obj = ModelHs::where('name','=',$list[0])->firstOrNew();
                if  ( ! $obj->id ) {
                    $obj->name = $list[0];
                }
                $obj->kinds = $list[1];
                $obj->gender = $list[2];
                $obj->address = $list[3];
                $obj->is_integrated = 0;
                if ( preg_match("/中高一貫/",$list[4]) ) {
                    $obj->is_integrated = 1;
                }
                $obj->pattern = '/' . implode("/",explode(",",$list[5])) . '/';
                foreach ( $prefectures as $key => $pref ) {
                    if ( preg_match("/^" . $pref . "/",$obj->address ) ) {
                        $obj->prefecture = $key;
                    }
                }
                $obj->save();
            }
        }
    }
}
