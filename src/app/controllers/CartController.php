<?php

class CartController extends Controller implements ControllerInterface
{
    public function index()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    // Open middleware for authentication
                    $auth = $this->middleware('AuthenticationMiddleware');

                    // Redirect to Login Page if not logged in
                    try {
                        $auth->isAuthenticated();
                    } catch (Exception $e) {
                        header('Location: ' . BASE_URL . '/user/login');
                        exit;
                    }

                    // For navbar, get info if user is admin
                    $userModel = $this->model('UserModel');
                    $isAdmin = $userModel->isAdmin($_SESSION['user_id']);
                    
                    // Render the cart page
                    $bookModel = $this->model('BookModel');

                    $cartBooks = $bookModel->getBooksInCart($_SESSION['user_id']);

                    if ($cartBooks == null || empty($cartBooks)) {
                        $cartBooks = [];
                    }

                    $cartView = $this->view('cart', 'CartView', ['cartBooks' => $cartBooks, 'isAdmin' => $isAdmin]);
                    $cartView->render();

                    break;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }

    public function remove()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':

                    $bookModel = $this->model('BookModel');

                    // Takes raw data from the request
                    $json = file_get_contents('php://input');

                    // Converts it into a PHP object
                    $data = json_decode($json);

                    // Remove the book from the cart
                    $bookModel->removeFromCart($_SESSION['user_id'], $data->book_id);

                    http_response_code(204);
                    exit;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }

    public function buy()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':

                    $bookModel = $this->model('BookModel');

                    // Takes raw data from the request
                    $json = file_get_contents('php://input');

                    // Converts it into a PHP object
                    $data = json_decode($json);

                    // Check if the cart is empty
                    if (empty($data->book_ids)) {
                        throw new LoggedException('Cart is empty', 400);
                    }

                    // Buy the books
                    $bookModel->buyBooks($_SESSION['user_id'], $data->book_ids);

                    // Flush the cart contents
                    $bookModel->flushCart($_SESSION['user_id']);

                    header('Content-Type: application/json');

                    // Redirect to owned books page
                    http_response_code(200);
                    echo json_encode(['redirect_url' => BASE_URL . '/mybooks']);
                    exit;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }
    
}
