<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<title>OurCommunity</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="Ezzeldien Rashad" />
	<meta name="description" content="OurCommunity website for playing, meeting friends and a lot more">
	<meta name="keywords" content="community, chat, message friends, meeting, playing games" />
	<script type="text/javascript" src="../scripts/index.js" defer></script>
	<script type="text/javascript" src="../scripts/table.js" defer></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="../styles/index.css" />
	<link rel="stylesheet" href="../styles/table.css" />
</head>
<body>
    <header>
        <div class="logo-header">
            <img src="../../images/mainImages/logo.webp" alt="OurCommunity-logo" width="150" height="120" />
            <h1>
                OurCommunity
                <br />
                <span class="green">for playing and meeting friends</span>
            </h1>
            <a href="../../ar" class="switch-lang" hreflang="ar">العربية</a>
        </div>
        <div class="menu-cont">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            menu
        </div>
        <nav>
            <a href="../index.php">Home</a>
            <a href="../services.php">Services</a>
            <a href="../about.php">about</a>
            <a href="../contact.php">Contact Us</a>
        </nav>
    </header>
    <main>
        <h2> games </h2>
        <table class="items-table">
            <tbody>
                <?php
                include "../../functions/loadItems.php";
                loadItems("games.json", "en", "../../");
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">about</a>
            <a href="contact.php">Contact Us</a>
            <a href="../../ar" class="fright" hreflang="ar">العربية</a>
        </div>
        <div class="footer-info">
        All rights reserved for OurCommunity @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>