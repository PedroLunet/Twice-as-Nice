<?php
    require_once ('database/connection.php');
    require_once ('database/items.php');
    $db = getDatabaseConnection();

    $items = getItems($db);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <script src="https://kit.fontawesome.com/6e1a58f88e.js" crossorigin="anonymous"></script>
    <title>Second-Hand Website</title>
    <meta charset="UTF-8">
    <link href="css/main_page.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1><a href="index.php">Second-Hand Website</a></h1>
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
    <nav>
        <ul>
          <li><a href="electronics.html">Electronics</a></li>
          <li><a href="#books">Books</a></li>
          <li><a href="#clothing">Clothing</a></li>
          <li><a href="#home-kitchen">Home & Kitchen</a></li>
          <li><a href="#sports-outdoors">Sports & Outdoors</a></li>
        </ul>
      </nav>
    <main>
    <aside id="random_items">
        <h1>Item Feed</h1>
            <?php foreach ($items as $item) { 
                outputItem($db,$item);
             } ?>    
    </aside>

    </main>
<footer>
    <p>&copy; 2024 Second-Hand Website. All rights reserved.</p>
</footer>
</body>
</html>