<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * Funkcia, ktorá zoberie všetky položky z košíka, pre daného užívatela a vypíše ich
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $shopping_cart = new Cart;
        $parts = $shopping_cart->getCartContentByUserId();
        $forPayment = 0;

        foreach ($parts as $part) {
            $forPayment += $part->quantity * $part->part_price;
        }

        return view('Customer/Cart/cart', compact('parts','forPayment'));
    }

    /**
     * Funkcia, ktorá updatuje košík
     *
     * @param Request $request
     */
    public function updateDataInShoppingCart(Request $request) {
        $shopping_cart = new Cart;
        $shopping_cart->updateShoppingCart($request->car_part_id, $request->quantity);
    }

    /**
     * Funkcia, ktorá vymaže dáta z košíka
     *
     * @param Request $request
     */
    public function deleteItemFromCart(Request $request) {
        $shopping_cart = new Cart;
        $shopping_cart->deleteItemFromShoppingCart($request->car_part_id);
    }

    /**
     * Funkcia, ktorá pridá daný item do košíku
     * @param Request $request
     */
    public function addItemToShoppingCart(Request $request) {
        $shopping_cart = new Cart;
        $shopping_cart->insertDataToShoppingCart($request->car_part_id, $request->quantity);
    }

    /**
     *Funkcia, ktorá potvrdí obsah nákupného košika
     */
    public function confirmShoppingCart(Request $request) {
        $shopping_cart = new Cart;
        $shopping_cart->confirmItemsInCart($request->order_id);
    }
}
