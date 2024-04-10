<!DOCTYPE html>
<html lang="en-US">
<head>
<script src="https://kit.fontawesome.com/6e1a58f88e.js" crossorigin="anonymous"></script>
    <title>Second-Hand Website</title>
    <meta charset="UTF-8">
</head>
<body>
    <header>
        <a href="index.php">Second-Hand Website</a>
        <form action="search.php" method="get">
            <input type="text" name="search" placeholder="Search for items...">
            <input type="submit" value="Search">
        </form>
        <a href="wishlist.html"><i class="fa-regular fa-heart"></i></i></a>
         <a href="messages.html"> <i class="fa-regular fa-message"></i></a>
         <a href="profile.html">Profile</a>
        <a href="register.html">Register</a>
        <a href="login.html">Login</a>
    </header>
    <section class="login-section">
        <h2>Login</h2>
        <form action="action_login.php" method="post">
            <label> Username <input type="text" name="username" ></label>
            <label> Password <input type="password" name="password" ></label>
            <button type="submit"> Login </button>
          </form>
    </section>

<footer>
    <p>&copy; 2024 Second-Hand Website. All rights reserved.</p>
</footer>
</body>
</html>