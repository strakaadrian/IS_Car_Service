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
     * Funkcia, ktorá updatuje hodnoty v košíku
     *
     * @param $car_part_id
     * @param $quantity
     * @return array
     */
    public function updateShoppingCart($car_part_id, $quantity) {
        return DB::select("call update_shopping_cart(?, ?, ?)",[Auth::user()->id, $car_part_id, $quantity]);
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

    /**
     * Funkcia, ktorá pridá veci do košíka
     *
     * @return array
     */
    public function insertDataToShoppingCart($car_part_id, $quantity) {
        return DB::select("call add_to_shopping_cart(?, ?, ?)",[Auth::user()->id, $car_part_id, $quantity]);
    }

    /**
     * Funkcia, ktorá zoberie veci z košíka, vytvorí objednávku a pridá ich do order_items
     *
     * @return array
     */
    public function confirmItemsInCart($order_id) {
        if($order_id == "") {
            return DB::select("call confirm_shopping_cart(?, ?)",[Auth::user()->id,null]);
        } else {
            return DB::select("call confirm_shopping_cart(?, ?)",[Auth::user()->id,$order_id]);
        }
    }
}
