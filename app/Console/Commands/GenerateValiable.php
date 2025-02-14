<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use Symfony\Component\Yaml\Yaml;

class GenerateValiable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:valiable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $codes = [];
        foreach ( File::allFiles(resource_path('valiables')) as $file ) {
            if ( preg_match("/\.yml$/",$file) == 0 ) {
                continue;
            }
            $yml = Yaml::parse(File::get($file));

            foreach ( $yml as $base => $rec ) {
                foreach ( $rec as $name  => $rec2) {
                    $v_name = $base . '_' . $name;
                    $array = [];
                    foreach ( $rec2['value'] as $key => $value ) {
                        $array[] = "'" . $key . "' => '" . $value . "'";
                    }
                    $codes[] =  "'" . $v_name  . "'" . ' => ' . "[" . implode(",",$array) . "]";
	            print $v_name . PHP_EOL;
                }
            }
        }
        $output = implode("," . PHP_EOL,$codes);

        $valiable =  <<<__EOD__
<?php
namespace App;

class Valiable
{
    private \$valiables = [
$output
    ];

    private static \$instance;

    public static function getInstance()
    {
        if ( self::\$instance === null ) {
            self::\$instance = new self;
        }
        return self::\$instance;
    }

    public static function get(\$name)
    {
        \$obj = self::getInstance();
        return \$obj->valiables[\$name] ?? null;
    }

    public static function getValue(\$name,\$key)
    {
        \$obj = self::getInstance();
        \$data =  \$obj->valiables[\$name] ?? null;
        if ( is_null(\$data) === false ) {
            return \$data[\$key] ?? null;
        }
    }
}
__EOD__;

        File::put(base_path('app/Valiable.php'),$valiable);





        return Command::SUCCESS;
    }
}
