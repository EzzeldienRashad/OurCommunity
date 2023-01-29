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
    <link rel="stylesheet" href="../../../assets/fontawesome/css/fontawesome.css"/>
    <link rel="stylesheet" href="../../../assets/fontawesome/css/brands.css"/>
    <link rel="stylesheet" href="../../../assets/fontawesome/css/solid.css"/>
	<link rel="icon" href="../../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="../../styles/index.css" />
	<link rel="stylesheet" href="index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nosifer&display=swap" rel="stylesheet">
	<script type="text/javascript" src="../../scripts/index.js" defer></script>
	<script type="text/javascript" src="index.js" defer></script>
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
        <h1>PROFESSIONAL KILLER</h1>
        <h2>by Omar Ashraf</h2>
        <div class="slider">
            <div class="overlay"></div>
            <button class="arrow arrow-left"><i class="fa-solid fa-angle-left"></i></button>
            <div class="images">
                <img src="../../../images/professional_killer/picture10.jpeg"/>
                <img src="../../../images/professional_killer/picture1.jpeg"/>
                <img src="../../../images/professional_killer/picture2.jpeg"/>
                <img src="../../../images/professional_killer/picture3.jpeg"/>
                <img src="../../../images/professional_killer/picture4.jpeg"/>
                <img src="../../../images/professional_killer/picture5.jpeg"/>
                <img src="../../../images/professional_killer/picture6.jpeg"/>
                <img src="../../../images/professional_killer/picture7.jpeg"/>
                <img src="../../../images/professional_killer/picture8.jpeg"/>
                <img src="../../../images/professional_killer/picture9.jpeg"/>
                <img src="../../../images/professional_killer/picture10.jpeg"/>
                <img src="../../../images/professional_killer/picture1.jpeg"/>
                <img src="../../../images/professional_killer/picture2.jpeg"/>
            </div>
            <button class="arrow arrow-right"><i class="fa-solid fa-angle-right"></i></button>
        </div>
        <h3><i class="fa-solid fa-arrow-down-long"></i><i class="fa-solid fa-arrow-down-long"></i> DOWNLOAD NOW <i class="fa-solid fa-arrow-down-long"></i><i class="fa-solid fa-arrow-down-long"></i></h3>
        <iframe frameborder="0" src="https://itch.io/embed/1721187?border_width=2" width="554" height="169">
            <a href="https://omar-ogp.itch.io/profissional-killer">Professional Killer by Omar Game Programmer</a>
        </iframe>
        <h3><i class="fa-solid fa-arrow-up-long"></i><i class="fa-solid fa-arrow-up-long"></i> DOWNLOAD NOW <i class="fa-solid fa-arrow-up-long"></i><i class="fa-solid fa-arrow-up-long"></i></h3>
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