<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * z ktorej tabulky bude tahat data Services
     * @var string
     */
    protected $table = 'services';
}
