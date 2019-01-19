<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $table = 'shopping_cart';


    /**
     *
     * Funkcia, ktorá nám dotiahne obsah kosika pre daného usera
     *
     * @return mixed
     */
    public function getCartContentByUserId() {
        $result = Cart::where('user_id', Auth::user()->id)
                        ->join('car_parts','car_parts.car_part_id', '=', 'shopping_cart.car_part_id')
                        ->select('car_parts.car_part_id', 'car_parts.part_name', 'car_parts.part_price', 'car_parts.stock', 'car_parts.image', 'shopping_cart.quantity')
                        ->get();
        return $result;
    }

    /**
     *
     * Funkcia, ktorá pridá alebo updatuje hodnoty v košíku
     *
     * @param $car_part_id
     * @param $quantity
     * @return array
     */
    public function insertDataToShoppingCart($car_part_id, $quantity) {
        return DB::select("call create_shopping_cart(?, ?, ?)",[Auth::user()->id, $car_part_id, $quantity]);
    }

    /**
     * Funkcia vymaže z košíka dany produkt
     *
     * @param $car_part_id
     * @return array
     */
    public function deleteItemFromShoppingCart($car_part_id) {
        return DB::select("call delete_from_shopping_cart(?, ?)",[Auth::user()->id, $car_part_id]);
    }

}
