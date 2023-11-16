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
        <div id="username-hidden" hidden><?= $this->data['username'] ?></div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <div style="padding: 8px; display: flex; flex-direction: column">
                    <section class="subs-section">
                        <h1 class="subs-header">Subscribed to</h1>
                        <?php if (!empty($this->data['subbedAuthors'])) : ?>
                            <?php foreach ($this->data['subbedAuthors'] as $author) : ?>
                                <div class="subs-card">
                                    <div class="card-profile">
                                        <i class="bx bx-user" style="font-size: 28px;"></i>
                                        <div class="card-content">
                                            <div hidden class="author-id"><?= $author['userID'] ?></div>
                                            <div class="username">
                                                <h3 class="card-header"><?= $author['name'] ?></h3>
                                                <i class="bx bxs-badge-check" style="color: #67A0EA;"></i>
                                            </div>
                                            <p class="card-text"></p>@<?= $author['username'] ?></p>
                                        </div>
                                    </div>
                                    <button class='btn-standard unsub-button' id='unsub-<?= $author['userID'] +'-'+$author['username'] ?>'>
                                        Unsubscribe
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p style="margin-left: 12px;">No subscribed authors yet...</p>
                        <?php endif; ?>
                    </section>
                    <section class="subs-section">
                        <h1 class="subs-header">Discover Authors</h1>
                        <?php if (!empty($this->data['authors'])) : ?>
                            <?php foreach ($this->data['authors'] as $author) : ?>
                                <div class="subs-card">
                                    <div class="card-profile">
                                        <i class="bx bx-user" style="font-size: 28px;"></i>
                                        <div class="card-content">
                                            <div hidden class="author-id"><?= $author['userID'] ?></div>
                                            <div class="username">
                                                <h3 class="card-header"><?= $author['name'] ?></h3>
                                                <i class="bx bxs-badge-check" style="color: #67A0EA;"></i>
                                            </div>
                                            <p class="card-text">@<?= $author['username'] ?></p>
                                        </div>
                                    </div>
                                    <button class='btn-standard sub-button' id='sub-<?= $author['userID'] ?>'>
                                        Subscribe
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <No style="margin-left: 12px;">No premium authors yet...</p>
                        <?php endif; ?>
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