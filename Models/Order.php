<?php

class Order {
    public $id;
    public $userId;
    public $totalPrice;
    public $date;

    public function __construct($userId, $totalPrice, $date) {
        $this->userId = $userId;
        $this->totalPrice = $totalPrice;
        $this->date = $date;
    }
}

?>