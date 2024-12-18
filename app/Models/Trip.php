<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    use HasFactory;

    protected $table = 'trip';
    protected $primaryKey = 'id';

    protected $with = ['bus'];


    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
