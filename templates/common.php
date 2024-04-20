<?php function output_header(){ ?>
    <!DOCTYPE html>
<html lang="en-US">
<head>
    <script src="https://kit.fontawesome.com/6e1a58f88e.js" crossorigin="anonymous"></script>
    <title>Second-Hand Website</title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/layout.css" rel="stylesheet">
    <script src="scripts/modal_login.js" defer></script>
    <?php if(isset($_SESSION['login'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            ToggleLogin();
        });
    </script>
    <?php unset($_SESSION['login']);
    endif; ?>
    <script src="scripts/modal_register.js" defer></script>
    <script src="scripts/verify_password.js" defer></script>
</head>
<body>
    <header>
        <h1><a href="index.php">Second-Hand Website</a></h1>
        <form id="searchbar">
            <input type="search" placeholder="Search...">
        </form>
        <div class="logreg">
            <?php if (isset($_SESSION['username'])) { ?>
                <a href="wishlist.html"><div class="wishlist">
                    <i class="fa-regular fa-heart" onmouseover="this.className='fa-solid fa-heart';" onmouseout="this.className='fa-regular fa-heart';"></i>
                </div></a>
                <a href="chat.html"><div class="chat">
                    <i class="fa-regular fa-message" onmouseover="this.className='fa-solid fa-message';" onmouseout="this.className='fa-regular fa-message';"></i>
                </div></a>
                <a href="profile.php"><button type="button" class="profile"><i class="fa-solid fa-user"></i></button></a>
                <a href="action_logout.php"><button type="button" class="logout">Logout</button></a>
            <?php } else { ?>
                <button type="button" id="register">Register</button>
                <button type="button" id="login">Login</button>
            <?php } ?>
        </div>
    </header>
    
    <div id="fadeLogin" class="hide"></div>
    <div id="loginmodal" class="hide">
        <h2 class="modalheader">Login</h2>
        <button id="closebtnL">x</button>
        <form action="action_login.php" method="post" id="loginfields">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password"required>
            <button type="submit">Login</button>
        </form>
    </div>
    
    <div id="fadeRegister" class="hide"></div>
    <div id="registermodal" class="hide">
        <h2 class="modalheader">Register</h2>
        <button id="closebtnR">x</button>
        <form action="action_register.php" method="post" id="registerfields" onsubmit="return verifyPassword()">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="name@example.com" required>
            <input type="password" name="password" id="password" placeholder="Password"required>
            <input type="password" name="confirm" id="confirm" placeholder="Confirm Password"required>
            <button type="submit">Register</button>
        </form>
    </div>
 <?php } ?>

 <?php function output_footer(){ ?>
        </main>
    <footer>
        <p>&copy; 2024 Second-Hand Website. All rights reserved.</p>
    </footer>
    </body>
    </html>
  <?php } ?>
