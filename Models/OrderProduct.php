<?php

class OrderProduct {
    public $id;
    public $orderId;
    public $productId;
    public $quantity;
    public $productName;
    public $productPrice;

    public function __construct($orderId, $productId, $quantity) {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}

?>