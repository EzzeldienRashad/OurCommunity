<header>
<?php

// Check if user doesn't exist
if (isset($_SESSION["name"]) && isset($_SESSION["token"])) {
	$name = $_SESSION["name"];
	$token = $_SESSION["token"];
} elseif (isset($_COOKIE["token"]) && isset($_COOKIE["name"])) {
	$name = $_COOKIE["name"];
	$token = $_COOKIE["token"];
}
if (isset($name) && isset($token)) {
	$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
	$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9");
	$stmt = $pdo->prepare("SELECT token FROM epiz_31976759_OurCommunity.Users WHERE name = ?");
	$stmt->execute([$name]);
	$resultToken = $stmt->fetchColumn();
	if (!$resultToken || $resultToken != $token) {
		header("Location: login.php");
		exit;
	}
} else {
	header("location: login.php");
	exit;
}

// log user out if they press logout
if (isset($_POST["logout"])) {
	unset($_SESSION["name"]);
	unset($_SESSION["token"]);
	setcookie("name", "", time() - 3600, "/");
	setcookie("token", "", time() - 3600, "/");
	header("Location: login.php");
}
// Exit group if they press logout
if (isset($_POST["groupLogout"])) {
	unset($_SESSION["groupName"]);
	unset($_SESSION["groupToken"]);
	setcookie("groupName", "", time() - 3600, "/");
	setcookie("groupToken", "", time() - 3600, "/");
	header("Location: groups.php");
}
?>
<span class="decoration"></span>
<h1>OurCommunity</h1>
<div class="hello">Hello, <span><?php echo $name; ?></span>!</div>
<div class="menu">
	<span></span>
	<span></span>
	<span></span>
</div>
<div class="dropdown">
<a href="index.php">main page</a>
<a href="users.php">other users</a>
<a href="users.php?groups=true">groups</a>
<form class="logout" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">  
	<input type="submit" name="logout" value="logout" />
</form>
<form class="logout" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">  
	<input type="submit" name="groupLogout" value="Exit group" />
</form>
</div>
</header>
<script>
	// Position "Hello user!" correctly
	document.getElementsByClassName("hello")[0].style.left =
		(document.getElementsByClassName("menu")[0].getBoundingClientRect().left - 
		document.getElementsByTagName("h1")[0].getBoundingClientRect().right) / 2 - 
		document.getElementsByClassName("hello")[0].offsetWidth / 2 + 
		document.getElementsByTagName("h1")[0].getBoundingClientRect().right + "px";
	// show dropdown on menu click
	document.getElementsByClassName("menu")[0].addEventListener("click", function () {
		document.getElementsByClassName("dropdown")[0].classList.toggle("display-dropdown");
		document.getElementsByTagName("main")[0].addEventListener("click", function menuHide() {
			document.getElementsByClassName("dropdown")[0].classList.remove("display-dropdown");
			document.getElementsByTagName("main")[0].removeEventListener("click", menuHide);
		});
	});
	// position footer correctly
	window.addEventListener("DOMContentLoaded", function() {
		document.getElementsByTagName("main")[0].style.minHeight =
			document.documentElement.clientHeight - 80 + "px";
	});
</script>