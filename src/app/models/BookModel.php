<?php

class BookModel
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getBookByID($book_id)
    {
        $query = 'SELECT book_id, title, author, category, book_desc, price, publication_date, cover_img_url, audio_url FROM book WHERE book_id = :book_id LIMIT 1';

        $this->database->query($query);
        $this->database->bind('book_id', $book_id);

        $book = $this->database->fetch();

        return $book;
    }

    public function getBooks($page)
    {
        $query = 'SELECT book_id, title, author, category, book_desc, price, publication_date, cover_img_url, audio_url FROM book LIMIT :limit OFFSET :offset';

        $this->database->query($query);
        $this->database->bind('limit', ROWS_PER_PAGE);
        $this->database->bind('offset', ($page - 1) * ROWS_PER_PAGE);
        $books = $this->database->fetchAll();

        $query = 'SELECT CEIL(COUNT(book_id) / :rows_per_page) AS page_count FROM book';

        $this->database->query($query);
        $this->database->bind('rows_per_page', ROWS_PER_PAGE);
        $book = $this->database->fetch();
        $pageCount = $book->page_count;

        $returnArr = ['books' => $books, 'pages' => $pageCount];
        return $returnArr;
    }

    public function getBooksByCategory($category, $page)
    {
        $query = 'SELECT title, author, category, book_desc, price, publication_date, cover_img_url, audio_url FROM book WHERE category = :category LIMIT :limit OFFSET :offset';

        $this->database->query($query);
        $this->database->bind('category', $category);
        $this->database->bind('limit', ROWS_PER_PAGE);
        $this->database->bind('offset', ($page - 1) * ROWS_PER_PAGE);
        $books = $this->database->fetchAll();

        $query = 'SELECT CEIL(COUNT(book_id) / :rows_per_page) AS page_count FROM book WHERE category = :category';

        $this->database->query($query);
        $this->database->bind('category', $category);
        $this->database->bind('rows_per_page', ROWS_PER_PAGE);
        $book = $this->database->fetch();
        $pageCount = $book->page_count;

        $returnArr = ['books' => $books, 'pages' => $pageCount];
        return $returnArr;
    }

    public function getBooksByQuery($q, $page, $category, $priceRange, $sortBy)
    {
        // Prepare conditions for category and price
        $categoryCondition = '';
        if ($category !== "All Categories") {
            $categoryCondition = "category = :category";
        }

        $priceCondition = '';
        if ($priceRange == "< Rp500K") {
            $priceCondition = "price < 500000";
        } elseif ($priceRange == "Rp500K-Rp1M") {
            $priceCondition = "price BETWEEN 500000 AND 1000000";
        } elseif ($priceRange == "> Rp1M") {
            $priceCondition = "price > 1000000";
        }

        // Prepare the sort by parameter
        $sort = 'publication_date DESC';
        if ($sortBy == "Newest First") {
            $sort = "publication_date DESC";
        } elseif ($sortBy == "Oldest First") {
            $sort = "publication_date ASC";
        } elseif ($sortBy == "Price: Low to High") {
            $sort = "price ASC";
        } elseif ($sortBy == "Price: High to Low") {
            $sort = "price DESC";
        }

        // Prepare the SQL query
        $query = 'SELECT book_id, title, author, category, book_desc, price, publication_date, cover_img_url, audio_url FROM book 
            WHERE (title LIKE :q OR author LIKE :q) 
            ' . ($categoryCondition ? 'AND ' . $categoryCondition : '') . '
            ' . ($priceCondition ? 'AND ' . $priceCondition : '') . '
            ORDER BY ' . $sort . ' LIMIT :limit OFFSET :offset';

        $this->database->query($query);
        $this->database->bind('q', '%' . $q . '%');
        
        // Bind category parameter if it's not empty
        if ($categoryCondition) {
            $this->database->bind('category', $category);
        }

        $this->database->bind('limit', ROWS_PER_PAGE);
        $this->database->bind('offset', ($page - 1) * ROWS_PER_PAGE);
        
        $books = $this->database->fetchAll();

        // Count the total number of pages
        $countQuery = 'SELECT CEIL(COUNT(book_id) / :rows_per_page) AS page_count 
            FROM book 
            WHERE (title LIKE :q OR author LIKE :q) 
            ' . ($categoryCondition ? 'AND ' . $categoryCondition : '') . '
            ' . ($priceCondition ? 'AND ' . $priceCondition : '');

        $this->database->query($countQuery);
        $this->database->bind('q', '%' . $q . '%');
        
        // Bind category parameter if it's not empty
        if ($categoryCondition) {
            $this->database->bind('category', $category);
        }

        $this->database->bind('rows_per_page', ROWS_PER_PAGE);
        $book = $this->database->fetch();
        $pageCount = $book->page_count;

        $returnArr = ['books' => $books, 'pages' => $pageCount];
        return $returnArr;
    }

    public function getOwnedBooksByQuery($q, $page, $category, $priceRange, $sortBy, $user_id)
    {
        // Prepare conditions for category and price
        $categoryCondition = '';
        if ($category !== "All Categories") {
            $categoryCondition = "category = :category";
        }

        $priceCondition = '';
        if ($priceRange == "< Rp500K") {
            $priceCondition = "price < 500000";
        } elseif ($priceRange == "Rp500K-Rp1M") {
            $priceCondition = "price BETWEEN 500000 AND 1000000";
        } elseif ($priceRange == "> Rp1M") {
            $priceCondition = "price > 1000000";
        }

        // Prepare the sort by parameter
        $sort = 'publication_date DESC';
        if ($sortBy == "Newest First") {
            $sort = "publication_date DESC";
        } elseif ($sortBy == "Oldest First") {
            $sort = "publication_date ASC";
        } elseif ($sortBy == "Price: Low to High") {
            $sort = "price ASC";
        } elseif ($sortBy == "Price: High to Low") {
            $sort = "price DESC";
        }

        // Fetch only user owned books
        $query = 'SELECT b.book_id, b.title, b.author, b.category, b.book_desc, b.price, b.publication_date, b.cover_img_url, b.audio_url
                FROM book AS b
                INNER JOIN book_ownership AS bo ON b.book_id = bo.book_id
                WHERE (b.title LIKE :q OR b.author LIKE :q) AND bo.user_id = :user_id 
                ' . ($categoryCondition ? 'AND ' . $categoryCondition : '') . '
                ' . ($priceCondition ? 'AND ' . $priceCondition : '') . '
                ORDER BY ' . $sort . ' LIMIT :limit OFFSET :offset';

        // Bind the search query parameter
        $this->database->query($query);
        $this->database->bind('q', '%' . $q . '%');
        
        // Bind category parameter if it's not empty
        if ($categoryCondition) {
            $this->database->bind('category', $category);
        }

        $this->database->bind('user_id', $user_id);
        $this->database->bind('limit', ROWS_PER_PAGE);
        $this->database->bind('offset', ($page - 1) * ROWS_PER_PAGE);

        // Execute the query
        $books = $this->database->fetchAll();

        // Calculate the total number of pages
        $countQuery = 'SELECT CEIL(COUNT(b.book_id) / :rows_per_page) AS page_count 
                    FROM book AS b
                    INNER JOIN book_ownership AS bo ON b.book_id = bo.book_id
                    WHERE (b.title LIKE :q OR b.author LIKE :q) AND bo.user_id = :user_id
                    ' . ($categoryCondition ? 'AND ' . $categoryCondition : '') . '
                    ' . ($priceCondition ? 'AND ' . $priceCondition : '');

        // Bind the search query parameter
        $this->database->query($countQuery);
        $this->database->bind('q', '%' . $q . '%');

        // Bind category parameter if it's not empty
        if ($categoryCondition) {
            $this->database->bind('category', $category);
        }

        $this->database->bind('user_id', $user_id);
        $this->database->bind('rows_per_page', ROWS_PER_PAGE);

        // Execute the query
        $book = $this->database->fetch();
        $pageCount = $book->page_count;

        // Create the return array
        $returnArr = ['books' => $books, 'pages' => $pageCount];
        return $returnArr;
    }

    public function getNewestReleases()
    {
        // Construct the SQL query to fetch the newest releases
        $query = 'SELECT book_id, title, author, category, book_desc, price, publication_date, cover_img_url, audio_url 
                FROM book 
                ORDER BY publication_date DESC 
                LIMIT 5';

        // Execute the query
        $this->database->query($query);
        $newestReleases = $this->database->fetchAll();

        // Return the result
        return $newestReleases;
    }

    public function getOwnedBooksByUserId($userId, $page, $rowsPerPage = ROWS_PER_PAGE)
    {
        // Construct the SQL query to fetch owned books for a user
        $query = 'SELECT b.book_id, b.title, b.author, b.category, b.book_desc, b.price, b.publication_date, b.cover_img_url, b.audio_url
                FROM book AS b
                INNER JOIN book_ownership AS bo ON b.book_id = bo.book_id
                WHERE bo.user_id = :user_id
                LIMIT :limit OFFSET :offset';

        // Bind the parameters
        $this->database->query($query);
        $this->database->bind('user_id', $userId);
        $this->database->bind('limit', $rowsPerPage);
        $this->database->bind('offset', ($page - 1) * $rowsPerPage);

        // Execute the query
        $ownedBooks = $this->database->fetchAll();

        // Count the total number of pages
        $countQuery = 'SELECT CEIL(COUNT(b.book_id) / :rows_per_page) AS page_count 
                    FROM book AS b
                    INNER JOIN book_ownership AS bo ON b.book_id = bo.book_id
                    WHERE bo.user_id = :user_id';

        // Bind the parameters
        $this->database->query($countQuery);
        $this->database->bind('user_id', $userId);
        $this->database->bind('rows_per_page', $rowsPerPage);

        // Execute the query
        $book = $this->database->fetch();
        $pageCount = $book->page_count;

        // Create the return array
        $returnArr = ['books' => $ownedBooks, 'pages' => $pageCount];
        return $returnArr;
    }

    public function getBookCategories()
    {
        // Construct the SQL query to fetch all book categories
        $query = 'SELECT DISTINCT category FROM book';

        // Execute the query
        $this->database->query($query);
        $categories = $this->database->fetchAll();

        // Return the result
        return $categories;
    }

    public function isOwnedByID($book_id, $user_id)
    {
        // Construct the SQL query to check if a book is owned by a user
        $query = 'SELECT COUNT(*) AS count FROM book_ownership WHERE book_id = :book_id AND user_id = :user_id';

        // Bind the parameters
        $this->database->query($query);
        $this->database->bind('book_id', $book_id);
        $this->database->bind('user_id', $user_id);

        // Execute the query
        $result = $this->database->fetch();

        // Return the result
        return $result->count > 0;
    }

    public function getBooksInCart($user_id)
    {
        // Construct the SQL query to fetch books in a user's cart
        $query = 'SELECT b.book_id, b.title, b.author, b.price, b.cover_img_url
                FROM book AS b
                INNER JOIN cart AS c ON b.book_id = c.book_id
                WHERE c.user_id = :user_id';

        // Bind the user_id parameter
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);

        // Execute the query
        $cartBooks = $this->database->fetchAll();

        // Return the result
        return $cartBooks;
    }

    public function buyBooks($user_id, $book_ids)
    {
        // Construct the SQL query to buy books
        $query = 'INSERT INTO book_ownership (user_id, book_id) VALUES ';

        // Construct the query parameters
        $params = [];
        foreach ($book_ids as $book_id) {
            $params[] = '(:user_id, ' . $book_id . ')';
        }

        // Join the query parameters
        $query .= implode(', ', $params);

        // Bind the user_id parameter
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);

        // Execute the query
        $this->database->execute();
    }

    public function isInCart($user_id, $book_id)
    {
        // Construct the SQL query to check if a book is in a user's cart
        $query = 'SELECT COUNT(*) AS count FROM cart WHERE user_id = :user_id AND book_id = :book_id';

        // Bind the parameters
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);
        $this->database->bind('book_id', $book_id);

        // Execute the query
        $result = $this->database->fetch();

        // Return the result
        return $result->count > 0;
    }

    public function addToCart($user_id, $book_id)
    {
        // Construct the SQL query to add a book to a user's cart
        $query = 'INSERT INTO cart (user_id, book_id) VALUES (:user_id, :book_id)';

        // Bind the parameters
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);
        $this->database->bind('book_id', $book_id);

        // Execute the query
        $this->database->execute();
    }

    public function flushCart($user_id)
    {
        // Construct the SQL query to flush a user's cart
        $query = 'DELETE FROM cart WHERE user_id = :user_id';

        // Bind the user_id parameter
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);

        // Execute the query
        $this->database->execute();
    }

    public function removeFromCart($user_id, $book_id)
    {
        // Construct the SQL query to remove a book from a user's cart
        $query = 'DELETE FROM cart WHERE user_id = :user_id AND book_id = :book_id';

        // Bind the parameters
        $this->database->query($query);
        $this->database->bind('user_id', $user_id);
        $this->database->bind('book_id', $book_id);

        // Execute the query
        $this->database->execute();
    }
    public function getAllBooks() 
    {
        $query = 'SELECT * FROM book';
        $this->database->query($query);
        return $this->database->fetchAll();
    }

    public function editBook($book_id, $title, $author, $category, $book_desc, $price, $publication_date, $cover_img_url, $audio_url)
    {
        $query = 'UPDATE book SET title = :title, author = :author, category = :category, book_desc = :book_desc, price = :price, publication_date = :publication_date, cover_img_url = :cover_img_url, audio_url = :audio_url WHERE book_id = :book_id';
        $this->database->query($query);
        $this->database->bind('book_id', $book_id);
        $this->database->bind('title', $title);
        $this->database->bind('author', $author);
        $this->database->bind('category', $category);
        $this->database->bind('book_desc', $book_desc);
        $this->database->bind('price', $price);
        $this->database->bind('publication_date', $publication_date);
        $this->database->bind('cover_img_url', $cover_img_url);
        $this->database->bind('audio_url', $audio_url);
        $this->database->execute();
    
    }
    
    public function addBook($title, $author, $category, $book_desc, $price, $publication_date, $cover_img_url, $audio_url)
    {
        $query = 'INSERT INTO book (book_id, title, author, category, book_desc, price, publication_date, cover_img_url, audio_url) VALUES (DEFAULT, :title, :author, :category, :book_desc, :price, :publication_date, :cover_img_url, :audio_url)';
        $this->database->query($query);
        $this->database->bind('title', $title);
        $this->database->bind('author', $author);
        $this->database->bind('category', $category);
        $this->database->bind('book_desc', $book_desc);
        $this->database->bind('price', $price);
        $this->database->bind('publication_date', $publication_date);
        $this->database->bind('cover_img_url', $cover_img_url);
        $this->database->bind('audio_url', $audio_url);
        $this->database->execute();
    }

    public function doesTitleExist($title)
    {
        $query = 'SELECT COUNT(*) AS count FROM book WHERE title = :title';
        $this->database->query($query);
        $this->database->bind('title', $title);
        $result = $this->database->fetch();
        return $result->count > 0;
    }
}

