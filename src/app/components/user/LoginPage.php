<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Login</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/user/login-register.css">

    <!-- JavaScript Constant and Variables -->
    <script type="text/javascript" defer>
        const DEBOUNCE_TIMEOUT = "<?= DEBOUNCE_TIMEOUT ?>";
    </script>

    <!-- JavaScript -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/lib/debounce.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/user/login.js" defer></script>
</head>
<body>
    <div class="login-container">
        <div class="login form">
            <header>Login</header>
            <form id="login-form" method="post">
                <div class="error-message" id="username-error"></div>
                <input type="text" id="username" name="username" placeholder="Enter your username" autocomplete="on">
                <div class="error-message" id="password-error"></div>
                <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="on">
                <div class="error-message" id="login-error"></div>
                <input type="submit" class="sign-in-button" value="Login">
            </form>
            <div class="signup">
                <span class="signup">Don't have an account? <a href="/public/user/register">Sign up</a></span>
            </div>
        </div>
    </div>
</body>
</html>
