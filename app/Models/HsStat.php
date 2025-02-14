<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HsStat extends Model
{
    protected $table = 'hs_stats';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function hs()
    {
        return $this->hasOne(Hs::class,'id','hs_id');
    }
}
