<?php

namespace Modules\Order\App\Services;

use Modules\Order\App\Models\Order;
use Modules\Cart\App\Models\Cart;
use Modules\Cart\App\Models\CartItem;
use Modules\Order\App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\App\Repositories\CartRepository;
use Modules\Order\App\Repositories\OrderItemRepository;
use Modules\Order\App\Repositories\OrderRepository;

class PurchaseOrderService
{
    protected $orderRepository;
    protected $cartRepository;
    protected $orderItemRepository;



    public function __construct(OrderRepository $orderRepository, CartRepository $cartRepository, OrderItemRepository $orderItemRepository)
    {


        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->orderItemRepository = $orderItemRepository;
    }
    public function purchaseOrder(array $data)
    {
        DB::beginTransaction();

        try {
            // Get the current user's cart
            $cart = $this->cartRepository->getCartByUserId($data['user_id']);
            $cartItems = $cart->items;
            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }
            // Calculate total price
            $data['total_price'] = $cartItems->sum(function ($cartItem) {
                return $cartItem->quantity * $cartItem->item->price;
            });
            $data['order_date'] = Carbon::now();

            // Create a new order
            $order = $this->orderRepository->create($data);

            // Move items from cart to order
            foreach ($cartItems as $cartItem) {
                $this->orderItemRepository->create([
                    'order_id' => $order->id,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->item->price,
                ]);
            }

            // Empty the cart
            $deleted = $this->cartRepository->emptyCart($cart->id);
            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
