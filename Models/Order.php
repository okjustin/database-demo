<?php

class Order {
    public $id;
    public $userId;
    public $date;
    public $total;

    public function __construct($id, $userId, $date, $total) {
        $this->id = $id;
        $this->userId = $userId;
        $this->date = $date;
        $this->total = $total;
    }
}

?>