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
<html lang="ar" dir="rtl">
<head>
	<title>مجتمعنا</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="عزالدين رشاد" />
	<meta name="description" content="موقع مجتمعنا للعب ومقابلة اﻷصدقاء وغير ذلك الكثير">
	<meta name="keywords" content="مجتمع, شات, مراسلة اﻷصدقاء, مجموعات, ألعاب" />
    <script type="text/javascript" src="scripts/index.js" defer></script>
    <script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
    <style>
        main {
            padding: 50px;
            text-align: right;
        }
        h2 {
            text-align: right;
        }
        table {
            table-layout: auto;
        }
        table, td, th {
            text-align: right;
        }
        th {
            padding: 5px;
            width: 1px;
            white-space: nowrap;
        }
        .align-top {
            vertical-align: top;
        }
        .map {
            width: 45vw;
            height: 35vw;
        }
        @media only screen and (max-width: 490px) {
            main {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-header">
            <img src="../images/mainImages/logo.webp" alt="شعار مجتمعنا" width="150" height="120" />
            <h1>
                مجتمعنا
                <br />
                <span class="green">للعب ومراسلة اﻷصدقاء</span>
            </h1>
            <a href="../en" class="switch-lang" hreflang="en" lang="en">English</a>
        </div>
        <div class="menu-cont">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            القائمة
        </div>
        <nav>
            <a href="index.php">الرئيسية</a>
            <a href="services.php">خدماتنا</a>
            <a href="about.php">عن الموقع</a>
            <span class="disabled">اتصل بنا</span>
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
                        <input type='submit' name='logout' value='تسجيل الخروج' />
                    </form>
                    ";
                } else {
                    echo "<a href='message/login.php?page=main'>تسجيل الدخول</a>";
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <h2 class="green">اتصل بنا</h2>
        <table>
            <tbody>
                <tr>
                    <th>جوال:</th>
                    <td>المواقع ﻻ تملك هواتف</td>
                </tr>
                <tr>
                    <th>بريد إلكتروني:</th>
                    <td>إلكترونى ﻻ يملك بريد</td>
                </tr>
                <tr>
                    <th>صندوق بريد:</th>
                    <td>ﻻ أجد صندوقه</td>
                </tr>
                <tr>
                    <th>العنوان:</th>
                    <td>شبكة اﻹنترنت</td>
                </tr>
                <tr>
                    <th class="align-top">الخريطة:</th>
                    <td>
                        <img class="map" src="../images/mainImages/map.webp" alt="خريطة" width="300" height="150" />
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">عن الموقع</a>
            <a href="contact.php">اتصل بنا</a>
            <a href="../en" class="fleft" hreflang="en" lang="en">English</a>
        </div>
        <div class="footer-info">
            حقوق النشر محفوظة لموقع مجتمعنا @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>