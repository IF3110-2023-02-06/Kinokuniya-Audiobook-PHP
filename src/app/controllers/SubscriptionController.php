<?php

class SubscriptionController extends Controller implements ControllerInterface
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

        // Fetch premium authors from REST API
        $apiEndpoint = 'http://api-kino-rest-service:3000/api/authors';
        $curl = curl_init($apiEndpoint);

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session
        $response = curl_exec($curl);

        // Check for cURL errors
        if ($response === false) {
            die('Error fetching data from the API: ' . curl_error($curl));
        }

        // Check HTTP status code
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            die('HTTP error ' . $httpCode . ': ' . $response);
        }

        // Close cURL session
        curl_close($curl);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if decoding was successful
        if ($data === null) {
            die('Error decoding JSON.');
        }

        // Access the data array in the response
        $authors = $data['data'];

        // TODO: Separate the subscribed authors from the rest of the authors

        $subsView = $this->view('subscription', 'SubscriptionView', [
            'isAdmin' => $isAdmin,
            'user_id' => $_SESSION['user_id'],
            'username' => $username,
            'authors' => $authors
        ]);

        $subsView->render();
    }
}