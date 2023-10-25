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

    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Page-specific CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/user/userlist.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- JavaScript DOM and AJAX -->
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/sidebar.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/component/searchpanel.js" defer></script>
    <script type="text/javascript" src="<?= BASE_URL ?>/javascript/user/userlist.js" defer></script>
</head>
<body>
    <div id="root">
        <div id="is-admin" hidden><?= $this->data['isAdmin'] ?></div>
        <?php include(dirname(__DIR__) . '/template/sidebar.php') ?>
        <main class="main-container">
            <?php include(dirname(__DIR__) . '/template/topnav.php') ?>
            <div class="secondary-container">
                <div class="search-panel">
                    <form role="search" id="input-form">
                        <input type="search" id="query" class="search-input" name="q" placeholder="Search user..." aria-label="Search through site content">
                        <button class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    </div>
                    <!-- ssssssss -->
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Books Owned</th>
                            <th>Edits</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->data['users'] as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user->username) ?></td>
                                <td><?= $user->books_owned ?></td>
                                <td><i class="fas fa-trash" data-user-id="<?= $user->user_id ?>"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div> 
            </div>
        </main>
    </div>
</body>
<html>