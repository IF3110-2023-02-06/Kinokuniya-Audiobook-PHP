<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Subscription</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/subscription/subscription.css">

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
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/subscription/subscription.js" defer></script>
</head>
<body>
    <div id="root">
        <div id="user-id-hidden" hidden><?= $this->data['user_id'] ?></div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <div style="padding: 8px; display: flex; flex-direction: column">
                    <section class="subs-section">
                        <h1 class="subs-header">Subscribed to</h1>
                        <div class="subs-card">
                            <div hidden id="author-id">1</div>
                            <p class="card-text">@blyaddddd</p>
                            <button class='btn-standard unsub-button' id='unsub-button'>
                                Unsubscribe
                            </button>
                        </div>
                        <div class="subs-card">
                            <div hidden id="author-id">2</div>
                            <p class="card-text">@cykaaaa</p>
                            <button class='btn-standard unsub-button' id='unsub-button'>
                                Unsubscribe
                            </button>
                        </div>
                    </section>
                    <section class="subs-section">
                        <h1 class="subs-header">Discover Authors</h1>
                        <div class="subs-card">
                            <div hidden id="author-id">3</div>
                            <p class="card-text">@alifioditya</p>
                            <button class='btn-standard' id='sub-button'>
                                Subscribe
                            </button>
                        </div>
                    </section>
                </div>
            </div>
            <div class="overlay" id="overlay">
                <div class="confirmationPopup" id="confirmationPopup">
                    <div class="popupContent">
                        <h2 class="popupTitle">Confirm Changes</h2>
                        <p class="popupConfirmText">Are you sure you want to unsubscribe?</p>
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