<?php

namespace App;

use App\Customer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * vrati mi ci je prihlaseny user zaroven zakaznikom
     */
    public function isCustomer() {
        return Customer::where('user_id', Auth::user()->id)->exists();
    }

    /**
     *
     * Funkcia, ktorá zistí ču užívatel je adminom
     *
     * @return mixed
     *
     */
    public function isAdmin() {
        if(Auth::guest()) {
            return false;
        } else {
            return UserRole::where([
                ['user_id', Auth::user()->id],
                ['role_id', 1]])->exists();
        }
    }

    /**
     * Super admin spravuje vsetky firmy
     *
     * @return bool
     */
    public function isSuperAdmin() {
        if(Auth::guest()) {
            return false;
        } else {
            return UserRole::where([
                ['user_id', Auth::user()->id],
                ['role_id', 2]])->exists();
        }
    }

    /**
     * CI je super admin aj skladníkom
     *
     * @return bool
     */
    public function isWareHouse() {
        if(Auth::guest()) {
            return false;
        } else {
            return UserRole::where([
                ['user_id', Auth::user()->id],
                ['role_id', 3]])->exists();
        }
    }

    /**
     * CI je super admin aj správca služieb
     *
     * @return bool
     */
    public function isServiceAdmin() {
        if(Auth::guest()) {
            return false;
        } else {
            return UserRole::where([
                ['user_id', Auth::user()->id],
                ['role_id', 4]])->exists();
        }
    }

}
