<?php
session_start();
// Check if the user is signed in
$signedIn = false;
if (isset($_SESSION["name"]) && isset($_SESSION["token"])) {
	$name = $_SESSION["name"];
	$token = $_SESSION["token"];
} elseif (isset($_COOKIE["token"]) && isset($_COOKIE["name"])) {
	$name = $_COOKIE["name"];
	$token = $_COOKIE["token"];
}
if (isset($name) && isset($token)) {
	$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
	$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G");
	$stmt = $pdo->prepare("SELECT token FROM b16_32390973_OurCommunity.Users WHERE name = ?");
	$stmt->execute([$name]);
	$resultToken = $stmt->fetchColumn();
	if ($resultToken && $resultToken == $token) {
		$signedIn = true;
	}
}
// log user out if they press logout
if (isset($_POST["logout"])) {
	unset($_SESSION["name"]);
	unset($_SESSION["token"]);
	unset($_SESSION["groupName"]);
	unset($_SESSION["groupToken"]);
	setcookie("name", "", time() - 3600, "/");
	setcookie("token", "", time() - 3600, "/");
	setcookie("groupName", "", time() - 3600, "/");
	setcookie("groupToken", "", time() - 3600, "/");
    $signedIn = false;
}

?>
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
	<link rel="stylesheet" href="../../assets/fontawesome/css/fontawesome.css"/>
    <link rel="stylesheet" href="../../assets/fontawesome/css/brands.css"/>
    <link rel="stylesheet" href="../../assets/fontawesome/css/solid.css"/>
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
            <a href="../../ar" class="switch-lang" hreflang="ar" lang="ar" lang="ar">العربية</a>
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
            <button class="login-menu-button">
                <?php
                if ($signedIn) {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../../images/users/user.png' width='40' height='40'/>";
                } else {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../../images/users/anonymous.png' width='40' height='40'/>";
                }
                ?>
            </button>
            <div class="login-menu hidden">
                <?php
                if ($signedIn) {
                    echo "
                    <div>$name</div>
                    <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' >
                        <input type='submit' name='logout' value='logout' />
                    </form>
                    ";
                } else {
                    echo "<a href='../message/login.php?page=main'>login</a>";
                }
                ?>
            </div>
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
            <a href="../../ar" class="fright" hreflang="ar" lang="ar">العربية</a>
        </div>
        <div class="footer-info">
        All rights reserved for OurCommunity @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>