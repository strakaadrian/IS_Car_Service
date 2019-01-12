<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $table = 'town';

    public $timestamps = false;

    /**
     * funkcia ktora nam vrati ci mesto s danym ID existuje
     */
    public function existTown($psc) {
        return Town::where('town_id', $psc)->exists();
    }
}
