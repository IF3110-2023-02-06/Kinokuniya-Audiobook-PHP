<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Add Book</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/toast.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/popup.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/catalogue/addbook.css">

    <!-- JavaScript Constant and Variables -->
    <script type="text/javascript" defer>
        const DEBOUNCE_TIMEOUT = "<?= DEBOUNCE_TIMEOUT ?>";
    </script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/lib/debounce.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/toast.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/catalogue/addbook.js" defer></script>
</head>
<body>
    <div id="root">
        <div id="user-id-hidden" hidden><?= $this->data['user_id'] ?></div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <section class="add-book-section">
                    <form id="add-book-form" method="post" autocomplete="on" action="/public/catalogue/add" enctype="multipart/form-data">
                        <h2 class="add-book-header">Book Title</h2>
                        <div class="error-message" id="title-error"></div>
                        <input class="add-book-input" type="text" id="title" name="title" placeholder="Enter book title..." autocomplete="off">
                        <h2 class="add-book-header">Author</h2>
                        <div class="error-message" id="author-error"></div>
                        <input class="add-book-input" type="text" id="author" name="author" placeholder="Enter book author..." autocomplete="off">
                        <h2 class="add-book-header">Category</h2>
                        <div class="error-message" id="category-error"></div>
                        <input class="add-book-input" type="text" id="category" name="category" placeholder="Enter book category..." autocomplete="off">
                        <h2 class="add-book-header">Publication Date</h2>
                        <div class="error-message" id="publication-date-error"></div>
                        <input class="add-book-input" type="date" id="publication-date" name="publication-date">
                        <h2 class="add-book-header">Price</h2>
                        <div class="error-message" id="price-error"></div>
                        <input class="add-book-input" type="number" id="price" name="price" step="1000" min="0" placeholder="Enter book price..." autocomplete="off">
                        <h2 class="add-book-header">Summary</h2>
                        <div class="error-message" id="summary-error"></div>
                        <textarea class="add-book-textarea" id="summary" name="summary" placeholder="Enter book summary..."></textarea>
                        <h2 class="add-book-header">Upload Book Cover</h2>
                        <div class="error-message" id="cover-error"></div>
                        <input class="add-book-file" type="file" id="cover" name="cover" accept="image/png, image/jpeg, .svg">
                        <h2 class="add-book-header">Upload Audiobook</h2>
                        <div class="error-message" id="audio-error"></div>
                        <input class="add-book-file" type="file" id="audio" name="audio" accept="audio/mpeg">
                        <div class="error-message" id="save-error"></div>
                        <div class="popupButtons">
                            <button id="save-info-btn" class="btn-standard save-info-button">Save</button>
                        </div>
                    </form>
                </section>
                <?php include(dirname(__DIR__) . '/template/toast.php') ?>
            </div>
            <div class="overlay" id="overlay">
                <div class="confirmationPopup" id="confirmationPopup">
                    <div class="popupContent">
                        <h2 class="popupTitle">Confirm Addition</h2>
                        <p class="popupConfirmText">Save this book?</p>
                        <div class="popupButtons">
                            <button class="btn-standard" id="cancelButton">Cancel</button>
                            <button class="btn-standard" id="confirmButton">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>