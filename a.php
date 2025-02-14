<?php

require_once('vendor/autoload.php');

use Illuminate\Filesystem\Filesystem;




//out('./a1.txt');
out('./a2.txt');

function out($file) {
$fs = new Filesystem;
$data = explode("\n",$fs->get($file));
$school = null;
foreach ( $data as $rec2 ) {
    $rec2 = str_replace(" ","",$rec2);
    $rec = explode("\t",chop($rec2));
    if ( count($rec) < 2 ) {
        continue;
    }
    if ( $rec[0] ) {
        $school = $rec[0];
    }
    if ( $rec[1] == '現役' ) {
        print $school . "\t" .$rec[2] . "\n";
    }
print_r($rec);

}
}

//print_r($data);

