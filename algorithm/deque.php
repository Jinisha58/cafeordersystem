<?php
class Deque {
    private $items = [];
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->loadOrdersFromDB();
    }

    private function loadOrdersFromDB() {
        $query = "SELECT * FROM orders WHERE status = 'pending' ORDER BY order_time ASC";
        $result = $this->conn->query($query);
        while ($order = $result->fetch_assoc()) {
            $this->items[] = $order;
        }
    }

    public function addFront($order) {
        array_unshift($this->items, $order);
    }

    public function addBack($order) {
        array_push($this->items, $order);
    }

    public function removeFront() {
        return array_shift($this->items);
    }

    public function removeBack() {
        return array_pop($this->items);
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function getOrders() {
        return $this->items;
    }

    public function size() {
        return count($this->items);
    }

    public function completeOrder($orderId) {
        $query = "UPDATE orders SET status = 'completed' WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $stmt->close();
    }
}
?>
