<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    //
    use HasFactory;

    protected $table = 'line';
    protected $primaryKey = 'id';
    protected $with = ['lineStations'];

    /**
     * Get the stations for the line.
     */
    public function lineStations()
    {
        return $this->hasMany(LineStations::class, 'line_id', 'id');
    }
}
