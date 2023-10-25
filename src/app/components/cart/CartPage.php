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
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/toast.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/popup.css">

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/cart/cart.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/toast.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/cart/cart.js" defer></script>
</head>
<body>
    <div id="root">
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <section class="cart-section">
                    <div class="payment-container">
                        <div class="card-grid-pagination">
                            <?php if (!empty($this->data['cartBooks'])) : ?>
                                <?php foreach ($this->data['cartBooks'] as $book) : ?>
                                    <div class="book-card-brief">
                                        <a class="remove-btn">
                                            <i class="bx bx-x" id="remove-book"></i>
                                        </a>
                                        <!-- Hidden book_id -->
                                        <div class="book-id-hidden" hidden><?= $book->book_id ?></div>
                                        <img class="book-img-brief" src="<?= $book->cover_img_url ?>" alt="Book Image">
                                        <div class="book-card-brief-desc">
                                            <h4 class="book-card-title"><?= $book->title ?></h4>
                                            <p class="book-card-author">by <?= $book->author ?></p>
                                            <p class="book-card-price">Rp<?= $book->price ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class='no-book-text'>Cart is empty...</p>
                            <?php endif; ?>
                        </div>
                        <div class="payment-checkout">
                            <div class="payment-checkout-header">
                                <h3 class="payment-checkout-title">Billing Summary</h3>
                            </div>
                            <div class="payment-checkout-body">
                                <div class="payment-checkout-item">
                                    <p class="payment-checkout-item-title">Subtotal</p>
                                    <?php
                                        if (!empty($this->data['cartBooks'])) {
                                            $subtotal = 0;
                                            foreach ($this->data['cartBooks'] as $book) {
                                                $subtotal += $book->price;
                                            }
                                        } else {
                                            $subtotal = 0;
                                        }
                                        echo '<p class="payment-checkout-item-price">Rp' . $subtotal . '</p>';
                                    ?>
                                </div>
                                <div class="payment-checkout-item">
                                    <p class="payment-checkout-item-title">Tax (10% subtotal)</p>
                                    <?php
                                        $tax = $subtotal * 0.1;
                                        echo '<p class="payment-checkout-item-price">Rp' . $tax . '</p>';
                                    ?>
                                </div>
                            <div class="payment-checkout-footer">
                                <div class="payment-checkout-footer-line"></div>
                                <div class="payment-checkout-item">
                                    <p class="payment-checkout-footer-total">Grand Total</p>
                                    <?php
                                        $grandTotal = $subtotal + $tax;
                                        echo '<p class="payment-checkout-footer-total">Rp' . $grandTotal . '</p>';
                                    ?>
                                </div>
                                <button class="payment-checkout-footer-btn" id="checkout-btn">Checkout</button>
                            </div>
                        </div>
                    </div>
                </section>
                <?php include(dirname(__DIR__) . '/template/toast.php') ?>
            </div>
            <div class="overlay" id="overlay">
                <div class="confirmationPopup" id="confirmationPopup">
                    <div class="popupContent">
                        <h2 class="popupTitle">Confirm Checkout</h2>
                        <p class="popupConfirmText">Are you sure you want to proceed with the checkout?</p>
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
<html>