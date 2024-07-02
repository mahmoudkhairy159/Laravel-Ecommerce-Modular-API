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

class UpdateOrderService
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
    public function updateOrder(array $data, Order $order)
    {
        DB::beginTransaction();

        try {

            if (isset($data['items'])) {
                $this->orderItemRepository->deleteByOrderId($order->id);
                foreach ($data['items'] as $itemData) {
                    $this->orderItemRepository->create([
                        'order_id' => $order->id,
                        'item_id' => $itemData['item_id'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                    ]);
                }
            }
            $this->orderRepository->calculateTotalPrice($order);
            $updated=$this->orderRepository->update($data,$order->id);
            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
