<?php

class OrderProduct {
    public $id;
    public $orderId;
    public $productId;
    public $quantity;

    public function __construct($orderId, $productId, $quantity) {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}

?>