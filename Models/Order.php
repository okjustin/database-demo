<?php

class Order {
    public $id;
    public $userId;
    public $date;
    public $total;

    public function __construct($userId, $date, $total) {
        $this->userId = $userId;
        $this->date = $date;
        $this->total = $total;
    }
}

?>