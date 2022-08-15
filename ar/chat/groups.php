<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OurCommunity groups</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="author" content="Ezzeldien Rashad" />
	<meta name="description" content="OurCommunity groups, a community for meeting friends, sending messages, playing, etc....">
	<meta name="keywords" content="groups, community, chat, message friends, meeting, main page, playing games" />
	<script type="text/javascript" src="scripts/groups.js" defer></script>
	<script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="pictures/community_logo.webp">
	<link rel="stylesheet" href="styles/groups.css" />
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<?php 
include "header.php";
//check if user is already in a group
if (isset($_SESSION["groupName"]) && isset($_SESSION["groupToken"])) {
	$groupName = $_SESSION["groupName"];
	$groupToken = $_SESSION["groupToken"];
} elseif (isset($_COOKIE["groupToken"]) && isset($_COOKIE["groupName"])) {
	$groupName = $_COOKIE["groupName"];
	$groupToken = $_COOKIE["groupToken"];
}
if (isset($groupName) && isset($groupToken)) {
	$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
	$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9");
	$stmt = $pdo->prepare("SELECT groupToken FROM epiz_31976759_OurCommunity.Users WHERE groupName = ?");
	$stmt->execute([$groupName]);
	$resultGroupToken = $stmt->fetchColumn();
	if ($resultGroupToken == $groupToken) {
		header("Location: index.php");
		exit;
	}
}
//group signup
// Check for errors, then add the group to the database
if (isset($_POST["signupGroupSubmit"])) {
	if (strlen($_POST["signupGroupName"]) > 30) {
		$_SESSION["signupNameErr"] = "*group name too long";
	} else if (strlen($_POST["signupGroupName"]) < 3) {
		$_SESSION["signupNameErr"] = "*group name too short";
	} else if (!preg_match("/^[\w\d\s_]+$/", $_POST["signupGroupName"])) {
		$_SESSION["signupNameErr"] = "*group name has unallowed characters";
	} else {
		$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
		$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		$stmt = $pdo->prepare("SELECT 1 FROM epiz_31976759_OurCommunity.Groups WHERE groupName = ?");
		$stmt->execute([$_POST["signupGroupName"]]);
		$info = $stmt->fetch();
		if ($info) {
			$_SESSION["signupNameErr"] = "*group already exists";
		} else {
			$token = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO epiz_31976759_OurCommunity.Groups (groupName, groupPassword, groupToken)
            VALUES (?, '" . password_hash($_POST["signupGroupPassword"], PASSWORD_DEFAULT) . "', '" . $token . "')");
            $stmt->execute([$_POST["signupGroupName"]]);
            $_SESSION["groupName"] = $_POST["signupGroupName"];
            $_SESSION["groupToken"] = $token;
            setcookie("groupName", $_POST["signupGroupName"], time() + 86400 * 30, "/");
            setcookie("groupToken", $token, time() + 86400 * 30, "/");
            header("Location: index.php");
            exit;
        }
	}
}
//check for errors, then enter group
if (isset($_POST["loginGroupSubmit"])) {
	$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
	$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
	$stmt = $pdo->prepare("SELECT * FROM epiz_31976759_OurCommunity.Groups WHERE groupName = ?");
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
<main>
<?php 
if (isset($_SESSION["signupNameErr"])) { ?>
	<div class="signupNameErr">Please fix the errors below to create the group.</div>
<?php 
}
if (isset($_SESSION["loginNameErr"]) || isset($_SESSION["loginPasswordErr"])) { ?>
	<div class="loginNamePasswordErr">Please fix the errors below to join the group.</div>
<?php 
}
 ?>
<i class="fa-solid fa-share fa-2x" style="transform: rotate(180deg)"></i>
<button class="join-group">
    <span class="center">Join a Group</span>
</button>
<button class="create-group">
    <span class="center">Create a New Group</span>
</button>
<div class="join-group-method">
    <button class="enter-form">
        <span>Enter Group Name and Password</span>
    </button>
    <form name="joinGroupFields" class="join-group-fields" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <label for="loginGroupName">group name: &nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" size="30" width="30" name="loginGroupName" id="loginGroupName" placeholder="group name"/>
		<div id="loginNameErr" class="err"><?php if (isset($_SESSION["loginNameErr"])) {echo "*Wrong Group Name"; unset($_SESSION["loginNameErr"]);} ?></div>
        <br />
        <br />
        <label for="loginGroupPassword">group password: </label>
		<div class="password-cont">
            <input type="password" size="30" name="loginGroupPassword" id="loginGroupPassword" placeholder="group password"/>
			<span class="password-eye login-eye">&#128065;</span>
			<div id="loginPasswordErr" class="err"><?php if (isset($_SESSION["loginPasswordErr"])) {echo "*Wrong Password"; unset($_SESSION["loginPasswordErr"]);} ?></div>
		</div>
		<br />
        <br />
        <input type="submit" size="30" name="loginGroupSubmit" value="Enter group"/>
    </form>
    <a href="users.php?groups=true" class="show-list">
        <span>Show a List of Available Groups</span>
    </a>
</div>
<form name="createGroupFields" class="create-group-fields" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <label>
        group name: &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" size="30" width="30" name="signupGroupName" placeholder="group name"/>
    </label>
    <div id="signupNameErr" class="err"><?php if (isset($_SESSION["signupNameErr"])) {echo  $_SESSION["signupNameErr"]; unset($_SESSION["signupNameErr"]);} ?></div>
    <br />
    <label for="signupGroupPassword">group password: </label>
    <div class="password-cont">
	    <input type="password" size="30" id="signupGroupPassword" name="signupGroupPassword" placeholder="group password"/>
        <span class="password-eye signup-eye">&#128065;</span>
		<div id="passStrengthInfo" class="err"></div>
    </div>
    <br />
    <br />
    <input type="submit" size="30" name="signupGroupSubmit" value="Create group"/>
</form>

</main>
<footer>
<a href="signup.php">sign up</a>
<a href="login.php">log in</a>
<br /><br />
&copy; Ezzeldien 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>