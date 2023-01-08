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
    <script src="scripts/index.js" defer></script>
    <script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
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
            <span class="disabled">Home</span>
            <a href="services.php">Services</a>
            <a href="about.php">about</a>
            <a href="contact.php">Contact Us</a>
            <a href="../ar" hreflang="ar" lang="ar" lang="ar">العربية</a>
            <button class="login-menu-button">
                <?php
                if ($signedIn) {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../images/users/user.png' width='40' height='40'/>";
                } else {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../images/users/anonymous.png' width='40' height='40'/>";
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
                    echo "<a href='message/login.php?page=main'>login</a>";
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <section id="slider">
            <div class="slider-description">
                <div class="slider-progress">
                    <div class="progress-bar">
                        <progress value="0" max="100"></progress>
                        <progress value="0" max="100"></progress>
                        <progress value="0" max="100"></progress>
                    </div>
                </div>
                <div class="descriptions">
                    <div class="description">
                        <h1>You can play, chat with friends, and much more!</h1>
                    </div>
                    <div class="description">
                        <h1>The best website to defeat boredom and have fun!</h1>
                    </div>
                    <div class="description">
                        <h1>Welcome to OurCommunity!</h1>
                    </div>
                </div>
            </div><div class="moving-slider">
                <div class="pics-cont">
                    <a href="services.php">
                        <img src="../images/mainImages/logo.webp" alt="OurCommunity" width="400" height="320" />
                    </a>
                    <a href="games">
                        <img src="../images/mainImages/games.webp" alt="game" width="400" height="320" />
                    </a>
                    <a href="message">
                        <img src="../images/mainImages/message.webp" alt="chat" width="400" height="320" />
                    </a>
                    <a href="services.php">
                        <img src="../images/mainImages/logo.webp" alt="OurCommunity" width="400" height="320" />
                    </a>
                </div>
            </div>
        </section>

        <section id="services">
            <img src="../images/mainImages/services.webp" width="300" height="300" alt="our services" />
            <div class="services-desc">
                <p>
                    Welcome to OurCommunity, the best choise for playing and meeting friends!
                    In this website, we offer a lot of features for you to defeat boredom and communicate with your friends form anywhere.
                    You can choose from a variety of options to have fun.
                    We always try to improve ourselves and give our users the best service.
                </p>
            </div>
        </section>
        <h2 id="offers-title">what we offer</h2>
        <section id="offers">
            <a class="offer" href="message">
                <div class="offer-pic">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <span class="offer-title">chat</span>
                <p class="offer-desc">
                    A real-time chat system that allows anybody allover the world to communicate with his friends instantly
                    and send them emails with a lot of options that allow you to love a comment, delete a comment, or comment to a comment.
                </p>
            </a>
            <a class="offer" href="games">
                <div class="offer-pic">
                    <i class="fa-solid fa-gamepad" ></i>
                </div>
                <span class="offer-title">games</span>
                <p class="offer-desc">
                    A wide variety of games is offered by this website, which enables you to have fun and beat boredom.
                    You can choose between games that were made by professional enthusiastic web developers for you.
                    An errors-free experience with games that are constantly updated to allow you to have the best playing experience.
                </p>
            </a>
            <div class="offer">
                <div class="offer-pic">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="offer-title">users</span>
                <p class="offer-desc">
                    You can check the users section to see if there's someone you know there.
                    Use the search button at the top to search for your friends and communicate with them privately.
                </p>
            </div>
        </section>

        <section id="faq">
            <h2>FAQ</h2>
            <div class="faq-col1">
                <button class="accordion">How secure is this website?<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>This website is actually very secure that no one can hack it! It uses modern security features, and no hacker can ever hack this extra-powerful website!(Hopefully...)</p>
                </div>
                <button class="accordion">Is this website good?<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>What are you talking about? This website is THE BEST WEBSITE IN THE WHOLE WORLD!!!!!!.</p>
                </div>
            </div>
            <div class="faq-col2">
                <button class="accordion">How many games do you have?<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>Infinity.</p>
                </div>
                <button class="accordion">Does this website constantly improve?<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>Yes. It always improves. It improves every day. Every hour. Every minute. Every second. Every millisecond. I always improves, forever, and for everyone</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">about</a>
            <a href="contact.php">Contact Us</a>
            <a href="../ar" class="fright" hreflang="ar" lang="ar">العربية</a>
        </div>
        <div class="footer-info">
        All rights reserved for OurCommunity @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>