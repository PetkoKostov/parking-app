<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    public $timestamps = false;

    protected $table = 'parking';

    protected $guarded = ['id'];

    public static  $categorySpots = ['A' => 1, 'B' => 2, 'C' => 4];

    public static $cards = ['silver' => 10, 'gold' => 15, 'platinum' => 20];

    public static $maxSpots = 200;

    public static $tariffHoursDaily = ['from' => '08:00', 'to' => '18:00']; // the rest are nightly

    public static $prices = [
        'A' => ['daily' => 3, 'nightly'=> 2],
        'B' => ['daily' => 6, 'nightly'=> 4],
        'C' => ['daily' => 12, 'nightly'=> 8],
    ];

    public function getSpotsAttribute()
    {
        return self::$categorySpots[$this->category];
    }
}
