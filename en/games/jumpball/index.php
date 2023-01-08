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
<html lang="en">
<head>
	<title>OurCommunity</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="Ezzeldien Rashad" />
	<meta name="description" content="OurCommunity website for playing, meeting friends and a lot more">
	<meta name="keywords" content="community, chat, message friends, meeting, playing games" />
    <script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="../../scripts/index.js" defer></script>
	<script type="text/javascript" src="index.js" defer></script>
	<link rel="icon" href="../../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="../../styles/index.css" />
	<link rel="stylesheet" href="index.css" />
    <style>
        html {
            padding: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="menu-cont">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            menu
        </div>
        <nav>
            <a href="../../index.php">Home</a>
            <a href="../../services.php">Services</a>
            <a href="../../about.php">about</a>
            <a href="../../contact.php">Contact Us</a>
            <a href="../../../ar" hreflang="ar" lang="ar" lang="ar">العربية</a>
            <button class="login-menu-button">
                <?php
                if ($signedIn) {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../../../images/users/user.png' width='40' height='40'/>";
                } else {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../../../images/users/anonymous.png' width='40' height='40'/>";
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
                    echo "<a href='../../message/login.php?page=main'>login</a>";
                }
                ?>
            </div>
        </nav>
    </header>
    <main>

    <div class="frame-cont">
        <img src="../../../images/jumpball/background.webp" alt="">
        <img src="../../../images/jumpball/background.webp" alt="">
        <div class="frame">
            <div id="play">
                <button>play</button>
            </div>
            <div id="replay">
                <button>
                    points: <span></span>
                    <br>
                    PLAY AGAIN!!!
                </button>
            </div>
            <i class="fa-solid fa-volume-xmark fa-lg music"></i>
        </div>
    </div>
    </main>
    <footer>
        <div class="footer-links">
            <a href="../../about.php">about us</a>
            <a href="../../contact.php">contact us</a>
            <a href="../../../ar" class="fright" hreflang="ar" lang="ar">العربية</a>
        </div>
        <div class="footer-info">
            All rights reserved for OurCommunity @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>