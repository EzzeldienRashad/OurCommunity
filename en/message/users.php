<?php 
include "header.php";
//check for errors, then enter group
if (isset($_POST["loginGroupSubmit"])) {
	$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
	$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
	$stmt = $pdo->prepare("SELECT * FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
	$stmt->execute([$_POST["loginGroupName"]]);
	$info = $stmt->fetch();
	if ($info) {
		if (!password_verify($_POST["loginGroupPassword"],  $info["groupPassword"])) {
			$_SESSION["loginPasswordErr"] = True;
		} else {
			$_SESSION["groupName"] = $_POST["loginGroupName"];
			$_SESSION["groupToken"] = $info["groupToken"];
			setcookie("groupName", $_POST["loginGroupName"], time() + 86400 * 30, "/");
			setcookie("groupToken", $info["groupToken"], time() + 86400 * 30, "/");
			header("Location: index.php");
			exit;
		}
	} else {
		$_SESSION["loginNameErr"] = TRUE;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OurCommunity users</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="description" content="OurCommunity users, a community for meeting friends, sending messages, playing, etc....">
	<meta name="author" content="Ezzeldien Rashad" />
	<meta name="keywords" content="community, chat, message friends, meeting, users, playing games" />
	<script type="text/javascript" src="scripts/users.js" defer></script>
	<script type="text/javascript" src="scripts/header.js" defer></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/users.css" />
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<header>
<span class="decoration"></span>
<h1>OurCommunity</h1>
<div class="hello">Hello, <span><?php echo $name; ?></span>!</div>
<div class="menu">
	<span></span>
	<span></span>
	<span></span>
</div>
<div class="dropdown">
	<a href="../">main page</a>
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
<body>
<main>
<label class="search">Search: 
	<input type="search" placeholder="Search..." class="search-input" />
</label>
<?php
echo '<div id="loginNameErr" class="err">';
if (isset($_SESSION["loginNameErr"])) {echo "*Wrong Group Name"; unset($_SESSION["loginNameErr"]);}
echo '</div>';
echo '<div id="loginPasswordErr" class="err">';
if (isset($_SESSION["loginPasswordErr"])) {echo "*Wrong Password"; unset($_SESSION["loginPasswordErr"]);};
echo '</div>';
// show users/groups present in database
$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
if (isset($_GET["groups"]) && $_GET["groups"] == "true") {
	echo "<h2>Groups:</h2>";
	$stmt = $pdo->query("SELECT groupName FROM b16_32390973_OurCommunity.Groups");
	$groups = $stmt->fetchAll(PDO::FETCH_COLUMN);
	for ($i = 0; $i < count($groups); $i++) {
		$group = $groups[$i];
		echo '
		<div class="user">' . $group . '
			<br />
			<form name="joinGroupFields" class="join-group-fields" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?groups=true&groupNum=' . $i . '" hidden>
				<input type="text" name="loginGroupName" id="loginGroupName" value="' . $group . '" hidden />
				<br />
				<label>
					group password: 
					<br />
					<div class="password-cont">
						<input type="password" size="30" name="loginGroupPassword" id="loginGroupPassword" placeholder="group password"/>
						<span class="password-eye login-eye">&#128065;</span>
					</div>
				</label>
				<br />
				<br />
				<input type="submit" size="30" name="loginGroupSubmit" value="Enter group"/>
			</form>
		</div>
		';
	}
} else {
	echo "<h2>Other users:</h2>";
	$stmt = $pdo->query("SELECT name FROM Users");
	$users = $stmt->fetchAll(PDO::FETCH_COLUMN);
	foreach ($users as $user) {
		if ($user != $name) {
			echo "<div class='user'>" . $user . "</div>";
		}
	}
}
?>
</main>
<footer>
<a href="signup.php">sign up</a>
<a href="login.php">log in</a>
<br /><br />
&copy; Ezzeldien 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>