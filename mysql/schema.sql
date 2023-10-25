-- Create the User table
CREATE TABLE IF NOT EXISTS user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT CheckPasswordLength CHECK (CHAR_LENGTH(password) >= 8),
    CONSTRAINT CheckUsernameLength CHECK (CHAR_LENGTH(username) >= 5)
);

-- Create the Book table to store information about books
CREATE TABLE IF NOT EXISTS book (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    author VARCHAR(100) NOT NULL,
    category VARCHAR(255) NOT NULL,
    book_desc TEXT,
    price INT NOT NULL,
    publication_date DATE,
    cover_img_url VARCHAR(255),
    audio_url VARCHAR(255),
    CONSTRAINT CheckPositivePrice CHECK (price > 0)
);

-- Create the BookOwnership table to represent the relationship between users and books they own
CREATE TABLE IF NOT EXISTS book_ownership (
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    PRIMARY KEY (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES book(book_id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Create a table to store current cart items
CREATE TABLE IF NOT EXISTS cart (
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    PRIMARY KEY (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES book(book_id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- DUMMY DATA
-- Books
INSERT INTO book VALUES (
    DEFAULT,
    'Nebula',
    'Tere Liye',
    'Sci-Fi',
    'Nebula adalah novel fiksi ilmiah karya Tere Liye yang diterbitkan pada 2019 oleh Gramedia Pustaka Utama. Novel ini merupakan novel fiksi ilmiah pertama yang ditulis oleh Tere Liye.',
    200000,
    '2019-01-01',
    'http://localhost:8080/storage/book-img/nebula.svg',
    'http://localhost:8080/storage/audio/TOP-G.mp3'
);

INSERT INTO book VALUES (
    DEFAULT,
    'Klara and the Sun',
    'Kazuo Ishiguro',
    'Drama',
    "'Klara and the Sun' is a thought-provoking novel written by Kazuo Ishiguro. The story revolves around Klara, an Artificial Friend with remarkable observational capabilities. Klara's perspective is unique, as she observes the world from her place on a store shelf, carefully studying the lives of the people who pass by. 
    Set in a futuristic world where technology blurs the lines between humans and machines, the novel explores themes of love, consciousness, and the desire for companionship. Klara's journey leads her to Josie, a teenager suffering from an undisclosed illness, and together they form a deep and unique bond.
    As Klara navigates the complexities of human emotions and relationships, the novel delves into questions about the nature of consciousness, artificial intelligence, and the impact of technology on society. Kazuo Ishiguro's exquisite storytelling and exploration of human and artificial existence make 'Klara and the Sun' a compelling and contemplative read.",
    150000,
    '2021-03-02',
    'http://localhost:8080/storage/book-img/klara.svg',
    'http://localhost:8080/storage/audio/TOP-G.mp3'
);

INSERT INTO book VALUES (
    DEFAULT,
    'Rich People Problems',
    'Kevin Kwan',
    'Comedy',
    'Rich People Problems is a 2017 satirical romantic comedy novel by Kevin Kwan. It is the third and final novel in Kwans Crazy Rich trilogy that looks at the rich and powerful families of Singapore. The plot revolves around the three clans descending upon Shang Su Yis deathbed to attempt to be included in her will, as she is allegedly extremely wealthy.',
    200000,
    '2017-05-23',
    'http://localhost:8080/storage/book-img/rich-people-problem.svg',
    'http://localhost:8080/storage/audio/TOP-G.mp3'
);

INSERT INTO book
VALUES
    (DEFAULT, 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', 'A classic novel about racial injustice and moral growth in the American South.', 499000, '1960-07-11', 'http://localhost:8080/storage/book-img/to-kill-a-mockingbird.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, '1984', 'George Orwell', 'Dystopian', 'A dystopian novel about a totalitarian regime and government surveillance.', 1299000, '1949-06-08', 'http://localhost:8080/storage/book-img/1984.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Pride and Prejudice', 'Jane Austen', 'Romance', 'A classic romance novel revolving around Elizabeth Bennet and Mr. Darcy.', 1099000, '1813-01-28', 'http://localhost:8080/storage/book-img/pride-and-prejudice.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 'A story of decadence and excess in the Roaring Twenties.', 1199000, '1925-04-10', 'http://localhost:8080/storage/book-img/the-great-gatsby.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'To the Lighthouse', 'Virginia Woolf', 'Modernist', 'An experimental novel exploring the inner thoughts and emotions of characters.', 999000, '1927-05-05', 'http://localhost:8080/storage/book-img/to-the-lighthouse.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Moby-Dick', 'Herman Melville', 'Adventure', 'The epic tale of Captain Ahabs obsessive quest for the white whale.', 599000, '1851-10-18', 'http://localhost:8080/storage/book-img/moby-dick.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 'A high-fantasy epic featuring a hobbit, a wizard, and a powerful ring.', 1999000, '1954-07-29', 'http://localhost:8080/storage/book-img/the-lord-of-the-rings.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Brave New World', 'Aldous Huxley', 'Dystopian', 'A dystopian novel set in a future world of genetic engineering and social control.', 1299000, '1932-12-30', 'http://localhost:8080/storage/book-img/brave-new-world.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'The adventure of Bilbo Baggins as he joins a group of dwarves to reclaim their homeland.', 1099000, '1937-09-21', 'http://localhost:8080/storage/book-img/the-hobbit.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'War and Peace', 'Leo Tolstoy', 'Historical Fiction', 'A historical novel set during the Napoleonic era in Russia.', 699000, '1869-01-01', 'http://localhost:8080/storage/book-img/war-and-peace.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Psychological Thriller', 'A psychological thriller about a young student who commits a murder.', 399000, '1866-11-11', 'http://localhost:8080/storage/book-img/crime-and-punishment.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'The Odyssey', 'Homer', 'Epic Poetry', 'An ancient Greek epic poem about the adventures of Odysseus on his journey home.', 1199000, '0800-01-01', 'http://localhost:8080/storage/book-img/the-odyssey.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Letters from a Stoic', 'Seneca', 'Philosophy', 'A collection of moral letters offering Stoic wisdom and guidance.', 1299000, '0065-01-01', 'http://localhost:8080/storage/book-img/letters-from-a-stoic.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3'),
    (DEFAULT, 'Meditations', 'Marcus Aurelius', 'Philosophy', 'A series of personal writings by the Roman Emperor, reflecting on Stoic philosophy.', 1099000, '0161-01-01', 'http://localhost:8080/storage/book-img/meditations.svg', 'http://localhost:8080/storage/audio/TOP-G.mp3');
    
INSERT INTO user
VALUES
    (
        DEFAULT,
        'admin',
        '$2y$10$.Etq0AVKCwgFpI0UZWtOX.5ISSCmaP9LnZBcCv7LN5hoUcCfk4eyK',
        TRUE
    );