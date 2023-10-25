<?php

class UserController extends Controller implements ControllerInterface
{
    public function index()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    // Prevent Access except Admin
                    $authMiddleware = $this->middleware('AuthenticationMiddleware');
                    try {
                        $authMiddleware->isAdmin();
                    } catch (Exception $e) {
                        header('Location: ' . BASE_URL);
                        exit;
                    }

                    $userModel = $this->model('UserModel');
                    $allusers = $userModel->getUsersWithBookCount();

                    // For navbar, get info if user is admin
                    $isAdmin = $userModel->isAdmin($_SESSION['user_id']);

                    $userListView = $this->view('user', 'UserListView', ['users' => $allusers, 'isAdmin' => $isAdmin]);
                    $userListView->render();
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                /* Unauthorized */
                $notFoundView = $this->view('not-found', 'NotFoundView');
                $notFoundView->render();
            }
            http_response_code($e->getCode());
            exit;
        }
    }

    public function fetch($page)
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $userModel = $this->model('UserModel');
                    $res = $userModel->getUsers((int) $page);

                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode($res);
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
        }
    }

    public function login()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    // Open middleware for authentication
                    $auth = $this->middleware('AuthenticationMiddleware');

                    try {
                        $auth->isAuthenticated();

                        // Redirect to home page if already logged in
                        header('Location: ' . BASE_URL . '/home');
                        exit;
                    } catch (Exception $e) {
                        // Else, render login page
                        $loginView = $this->view('user', 'LoginView');
                        $loginView->render();
                        exit;
                    }

                case 'POST':

                    $userModel = $this->model('UserModel');
                    $userId = $userModel->login($_POST['username'], $_POST['password']);
                    $_SESSION['user_id'] = $userId;

                    // Set the redirect_url
                    $redirect_url = BASE_URL . "/home";

                    // If user is admin, redirect to admin page
                    if ($userModel->isAdmin($userId)) {
                        $redirect_url = BASE_URL . "/catalogue/control";
                    }

                    // Return redirect_url
                    header('Content-Type: application/json');
                    http_response_code(201);
                    echo json_encode(["redirect_url" => $redirect_url]);
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
        }
    }

    public function logout()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':

                    unset($_SESSION['user_id']);

                    // Return redirect_url
                    header('Content-Type: application/json');
                    http_response_code(201);
                    echo json_encode(["redirect_url" => BASE_URL . "/user/login"]);
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
        }
    }

    public function register()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    // Redirect to home page if already logged in
                    if (isset($_SESSION['user_id'])) {
                        header('Location: ' . BASE_URL . '/home');
                        exit;
                    }

                    $registerView = $this->view('user', 'RegisterView');
                    $registerView->render();
                    exit;

                case 'POST':

                    $userModel = $this->model('UserModel');
                    $userModel->register($_POST['username'], $_POST['password']);

                    // Return redirect_url
                    header('Content-Type: application/json');
                    http_response_code(201);
                    echo json_encode(["redirect_url" => BASE_URL . "/user/login"]);
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }

    public function username()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    $userModel = $this->model('UserModel');
                    $user = $userModel->doesUsernameExist($_GET['username']);

                    if (!$user) {
                        throw new LoggedException('Not Found', 404);
                    }

                    http_response_code(400);
                    exit;

                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
        }
    }

    public function edit()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':

                    $authMiddleware = $this->middleware('AuthenticationMiddleware');
                    try {
                        $authMiddleware->isAdmin();
                    } catch (Exception $e) {
                        header('Location: ' . BASE_URL);
                        exit;
                    }

                    $editUserView = $this->view('user', 'EditUserView');
                    $editUserView->render();

                    break;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }

    public function update()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':

                    $userModel = $this->model('UserModel');
                    $userModel->updateUserData($_POST['user_id'], $_POST['username'], $_POST['password']);

                    // Return redirect_url
                    header('Content-Type: application/json');
                    http_response_code(201);
                    echo json_encode(["redirect_url" => BASE_URL . "/settings"]);

                    break;
                default:
                    throw new LoggedException('Method Not Allowed', 405);
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
        }
    }
    public function deleteUser($userId) {
        try {
            $userModel = $this->model('UserModel');
            $userModel->deleteUserById($userId);
    
            // Send a success response
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Handle the error
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
}
