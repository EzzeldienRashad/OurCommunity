<?php 
session_start();
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
	$stmt = $pdo->prepare("SELECT groupToken FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
	$stmt->execute([$groupName]);
	$resultGroupToken = $stmt->fetchColumn();
	if (!$resultGroupToken || $resultGroupToken != $groupToken) {
		header("Location: groups.php");
		exit;
	}
} else {
	header("location: groups.php");
	exit;
}

//add commenting functionality
if (isset($_POST["comment"])) {
	$commentText = $_POST["commentText"] != "" ? $_POST["commentText"] : "\r\n";
	$date = date("Y:m:d H:i:s");
	$commentStmt = $pdo->prepare("INSERT INTO b16_32390973_OurCommunity.Comments (name, body, date, lovers, comments, groupName) VALUES (?, ?, ?, '[]', '[]', ?)");
	$commentStmt->execute([$name, $commentText, $date, $groupName]);
}
//add delete comments functionality
if (isset($_GET["deleteCommentId"])) {
	$delStmt = $pdo->prepare("DELETE FROM b16_32390973_OurCommunity.Comments WHERE name = '" . $name . "' and id = ?");
	$delStmt->bindParam(1, $_GET["deleteCommentId"], PDO::PARAM_INT);
	$delStmt->execute();
}
// add love comments functionality
if (isset($_GET["loveCommentId"])) {
	$loversResultStmt = $pdo->prepare("SELECT lovers FROM b16_32390973_OurCommunity.Comments where id = ? and name != ?");
	$loversResultStmt->bindParam(1, $_GET["loveCommentId"], PDO::PARAM_INT);
	$loversResultStmt->bindParam(2, $name);
	$loversResultStmt->execute();
	$lovers = $loversResultStmt->fetchColumn();
	if ($lovers) {
		$lovers = json_decode($lovers);
		if (($key = array_search($name, $lovers)) !== false) {
			unset($lovers[$key]);
		} else {
			array_push($lovers, $name);
		}
		$newLovers = json_encode(array_values($lovers));
		$loversStmt = $pdo->prepare("UPDATE b16_32390973_OurCommunity.Comments SET lovers = '$newLovers' WHERE id = ?");
		$loversStmt->bindParam(1, $_GET["loveCommentId"], PDO::PARAM_INT);
		$loversStmt->execute();
	}
}
//add comment to comment functionality
if (isset($_POST["c2cSubmit"]) && isset($_GET["c2cId"])) {
	$c2cStmt = $pdo->prepare("SELECT comments FROM b16_32390973_OurCommunity.Comments WHERE id = ?");
	$c2cStmt->bindParam(1, $_GET["c2cId"], PDO::PARAM_INT);
	$c2cStmt->execute();
	$c2cs = $c2cStmt->fetch();
	if ($c2cs) {
		$c2cs = json_decode(str_replace("\r\n", "\\r\\n", $c2cs["comments"]));
		array_push($c2cs, "$name:" . $_POST["c2cContent"]);
		$newC2cs = json_encode(array_values($c2cs));
		$stmt = $pdo->prepare("UPDATE b16_32390973_OurCommunity.Comments SET comments = ? WHERE id = ?");
		$stmt->bindParam(1, $newC2cs);
		$stmt->bindParam(2, $_GET["c2cId"], PDO::PARAM_INT);
		$stmt->execute();
	}
}
//add delete c2cs functionality
if (isset($_GET["deleteC2cParentId"]) && isset($_GET["deleteC2cId"])) {
	$delStmt = $pdo->prepare("Select comments FROM b16_32390973_OurCommunity.Comments WHERE id = ?");
	$delStmt->bindParam(1, $_GET["deleteC2cParentId"], PDO::PARAM_INT);
	$delStmt->execute();
	$c2cs = $delStmt->fetchColumn();
	$c2cs = json_decode(str_replace("\r\n", "\\r\\n", $c2cs), true);
	array_splice($c2cs, $_GET["deleteC2cId"], 1);
	$c2cs = json_encode(array_values($c2cs));
	$delStmt = $pdo->prepare("UPDATE b16_32390973_OurCommunity.Comments SET comments = ? WHERE id = ?");
	$delStmt->bindParam(1, $c2cs);
	$delStmt->bindParam(2, $_GET["deleteC2cParentId"], PDO::PARAM_INT);
	$delStmt->execute();
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
	<script type="text/javascript" src="scripts/header.js" defer></script>
	<script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<header>
<span class="decoration"></span>
<h1>مجتمعنا</h1>
<div class="hello">أهلًا, <span><?php echo $name; ?></span>!</div>
<div class="menu">
	<span></span>
	<span></span>
	<span></span>
</div>
<div class="dropdown">
<a href="../">الصفحة الرئيسية</a>
<a href="index.php">غرفة المحادثة</a>
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

<button class="add-comment">+ اضافة تعليق</button>
<form class="new-comment" aria-hidden="true" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
	<textarea name="commentText"></textarea>
	<input class="add-comment-btn" type="submit" name="comment" value="+اضافة" />
</form>
<div class="comments-cont"></div>
<button class="more-comments">المزيد من التعليقات</button>

</main>
<footer>
<a href="signup.php">إنشاء حساب</a>
<a href="login.php">تسجيل الدخول</a>
<br /><br />
&copy; جميع الحقوق محفوظة لمجتمعنا 2022 - <?php echo date("Y") ?>
</footer>
<?php include "scripts/indexScript.php" ?>
</body>
</html>