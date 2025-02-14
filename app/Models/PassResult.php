<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassResult extends Model
{
    protected $table = 'pass_results';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function univ()
    {
        return $this->hasOne(Univ::class,'id','univ_id');
    }
}
