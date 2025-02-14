<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnivStat extends Model
{
    protected $table = 'univ_stats';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    //
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
