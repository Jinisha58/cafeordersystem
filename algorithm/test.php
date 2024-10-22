<?php
class Order {
    public $order_id;
    public $customer_name;
    public $items;
    public $arrival_time;

    public function __construct($order_id, $customer_name, $items, $arrival_time) {
        $this->order_id = $order_id;
        $this->customer_name = $customer_name;
        $this->items = $items;
        $this->arrival_time = $arrival_time;
    }
}

function generateOrders($num_orders) {
    $orders = [];
    for ($i = 0; $i < $num_orders; $i++) {
        // Simulate random order data
        $order_id = $i + 1;
        $customer_name = "Customer " . $order_id;
        $items = ["Item " . rand(1, 5)]; // Simulate items (1-5)
        $arrival_time = time() + rand(0, 30); // Random arrival time in the next 30 seconds

        $orders[] = new Order($order_id, $customer_name, $items, $arrival_time);
    }
    return $orders;
}

function processOrders($orders) {
    // Sort orders by arrival time (first-come, first-served)
    usort($orders, function ($a, $b) {
        return $a->arrival_time - $b->arrival_time;
    });

    $processing_results = [];
    foreach ($orders as $order) {
        // Simulate order processing time (e.g., 5 seconds)
        sleep(5); // This simulates the processing delay

        $completion_time = date("H:i:s", time());
        $processing_results[] = [
            'order_id' => $order->order_id,
            'customer_name' => $order->customer_name,
            'completion_time' => $completion_time,
            'items' => implode(", ", $order->items)
        ];
    }
    return $processing_results;
}

// Simulate generating and processing orders
$orders = generateOrders(10); // Generate 10 random orders
$results = processOrders($orders);

// Display processing results
foreach ($results as $result) {
    echo "Order ID: {$result['order_id']} | Customer: {$result['customer_name']} | Items: {$result['items']} | Completed At: {$result['completion_time']}<br>";
}
?>
