<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Home Page</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/home/home.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/home/home.js" defer></script>
</head>
<body>
    <div id="root">
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <section class="hero-section">
                    <form role="search" id="input-form">
                        <input type="search" id="query" class="search-input" name="q" placeholder="Search books or authors..." aria-label="Search through site content" autocomplete="off">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <div class="hero-banner">
                        <div class="hero-welcome">
                            <h1 class="hero-header"><span style="color: #F18912">Broaden your Horizon</span> with our Extensive Collection of Books</h1>
                            <p class="hero-desc">Embark on a journey of knowledge and discovery with our vast array of literary works. Whether you're a student looking to excel in your studies, an educator seeking valuable resources, or a lifelong learner eager to expand your horizons, our carefully curated selection has something for everyone.</p>
                            <div class="hero-btn">
                                <a href="/public/catalogue">
                                    <button class="btn-standard" id="explore-btn">Explore More</button>
                                </a>
                            </div>
                        </div>
                        <img id="hero-image" src="<?= BASE_URL ?>/images/vectors/hero.svg" alt="Hero Image">
                    </div>
                </section>
                <section class="dashboard-section">

                    <?php
                        $newestReleases = $this->data['newestReleases'];

                        // Check if there are books to display
                        if (!empty($newestReleases)) {
                            echo '<div>';
                            echo '<div class="card-header">';
                            echo '<h4 class="card-header-desc">Newest Releases</h4>';
                            echo '<a href="/public/catalogue">';
                            echo '<p class="see-all">See All</p>';
                            echo '</a>';
                            echo '</div>';
                            echo '<div class="card-grid">';

                            foreach ($newestReleases as $book) {
                                echo '<div class="book-card">';
                                echo '<div class="book-card-container">';
                                echo '<img class="book-img" src="' . $book->cover_img_url . '" alt="Book Image">';
                                echo '<div class="book-card-desc">';
                                echo '<h4 class="book-card-title">' . $book->title . '</h4>';
                                echo '<p class="book-card-author">by ' . $book->author . '</p>';
                                $shortDesc = (strlen($book->book_desc) > 230) ? substr($book->book_desc, 0, 230) . '...' : $book->book_desc;
                                echo '<p class="book-card-summary">' . $shortDesc . '</p>';
                                echo '<a href="/public/catalogue/preview/?book_id=' . $book->book_id . '"><p class="read-more">Read More</p></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }
                    ?>

                    <?php
                        $ownedBooks = $this->data['ownedBooks'];

                        // Check if there are owned books to display
                        if (!empty($ownedBooks)) {
                            echo '<div>';
                            echo '<div class="card-header">';
                            echo '<h4 class="card-header-desc">Owned Books</h4>';
                            echo '<a href="/public/mybooks">';
                            echo '<p class="see-all">See All</p>';
                            echo '</a>';
                            echo '</div>';
                            echo '<div class="card-grid-pagination">';

                            foreach ($ownedBooks as $book) {
                                echo '<div class="book-card-brief">';
                                echo '<a href="/public/catalogue/preview/?book_id=' . $book->book_id . '">';
                                echo '<img class="book-img-brief" src="' . $book->cover_img_url . '" alt="Book Image">';
                                echo '</a>';
                                echo '<div class="book-card-brief-desc">';
                                echo '<h4 class="book-card-title">' . $book->title . '</h4>';
                                echo '<p class="book-card-author">by ' . $book->author . '</p>';
                                echo '<p class="book-card-price">Rp ' . number_format($book->price, 0, ',', '.') . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                        }
                    ?>

                </section>
            </div>
        </main>
    </div>
</body>
</html>