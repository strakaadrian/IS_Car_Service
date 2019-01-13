<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    /**
     * z ktorej tabulky bude tahat data Services
     * @var string
     */
    protected $table = 'services';

    public $timestamps = false;

    /**
     * tato funkcia nam skontroluje ci zadany datum splna poziadavky / ci je aktualny a ci to nieje vikend
     * @param $date
     * @return array
     */
    public function checkDay($date) {
        return DB::select("select getDayName(?) as result",[$date]);

    }


}
