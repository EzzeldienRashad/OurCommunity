<?php 
include "header.php";
//check if user isn't in a group
if (isset($_SESSION["groupName"]) && isset($_SESSION["groupToken"])) {
	$groupName = $_SESSION["groupName"];
	$groupToken = $_SESSION["groupToken"];
} elseif (isset($_COOKIE["groupToken"]) && isset($_COOKIE["groupName"])) {
	$groupName = $_COOKIE["groupName"];
	$groupToken = $_COOKIE["groupToken"];
}
if (isset($groupName) && isset($groupToken)) {
	$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
	$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
	$stmt = $pdo->prepare("SELECT groupToken, owner FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
	$stmt->execute([$groupName]);
	$info = $stmt->fetch();
	if ($info) {
		$resultGroupToken = $info["groupToken"];
		if (!$resultGroupToken || $resultGroupToken != $groupToken) {
			header("Location: groups.php");
			exit;
		} else {
			$owner = $info["owner"] == $name;
		}
	}
} else {
	header("location: groups.php");
	exit;
}
if (!$owner) {
    die("عفوًا, فقط مشرف المجموعة \"" . $info["owner"] . "\" يمكنه تعديلها.");
}
if (isset($_GET["gDelete"])) {
	// Delete group
	$stmt = $pdo->prepare("DELETE FROM b16_32390973_OurCommunity.Comments WHERE groupName = ?");
	$stmt->execute([$groupName]);
	$stmt = $pdo->prepare("DELETE FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
	$stmt->execute([$groupName]);
	unset($_SESSION["groupName"]);
	unset($_SESSION["groupToken"]);
	setcookie("groupName", "", time() - 3600, "/");
	setcookie("groupToken", "", time() - 3600, "/");
	header("location: groups.php");
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
	<title>مجتمعنا إعدادات المجموعة</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="عزالدين رشاد" />
	<meta name="description" content="موقع مجتمعنا للعب ومقابلة اﻷصدقاء وغير ذلك الكثير">
	<meta name="keywords" content="مجتمع, شات, مراسلة اﻷصدقاء, مجموعات, ألعاب" />
	<script type="text/javascript" src="scripts/header.js" defer></script>
	<script type="text/javascript" src="scripts/settings.js" defer></script>
	<script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="stylesheet" href="styles/settings.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
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
	<a href="../">الصفحة الرئيسية</a>
	<a href="users.php">مستخدمين آخرين</a>
	<a href="users.php?groups=true">المجموعات</a>
	<form class="logout" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">  
		<input type="submit" name="logout" value="تسجيل خروج" />
	</form>
	<form class="logout" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">  
		<input type="submit" name="groupLogout" value="الخروج من المجموعة" />
	</form>
</div>
</header>
<main>
<section class="danger-section">
	<form id="delete-form" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    	<input type="submit" class="delete" name="gDelete" value="حذف المجموعة" />
	</form>
</section>
</main>
<footer>
<a href="signup.php">sign up</a>
<a href="login.php">log in</a>
<br /><br />
&copy; Ezzeldien 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>
