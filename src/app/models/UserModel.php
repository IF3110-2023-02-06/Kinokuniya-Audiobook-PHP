<?php

class UserModel
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getUserFromID($user_id)
    {
        $query = 'SELECT username, is_admin FROM user WHERE user_id = :user_id LIMIT 1';

        $this->database->query($query);
        $this->database->bind('user_id', $user_id);

        $user = $this->database->fetch();

        return $user;
    }

    public function getUsers($page)
    {
        $query = 'SELECT username, is_admin FROM user LIMIT :limit OFFSET :offset';

        $this->database->query($query);
        $this->database->bind('limit', ROWS_PER_PAGE);
        $this->database->bind('offset', ($page - 1) * ROWS_PER_PAGE);
        $users = $this->database->fetchAll();

        $query = 'SELECT CEIL(COUNT(user_id) / :rows_per_page) AS page_count FROM user';

        $this->database->query($query);
        $this->database->bind('rows_per_page', ROWS_PER_PAGE);
        $user = $this->database->fetch();
        $pageCount = $user->page_count;

        $returnArr = ['users' => $users, 'pages' => $pageCount];
        return $returnArr;
    }

    public function login($username, $password)
    {
        $query = 'SELECT user_id, password FROM user WHERE username = :username LIMIT 1';

        $this->database->query($query);
        $this->database->bind('username', $username);

        $user = $this->database->fetch();

        if ($user && password_verify($password, $user->password)) {
            return $user->user_id;
        } else {
            throw new LoggedException('Unauthorized', 401);
        }
    }

    public function register($username, $password)
    {
        $query = 'INSERT INTO user (username, password, is_admin) VALUES (:username, :password, :is_admin)';
        $options = [
            'cost' => BCRYPT_COST
        ];

        $this->database->query($query);
        $this->database->bind('username', $username);
        $this->database->bind('password', password_hash($password, PASSWORD_BCRYPT, $options));
        $this->database->bind('is_admin', false);

        $this->database->execute();
    }

    public function doesUsernameExist($username)
    {
        $query = 'SELECT username FROM user WHERE username = :username LIMIT 1';

        $this->database->query($query);
        $this->database->bind('username', $username);

        $user = $this->database->fetch();

        return $user;
    }
    
    public function getUsersWithBookCount()
    {
        $query = 'SELECT u.user_id, u.username, COUNT(bo.book_id) as books_owned 
                FROM user u 
                LEFT JOIN book_ownership bo ON u.user_id = bo.user_id 
                WHERE u.is_admin = 0 
                GROUP BY u.user_id, u.username';

        $this->database->query($query);
        $users = $this->database->fetchAll();

        return $users;
    }


    public function isAdmin($user_id)
    {
        $query = 'SELECT is_admin FROM user WHERE user_id = :user_id LIMIT 1';

        $this->database->query($query);
        $this->database->bind('user_id', $user_id);

        $user = $this->database->fetch();

        return $user->is_admin;
    }

    public function updateUserData($user_id, $username, $password)
    {
        $query = 'UPDATE user SET username = :username, password = :password WHERE user_id = :user_id';

        $options = [
            'cost' => BCRYPT_COST
        ];

        $this->database->query($query);
        $this->database->bind('user_id', $user_id);
        $this->database->bind('username', $username);
        $this->database->bind('password', password_hash($password, PASSWORD_BCRYPT, $options));

        $this->database->execute();
    }
    public function deleteUserById($userId) {
        $query = 'DELETE FROM user WHERE user_id = :user_id';
        $this->database->query($query);
        $this->database->bind('user_id', $userId);
        $this->database->execute();
    }
    
}
