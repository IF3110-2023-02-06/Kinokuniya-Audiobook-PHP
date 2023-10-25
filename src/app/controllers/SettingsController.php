<?php

class SettingsController extends Controller implements ControllerInterface
{
    public function index()
    {

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
        $user = $userModel->getUserFromID($_SESSION['user_id']);
        $isAdmin = $user->is_admin;
        $username = $user->username;

        $settingsView = $this->view('settings', 'SettingsView', [
            'isAdmin' => $isAdmin,
            'user_id' => $_SESSION['user_id'],
            'username' => $username
        ]);
        $settingsView->render();
    }
}