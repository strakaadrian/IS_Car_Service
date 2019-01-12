<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * taha data z tabulky Customer
     * @var string
     */
    protected $table = 'customer';

    public $timestamps = false;
}
