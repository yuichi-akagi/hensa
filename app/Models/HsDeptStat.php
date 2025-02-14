<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsDeptStat extends Model
{
    //
    protected $table = 'hs_dept_stats';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

}
