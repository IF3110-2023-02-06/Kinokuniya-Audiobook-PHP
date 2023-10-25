<?php

class HomeController extends Controller implements ControllerInterface
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

                    // Open connection to Book Model
                    $bookModel = $this->model('BookModel');

                    // Get newest releases from Book Model
                    $newestReleases = $bookModel->getNewestReleases();

                    // Get owned books from Book Model
                    $res = $bookModel->getOwnedBooksByUserId($_SESSION['user_id'], 1, 6); // Exclusive to home page
                    $ownedBooks = $res['books'];
                    $pages = $res['pages'];

                    $homeView = $this->view('home', 'MainView', [
                        'newestReleases' => $newestReleases,
                        'ownedBooks' => $ownedBooks,
                        'pages' => $pages,
                        'isAdmin' => $isAdmin
                    ]);
                    
                    $homeView->render();

                    break;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }
    
}
