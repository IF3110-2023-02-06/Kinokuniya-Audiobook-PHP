<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Catalogue</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/pagination.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- JavaScript Constant and Variables -->
    <script type="text/javascript" defer>
        const DEBOUNCE_TIMEOUT = "<?= DEBOUNCE_TIMEOUT ?>";
        const ROWS_PER_PAGE = "<?= ROWS_PER_PAGE ?>";
    </script>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/lib/debounce.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/search.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/pagination.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/catalogue/catalogue.js" defer></script>
</head>
<body>
    <div id="root">
        <div id="page-name-hidden" hidden>catalogue</div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <div class="search-panel">
                    <form role="search" id="input-form">
                        <input type="search" id="query" class="search-input" name="q" placeholder="Search books or authors..." aria-label="Search through site content" autocomplete="off">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div class="select-menu" id="category-menu">
                        <div class="select-btn">
                            <span class="select-btn-text">All Categories</span>
                            <i class="bx bx-chevron-down"></i>
                        </div>
                        <div class="options">
                            <div class="category-search">
                                <input type="search" id="category-query" class="search-input" name="q" placeholder="Search..." aria-label="Search through categories" autocomplete="off">
                            </div>
                            <ul id="category-options">
                                <?php
                                    $categories = $this->data['bookCategories'];

                                    echo "<li class='option'>";
                                    echo "<span class='option-text'>All Categories</span>";
                                    echo "</li>";

                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            echo "<li class='option'>";
                                            echo "<span class='option-text'>" . $category->category . "</span>";
                                            echo "</li>";
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="select-menu" id="price-menu">
                        <div class="select-btn">
                            <span class="select-btn-text">All Prices</span>
                            <i class="bx bx-chevron-down"></i>
                        </div>
                        <div class="options">
                            <ul id="price-options">
                                <li class="option">
                                    <span class="option-text">All Prices</span>
                                </li>
                                <li class="option">
                                    <span class="option-text">< Rp500K</span>
                                </li>
                                <li class="option">
                                    <span class="option-text">Rp500K-Rp1M</span>
                                </li>
                                <li class="option">
                                    <span class="option-text">> Rp1M</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="select-menu" id="sort-menu">
                        <div class="select-btn">
                            <span class="select-btn-text" id="sort-text">Newest First</span>
                            <i class="bx bx-sort-alt-2"></i>
                        </div>
                        <ul class="options" id="sort-options">
                            <li class="option">
                                <span class="option-text">Newest First</span>
                            </li>
                            <li class="option">
                                <span class="option-text">Oldest First</span>
                            </li>
                            <li class="option">
                                <span class="option-text">Price: Low to High</span>
                            </li>
                            <li class="option">
                                <span class="option-text">Price: High to Low</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <section class="books-section">
                    <div class="card-grid-pagination" id="book-list">
                    <?php if (!empty($this->data['books'])) : ?>
                        <?php foreach ($this->data['books'] as $book) : ?>
                            <div class="book-card-brief">
                                <a href="<?= BASE_URL ?>/catalogue/preview/?book_id=<?= $book->book_id ?>">
                                    <img class="book-img-brief" src="<?= $book->cover_img_url ?>" alt="Book Image">
                                </a>
                                <div class="book-card-brief-desc">
                                    <h4 class="book-card-title"><?= $book->title ?></h4>
                                    <p class="book-card-author">by <?= $book->author ?></p>
                                    <p class="book-card-price">Rp <?= number_format($book->price, 0, ',', '.') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class='no-book-text'>No books yet...</p>
                    <?php endif; ?>
                    </div>
                    <?php if (!empty($this->data['books']) && $this->data['pages'] > 1) : ?>
                        <div class="pagination-panel">
                            <div class="pagination-container">
                                <button class="pagination-button" id="startBtn" disabled>
                                    <i class="bx bx-chevrons-left"></i>
                                </button>
                                <button class="pagination-button prevNext" id="prev" disabled>
                                    <i class="bx bx-chevron-left"></i>
                                </button>
                                <div class="pagination-links">
                                    <?php for ($i = 1; $i <= $this->data['pages']; $i++) : ?>
                                        <a class="p-link <?= $i == 1 ? 'active' : '' ?>"><?= $i ?></a>
                                    <?php endfor; ?>
                                </div>
                                <button class="pagination-button prevNext" id="next">
                                    <i class="bx bx-chevron-right"></i>
                                </button>
                                <button class="pagination-button" id="endBtn">
                                    <i class="bx bx-chevrons-right"></i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
</body>
<html>