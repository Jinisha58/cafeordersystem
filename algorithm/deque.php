<?php
class Deque {

    private $items = [];

    public function addFront($item) {
        array_unshift($this->items, $item);
    }

    public function addRear($item) {
        $this->items[] = $item;
    }

    public function removeFront() {
        return array_shift($this->items);
    }

    public function removeRear() {
        return array_pop($this->items);
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function size() {
        return count($this->items);
    }

    public function getItems() {
        return $this->items;
    }
}

class Order {
    public $order_id;
    public $customer_name;
    public $items = [];

    public function __construct($order_id,
        $customer_name,
        $item_name, $quantity) {
        $this->order_id = $order_id;
        $this->customer_name = $customer_name;
        $this->items[] = [
            'item_name' => $item_name,
            'quantity' => $quantity
        ];
    }
}
?>
