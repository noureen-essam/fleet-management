<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    //
    protected $table = 'bookings';
    protected $primaryKey = 'id';



    public function startLineStation()
    {
        return $this->belongsTo(LineStations::class, 'start_station_line_id');

    }

    public function endLineStation()
    {
        return $this->belongsTo(LineStations::class, 'end_station_line_id');
    }
}
