<?php 
session_start(); 
// Check if user is already logged in
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
	if ($resultToken == $token) {
		header("Location: index.php");
		exit;
	}
}

// check for errors, then log user in
if (isset($_POST["submit"])) {
	$_SESSION["email"] = $_POST["email"];
	$_SESSION["password"] = $_POST["password"];
	$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
	$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
	$stmt = $pdo->prepare("SELECT * FROM b16_32390973_OurCommunity.Users WHERE email = ?");
	$stmt->execute([$_POST["email"]]);
	$info = $stmt->fetch();
	if ($info) {
		if (!password_verify($_POST["password"], $info["password"])) {
			$_SESSION["passwordErr"] = True;
		} else {
			$token = bin2hex(random_bytes(16));
			$pdo->query("UPDATE b16_32390973_OurCommunity.Users SET token = '" . $token . "' WHERE id = " . $info["id"]);
			$_SESSION["name"] = $info["name"];
			$_SESSION["token"] = $token;
			if (isset($_POST["remember"]) && $_POST["remember"] == "on") {
				setcookie("name", $info["name"], time() + 86400 * 30, "/");
				setcookie("token", $token, time() + 86400 * 30, "/");
			}
			if (isset($_GET["page"]) && $_GET["page"] == "main") {
				header("Location: ../");
			} else {
				header("Location: index.php");
			}
			exit;
		}
	} else {
		$_SESSION["emailErr"] = TRUE;
	}
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
	<title>مجتمعنا</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="عزالدين رشاد" />
	<meta name="description" content="موقع مجتمعنا للعب ومقابلة اﻷصدقاء وغير ذلك الكثير">
	<meta name="keywords" content="مجتمع, شات, مراسلة اﻷصدقاء, مجموعات, ألعاب" />
	<script type="text/javascript" src="scripts/login.js" defer></script>
	<link rel="icon" href="../../images/mainImages/logo.webp" />
	<link rel="stylesheet" href="styles/login.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet" />
</head>
<body>
<main>
<a href="../"><h1>مجتمعنا</h1></a>
<div class="form">
تسجيل الدخول<br />
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); if (isset($_GET["page"]) && $_GET["page"] == "main") echo "?page=main" ?>">
		<input type="email" name="email" placeholder="البريد اﻹلكترونى" autocomplete="email" style="<?php if (isset($_SESSION["emailErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["email"])) echo $_SESSION["email"]; ?>" />
		<div id="emailErr" class="err"><?php if (isset($_SESSION["emailErr"])) {echo "إيميل خطأ"; unset($_SESSION["emailErr"]);} ?></div>
		<div class="password-cont">
			<input type="password" name="password" placeholder="كلمة السر" autocomplete="current-password" style="padding-left: 40px;<?php if (isset($_SESSION["passwordErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["password"])) echo $_SESSION["password"]; ?>" />
			<span class="password-eye">&#128065;</span>
			<div id="passwordErr" class="err"><?php if (isset($_SESSION["passwordErr"])) {echo "كلمة سر خطأ"; unset($_SESSION["passwordErr"]);} ?></div>
		</div>
		<input type="submit" name="submit" class="submit" value="تسجيل الدخول" />
		<div class="remember-div">
			<label>
				<input type="checkbox" name="remember" value="on" checked /> تذكرنى 
			</label>
		</div>
	</form>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	<div id="g_id_onload"
		data-client_id="368121326006-pj9as4v7mtp2gbfi1dk5376sstqu0oss.apps.googleusercontent.com"
		data-context="signin"
		data-ux_mode="popup"
		data-login_uri="<?php
		 echo pathinfo(htmlspecialchars($_SERVER["PHP_SELF"]), PATHINFO_DIRNAME); 
		 ?>/googleSignin.php<?php 
		 if (isset($_GET["page"]) && $_GET["page"] == "main") echo "?page=main"
		 ?>"
		data-auto_prompt="false">
	</div>

	<div class="g_id_signin"
		data-type="standard"
		data-shape="rectangular"
		data-theme="outline"
		data-text="signin_with"
		data-size="large"
		data-logo_alignment="left">
	</div>
	<div class="relative">
		<hr />
		<div class="or">أو</div>
	</div>
	<br />
	<a href="signup.php<?php if (isset($_GET["page"]) && $_GET["page"] == "main") echo "?page=main" ?>">إنشاء حساب</a>
	<br />
</div>

</main>
<footer>
<a href="signup.php">إنشاء حساب</a>
<a href="login.php">تسجيل الدخول</a>
<br /><br />
&copy; جميع الحقوق محفوظة لمجتمعنا 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>
