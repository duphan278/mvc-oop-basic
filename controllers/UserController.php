<?php
class UserController
{
    public $product;

    public function __construct()
    {
        $this->product = new Watch();
    }

    public function home()
    {
        $products = $this->product->getAll();
        require_once PATH_ROOT . '/views/user/index.php';
    }
}
