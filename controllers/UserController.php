<?php
class UserController
{
    public $product;
    public $category;

    public function __construct()
    {
        $this->product = new Watch();
        $this->category = new Category();
    }

    public function home()
    {
        $view = $_GET['view'] ?? 'home';

        switch ($view) {
            case 'products':
                return $this->products();
            case 'brands':
                return $this->brands();
            case 'contact':
                return $this->contact();
            case 'cart':
                return $this->cart();
            default:
                $products = $this->product->getAll();
                $brands = $this->category->getAll();
                require_once PATH_ROOT . '/views/user/index.php';
                break;
        }
    }

    public function products()
    {
        $category_id = $_GET['id'] ?? null;
        if ($category_id) {
            $products = $this->product->getByCategory($category_id);
        } else {
            $products = $this->product->getAll();
        }
        require_once PATH_ROOT . '/views/user/products.php';
    }

    public function brands()
    {
        $brands = $this->category->getAll();
        require_once PATH_ROOT . '/views/user/brands.php';
    }

    public function contact()
    {
        require_once PATH_ROOT . '/views/user/contact.php';
    }

    public function detail($id)
    {
        $product = $this->product->find($id);
        require_once PATH_ROOT . '/views/user/detail.php';
    }

    public function addToCart($id)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if ($id <= 0) {
            header('Location: ' . BASE_URL . '?controller=user&action=products');
            exit;
        }

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = 1;
        } else {
            $_SESSION['cart'][$id]++;
        }

        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function removeCartItem($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASE_URL . '?controller=user&action=cart');
        exit;
    }

    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $cartItems = $this->product->getByIds($productIds);

            foreach ($cartItems as &$item) {
                $item['quantity'] = $cart[$item['id']];
                $item['subtotal'] = $item['quantity'] * $item['price'];
                $total += $item['subtotal'];
            }
            unset($item);
        }

        require_once PATH_ROOT . '/views/user/cart.php';
    }

    public function productsByCategory($category_id)
    {
        $products = $this->product->getByCategory($category_id);
        require_once PATH_ROOT . '/views/user/products.php';
    }
}
