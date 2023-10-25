<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Settings</title>
    
    <!-- Globals and Templates CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/template/topnav.css">

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/settings/settings.css">

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
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/settings/settings.js" defer></script>
</head>
<body>
    <div id="root">
        <div id="user-id-hidden" hidden><?= $this->data['user_id'] ?></div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <section class="settings-section">
                    <form id="settings-form" method="post" autocomplete="on">
                        <h2 class="settings-header">Username</h2>
                        <div class="error-message" id="username-error"></div>
                        <input class="settings-input" type="text" id="username" name="username" value="<?=$this->data['username']?>">
                        <h2 class="settings-header">Password</h2>
                        <div class="error-message" id="password-error"></div>
                        <input class="settings-input" type="password" id="password" name="password" placeholder="Enter a new password">
                        <h2 class="settings-header">Confirm Password</h2>
                        <div class="error-message" id="confirm-password-error"></div>
                        <input class="settings-input" type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
                        <div class="popupButtons">
                            <button id="save-info-btn" class="btn-standard save-info-button">Save</button>
                        </div>
                    </form>
                </section>
            </div>
            <div class="overlay" id="overlay">
                <div class="confirmationPopup" id="confirmationPopup">
                    <div class="popupContent">
                        <h2 class="popupTitle">Confirm Changes</h2>
                        <p class="popupConfirmText">Are you sure you want to change your username/password?</p>
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