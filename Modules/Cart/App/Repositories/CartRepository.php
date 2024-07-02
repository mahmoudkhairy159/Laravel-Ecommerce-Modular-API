<?php

namespace Modules\Cart\App\Repositories;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Cart\App\Models\Cart;
use Modules\Cart\App\Models\CartItem;
use Modules\Cart\App\Models\Discount;
use Modules\Item\App\Models\Item;
use Prettus\Repository\Eloquent\BaseRepository;

class CartRepository extends BaseRepository
{
    public function model()
    {
        return Cart::class;
    }

    public function getAll()
    {
        return $this->model->with('items');
    }

    public function getCart()
    {
        $userId = Auth::guard('user-api')->id();
        return $this->getCartByUserId($userId);
    }

    public function getCartByUserId($userId)
    {
        return $this->model->firstOrCreate(['user_id' => $userId]);
    }

    public function updateUserCart($userId, $data)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCartByUserId($userId);
            $items = $data['items'];

            foreach ($items as $itemData) {
                $cartItem = CartItem::find($itemData['id']);
                $cartItem->update([
                    'quantity' => $itemData['quantity'],
                ]);
            }

            // $cart->total_price = $this->calculateTotalPrice($cart); // Recalculate total price
            $cart->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function addItem(array $data)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCart();
            $item = Item::findOrFail($data['item_id']);
            $cartItem = $cart->items()->where('item_id', $data['item_id'])->first();

            if ($cartItem) {
                $cartItem->quantity += $data['quantity'];
                $cartItem->save();
            } else {
                $cartItem = new CartItem([
                    'item_id' => $data['item_id'],
                    'quantity' => $data['quantity'],
                ]);
                $cart->items()->save($cartItem);
            }

            $cart->save();

            DB::commit();
            return $cartItem;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function removeItem($itemId)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCart();
            $cart->items()->where('id', $itemId)->delete();

            $cart->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
    public function emptyCart($cart_id)
    {
        try {
            DB::beginTransaction();
            $delted=CartItem::where('cart_id', $cart_id)->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    public function updateItemQuantity($itemId, array $data)
    {
        DB::beginTransaction();

        try {
            $cart = $this->getCart();
            $cartItem = $cart->items()->findOrFail($itemId);

            if ($cartItem) {
                $cartItem->quantity = $data['quantity'];
                $cartItem->save();
            }

            $cart->save();

            DB::commit();
            return $cartItem;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getItems()
    {
        $cart = $this->getCart();
        return $cart->items()->with('item');
    }



}
