<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>View Book</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/toast.css">

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/catalogue/bookview.css">

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
    </script>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/lib/debounce.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/toast.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/catalogue/bookview.js" defer></script>
</head>
<body>
    <div id="root">
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <div class="book-preview-section">
                    <div class="book-info">
                        <?php
                            $bookData = $this->data['bookData'];
                            
                            echo '<div id="book-id-hidden" hidden>' . $bookData->book_id . '</div>';
                            echo '<img src="' . $bookData->cover_img_url . '" alt="Book Cover" class="book-cover">';
                            echo '<div class="book-info-text">';
                            echo '<p class="book-category">' . $bookData->category . '</p>';
                            echo '<h1 class="book-title">' . $bookData->title . '</h1>';
                            echo '<h2 class="book-author">by ' . $bookData->author . '</h2>';
                            echo '</div>';
                        ?>
                    </div>
                    <div class="book-buttons-container">
                        <div class="book-buttons">
                            <button class="icon-btn" id="add-to-cart">
                                <i class="bx bx-cart"></i>
                                <span>Add to Cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="line">
                    <hr>
                </div>
                <div class="summary-section">
                    <h2 class="summary-title">Summary</h2>
                    <p class="summary-text">
                        <?php
                            echo $bookData->book_desc;
                        ?>
                    </p>
                </div>
                <?php include(dirname(__DIR__) . '/template/toast.php') ?>
            </div>
        </main>
    </div>
</body>
<html>