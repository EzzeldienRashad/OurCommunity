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
		$_SESSION["nameErr"] = "*name too long";
	} else if (strlen($_POST["name"]) < 3) {
		$_SESSION["nameErr"] = "*name too short";
	} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$_SESSION["emailErr"] = "*Email not valid";
	} else {
		$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
		$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
		$stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Users WHERE name = ?");
		$stmt->execute([$_POST["name"]]);
		$row = $stmt->fetch();
		if ($row) {
			$_SESSION["nameErr"] = "*name already used by another user";
		} else {
			$stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Users WHERE email = ?");
			$stmt->execute([$_POST["email"]]);
			$row = $stmt->fetch();
			if ($row) {
				$_SESSION["emailErr"] = "*email already used by another user";
			} else {
				$token = bin2hex(random_bytes(16));
				$stmt = $pdo->prepare("INSERT INTO b16_32390973_OurCommunity.Users (name, email, password, token)
				VALUES (?, ?, '" . password_hash($_POST["password"], PASSWORD_DEFAULT) . "', '" . $token . "')");
				$stmt->execute([$_POST["name"], $_POST["email"]]);
				$_SESSION["name"] = $name;
				$_SESSION["token"] = $token;
				header("Location: index.php");
				exit;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OurCommunity signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="author" content="Ezzeldien Rashad" />
	<meta name="description" content="Sign up to OurCommunity, a community for meeting friends, sending messages, playing, etc....">
	<meta name="keywords" content="community, chat, message friends, meeting, signup, playing games" />
	<script type="text/javascript" src="scripts/signup.js" defer></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/signup.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<main>
<h1>OurCommunity</h1>
<div class="form">
	Sign up to OurCommunity<br />
	<h2>Create a new account</h2>
	<span class="header-note">It's quick and easy.</span>
	<hr />
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
		<input type="text" name="name" placeholder="Full Name" autocomplete="name" style="<?php if (isset($_SESSION["nameErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["name"])) echo $_SESSION["name"]; ?>" />
		<div id="nameErr" class="err"><?php if (isset($_SESSION["nameErr"])) {echo  $_SESSION["nameErr"]; unset($_SESSION["nameErr"]);} ?></div>
		<input type="email" name="email" placeholder="email" autocomplete="email" style="<?php if (isset($_SESSION["emailErr"])) echo "border-color: red"; ?>" value="<?php if (isset($_SESSION["email"])) echo $_SESSION["email"]; ?>" />
		<div id="emailErr" class="err"><?php if (isset($_SESSION["emailErr"])) {echo  $_SESSION["emailErr"]; unset($_SESSION["emailErr"]);} ?></div>
		<div class="password-cont">
			<input type="password" name="password" placeholder="password" style="padding-right: 40px;" autocomplete="new-password" value="<?php if (isset($_SESSION["password"])) echo $_SESSION["password"]; ?>" />
			<span class="password-eye">&#128065;</span>
			<div id="passStrengthInfo" class="err"></div>
		</div>
		<input type="submit" name="submit" class="submit" value="Sign Up" />
	</form>
	<a class="login-redirect" href="login.php">Already have an account?</a>
</div>

</main>
<footer>
<a href="signup.php">sign up</a>
<a href="login.php">log in</a>
<br /><br />
&copy; Ezzeldien 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>