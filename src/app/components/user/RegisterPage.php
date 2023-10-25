<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "icon" href = "https://ugc.production.linktr.ee/HgDUQezLRzaAhdOsHX7E_757110a46f23cdba31b42e43f2c1a7fb.png" 
    type = "image/x-icon">
    <title>Register</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/user/login-register.css">

    <!-- JavaScript Constant and Variables -->
    <script type="text/javascript" defer>
        const DEBOUNCE_TIMEOUT = "<?= DEBOUNCE_TIMEOUT ?>";
    </script>

    <!-- JavaScript -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/lib/debounce.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/user/register.js" defer></script>
</head>
<body>
    <div class="login-container">
        <div class="registration form">
            <header>Sign Up</header>
            <form id="registration-form" method="post" autocomplete="on">
                <div class="error-message" id="username-error"></div>
                <input type="text" id="username" name="username" placeholder="Enter a username">
                <div class="error-message" id="password-error"></div>
                <input type="password" id="password" name="password" placeholder="Create a password">
                <div class="error-message" id="confirm-password-error"></div>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
                <input type="submit" id="register-button" class="sign-in-button" value="Sign up">
            </form>
            <div class="signup">
                <span class="signup">Already have an account? <a href="/public/user/login">Login</a></span>
            </div>
        </div>
    </div>
</body>
</html>
