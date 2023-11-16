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

        // Fetch subscribed authors from SOAP API
        $soapServerUrl = 'http://kinokuniya-soap-service:8001/api/subscribe?wsdl';
        
        // Set the subscriber ID as the user ID
        $subscriberId = $_SESSION['user_id'];

        // Set the API key
        $apiKey = "90d9b00a-5efc-4c4e-a53f-2be134a96df2";

        // Set the SOAP action
        $client = new SoapClient($soapServerUrl, array('cache_wsdl' => WSDL_CACHE_NONE));

        // Call the getAllAuthorBySubID method
        $subbedAuthors = array();
        try {
            $subbedAuthors = $client->__soapCall('getAllAuthorBySubID', array(
                'arg0' => $subscriberId,
                'arg1' => $apiKey,
            ));
        } catch (SoapFault $e) {
            $subbedAuthors = array();
        }
    
        // Filter authors to contain only authors that are not subscribed
        if (!empty($subbedAuthors)) {
            $authors = array_filter($authors, function ($author) use ($subbedAuthors) {
                foreach ($subbedAuthors as $subbedAuthor) {
                    if ($author['userID'] == $subbedAuthor['creatorID']) {
                        return false;
                    }
                }
                return true;
            });
        }

        $subsView = $this->view('subscription', 'SubscriptionView', [
            'isAdmin' => $isAdmin,
            'user_id' => $_SESSION['user_id'],
            'username' => $username,
            'authors' => $authors,
            'subbedAuthors' => $subbedAuthors
        ]);

        $subsView->render();
    }
}