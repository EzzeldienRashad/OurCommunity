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
	$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
	$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G");
	$stmt = $pdo->prepare("SELECT groupToken FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
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
		$_SESSION["signupNameErr"] = "اسم المجموعة طويل جدًا*";
	} else if (strlen($_POST["signupGroupName"]) < 3) {
		$_SESSION["signupNameErr"] = "اسم المجموعة قصير جدًا*";
	} else if (!preg_match("/^[\w\d\s_]+$/", $_POST["signupGroupName"])) {
		$_SESSION["signupNameErr"] = "عفوًا, غير مسموح برموز خاصة*";
	} else {
		$dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
		$pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		$stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Groups WHERE groupName = ?");
		$stmt->execute([$_POST["signupGroupName"]]);
		$info = $stmt->fetch();
		if ($info) {
			$_SESSION["signupNameErr"] = "المجموعة موجودة بالفعل*";
		} else {
			$token = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO b16_32390973_OurCommunity.Groups (groupName, groupPassword, groupToken, owner)
            VALUES (?, '" . password_hash($_POST["signupGroupPassword"], PASSWORD_DEFAULT) . "', '" . $token . "', ?)");
            $stmt->execute([$_POST["signupGroupName"], $name]);
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
<html lang="ar" dir="rtl">
<head>
	<title>مجتمعنا</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="عزالدين رشاد" />
	<meta name="description" content="موقع مجتمعنا للعب ومقابلة اﻷصدقاء وغير ذلك الكثير">
	<meta name="keywords" content="مجتمع, شات, مراسلة اﻷصدقاء, مجموعات, ألعاب" />
	<script type="text/javascript" src="scripts/groups.js" defer></script>
	<script type="text/javascript" src="scripts/header.js" defer></script>
	<link rel="stylesheet" href="../../assets/fontawesome/css/fontawesome.css"/>
    <link rel="stylesheet" href="../../assets/fontawesome/css/brands.css"/>
    <link rel="stylesheet" href="../../assets/fontawesome/css/solid.css"/>
	<link rel="icon" href="../../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/groups.css" />
	<link rel="stylesheet" href="styles/header-footer.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Lusitana&display=swap" rel="stylesheet">
</head>
<body>
<header>
<span class="decoration"></span>
<a href="../"><h1>مجتمعنا</h1></a>
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
<?php 
if (isset($_SESSION["signupNameErr"])) { ?>
	<div class="signupNameErr">برجاء إصلاح اﻷخطاء باﻷسفل ﻹنشاء المجموعة.</div>
<?php 
}
if (isset($_SESSION["loginNameErr"]) || isset($_SESSION["loginPasswordErr"])) { ?>
	<div class="loginNamePasswordErr">برجاء إصلاح اﻷخطاء باﻷسفل للدخول إلى المجموعة.</div>
<?php 
}
 ?>
<i class="fa-solid fa-share fa-2x" style="transform: rotate(180deg)"></i>
<button class="join-group">
    <span class="center">الدخول إلى مجموعة</span>
</button>
<button class="create-group">
    <span class="center">إنشاء مجموعة</span>
</button>
<div class="join-group-method">
    <button class="enter-form">
        <span>أدخل اﻹسم وكلمة السر</span>
    </button>
    <form name="joinGroupFields" class="join-group-fields" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <label for="loginGroupName">اسم المجموعة: &nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="text" size="30" width="30" name="loginGroupName" id="loginGroupName" placeholder="اسم المجموعة"/>
		<div id="loginNameErr" class="err"><?php if (isset($_SESSION["loginNameErr"])) {echo "اسم خاطئ*"; unset($_SESSION["loginNameErr"]);} ?></div>
        <br />
        <br />
        <label for="loginGroupPassword">كلمة سر المجموعة: </label>
		<div class="password-cont">
            <input type="password" size="30" name="loginGroupPassword" id="loginGroupPassword" placeholder="كلمة سر المجموعة"/>
			<span class="password-eye login-eye">&#128065;</span>
			<div id="loginPasswordErr" class="err"><?php if (isset($_SESSION["loginPasswordErr"])) {echo "*كلمة سر خاطئة"; unset($_SESSION["loginPasswordErr"]);} ?></div>
		</div>
		<br />
        <br />
        <input type="submit" size="30" name="loginGroupSubmit" value="Enter group"/>
    </form>
    <a href="users.php?groups=true" class="show-list">
        <span>المجموعات المتاحة</span>
    </a>
</div>
<form name="createGroupFields" class="create-group-fields" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <label>
        اسم المجموعة: &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" size="30" width="30" name="signupGroupName" placeholder="اسم المجموعة"/>
    </label>
    <div id="signupNameErr" class="err"><?php if (isset($_SESSION["signupNameErr"])) {echo  $_SESSION["signupNameErr"]; unset($_SESSION["signupNameErr"]);} ?></div>
    <br />
    <label for="signupGroupPassword">كلمة سر المجموعة: </label>
    <div class="password-cont">
	    <input type="password" size="30" id="signupGroupPassword" name="signupGroupPassword" placeholder="كلمة سر المجموعة"/>
        <span class="password-eye signup-eye">&#128065;</span>
		<div id="passStrengthInfo" class="err"></div>
    </div>
    <br />
    <br />
    <input type="submit" size="30" name="signupGroupSubmit" value="أنشئ المجموعة"/>
</form>

</main>
<footer>
<a href="signup.php">إنشاء حساب</a>
<a href="login.php">تسجيل الدخول</a>
<br /><br />
&copy; جميع الحقوق محفوظة لمجتمعنا 2022 - <?php echo date("Y") ?>
</footer>
</body>
</html>