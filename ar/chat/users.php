<?php session_start(); ?>
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
	<link rel="icon" href="pictures/community_logo.webp">
	<link rel="stylesheet" href="styles/users.css" />
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>
<main>
<?php
// show users/groups present in database
$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
if (isset($_GET["groups"]) && $_GET["groups"] == "true") {
	echo "<h2>Groups:</h2>";
	$stmt = $pdo->query("SELECT groupName FROM epiz_31976759_OurCommunity.Groups");
	$groups = $stmt->fetchAll(PDO::FETCH_COLUMN);
	foreach ($groups as $group) {
		echo "<div class='user'>" . $group . "</div>";
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