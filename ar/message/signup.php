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

// Check for errors, then add the user to the database
if (isset($_POST["submit"])) {
	$_SESSION["name"] = $_POST["name"];
	$_SESSION["email"] = $_POST["email"];
	$_SESSION["password"] = $_POST["password"];
	if (strlen($_POST["name"]) > 30) {
		$_SESSION["nameErr"] = "اﻹسم طويل جدًا*";
	} else if (strlen($_POST["name"]) < 3) {
		$_SESSION["nameErr"] = "اﻹسم قصير جدًا*";
	} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$_SESSION["emailErr"] = "اﻹيميل به أخطاء*";
	} else {
		$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
		$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
		$stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Users WHERE name = ?");
		$stmt->execute([$_POST["name"]]);
		$row = $stmt->fetch();
		if ($row) {
			$_SESSION["nameErr"] = "هذا اﻹسم يستخدمه مستخدم آخر*";
		} else {
			$stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Users WHERE email = ?");
			$stmt->execute([$_POST["email"]]);
			$row = $stmt->fetch();
			if ($row) {
				$_SESSION["emailErr"] = "هذا اﻹيميل يستخدمه مستخدم آخر*";
			} else {
				$token = bin2hex(random_bytes(16));
				$stmt = $pdo->prepare("INSERT INTO b16_32390973_OurCommunity.Users (name, email, password, token)
				VALUES (?, ?, '" . password_hash($_POST["password"], PASSWORD_DEFAULT) . "', '" . $token . "')");
				$stmt->execute([$_POST["name"], $_POST["email"]]);
				$_SESSION["token"] = $token;
				if (isset($_GET["page"]) && $_GET["page"] == "main") {
					header("Location: ../");
				} else {
					header("Location: index.php");
				}
				exit;
			}
		}
	}
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
	<script type="text/javascript" src="scripts/signup.js" defer></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/signup.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<main>
<h1>مجتمعنا</h1>
<div class="form">
	إنشاء حساب<br />
	<h2>أنشئ حسابًا جديدًا</h2>
	<span class="header-note">فى أقل من دقيقة.</span>
	<hr />
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); if (isset($_GET["page"]) && $_GET["page"] == "main") echo "?page=main" ?>">
		<input type="text" name="name" placeholder="اﻹسم" autocomplete="name" style="<?php if (isset($_SESSION["nameErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["name"])) echo $_SESSION["name"]; ?>" />
		<div id="nameErr" class="err"><?php if (isset($_SESSION["nameErr"])) {echo  $_SESSION["nameErr"]; unset($_SESSION["nameErr"]);} ?></div>
		<input type="email" name="email" placeholder="البريد اﻹلكترونى" autocomplete="email" style="<?php if (isset($_SESSION["emailErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["email"])) echo $_SESSION["email"]; ?>" />
		<div id="emailErr" class="err"><?php if (isset($_SESSION["emailErr"])) {echo  $_SESSION["emailErr"]; unset($_SESSION["emailErr"]);} ?></div>
		<div class="password-cont">
			<input type="password" name="password" placeholder="كلمة السر" style="padding-left: 40px;" autocomplete="new-password" value="<?php if (isset($_SESSION["password"])) echo $_SESSION["password"]; ?>" />
			<span class="password-eye">&#128065;</span>
			<div id="passStrengthInfo" class="err"></div>
		</div>
		<input type="submit" name="submit" class="submit" value="أنشئ الحساب" />
	</form>
	<a class="login-redirect" href="login.php<?php if (isset($_GET["page"]) && $_GET["page"] == "main") echo "?page=main" ?>">هل لديك حساب بالفعل؟</a>
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