<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineStations extends Model
{
    //
    use HasFactory;

    protected $table = 'line_stations';
    protected $primaryKey = 'id';

// LineStation model
    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
