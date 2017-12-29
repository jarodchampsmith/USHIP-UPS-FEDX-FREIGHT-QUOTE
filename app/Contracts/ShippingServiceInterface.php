<?php

namespace App\Contracts;

interface ShippingServiceInterface {
    public function getRule($count);
    public function returnData($data);
    public function call($data);
}
