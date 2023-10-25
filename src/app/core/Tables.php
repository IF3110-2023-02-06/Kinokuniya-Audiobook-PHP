<?php

class Tables {
    public const USER_TABLE = "
        CREATE TABLE IF NOT EXISTS user (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            is_admin BOOLEAN NOT NULL DEFAULT FALSE,
            CONSTRAINT CheckPasswordLength CHECK (CHAR_LENGTH(password) >= 8),
            CONSTRAINT CheckUsernameLength CHECK (CHAR_LENGTH(username) >= 5)
        );
    ";

    public const BOOK_TABLE = "
        CREATE TABLE IF NOT EXISTS book (
            book_id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL UNIQUE,
            author VARCHAR(100) NOT NULL,
            category VARCHAR(255) NOT NULL,
            book_desc TEXT,
            price DECIMAL(10, 2) NOT NULL,
            publication_date DATE,
            cover_img_url VARCHAR(255),
            audio_url VARCHAR(255),
            CONSTRAINT CheckPositivePrice CHECK (price > 0)
        );
    ";

    public const BOOK_OWNERSHIP_TABLE = "
        CREATE TABLE IF NOT EXISTS book_ownership (
            user_id INT NOT NULL,
            book_id INT NOT NULL,
            PRIMARY KEY (user_id, book_id),
            FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (book_id) REFERENCES book(book_id) ON UPDATE CASCADE ON DELETE CASCADE
        );
    ";

    public const CART_TABLE = "
        CREATE TABLE IF NOT EXISTS cart (
            user_id INT NOT NULL,
            book_id INT NOT NULL,
            PRIMARY KEY (user_id, book_id),
            FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
            FOREIGN KEY (book_id) REFERENCES book(book_id) ON UPDATE CASCADE ON DELETE CASCADE
        );
    ";
}