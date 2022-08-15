<?php
session_start();
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

//check if user isn't in a group
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
	$stmt = $pdo->prepare("SELECT groupToken FROM epiz_31976759_OurCommunity.Groups WHERE groupName = ?");
	$stmt->execute([$groupName]);
	$resultGroupToken = $stmt->fetchColumn();
	if (!$resultGroupToken || $resultGroupToken != $groupToken) {
		header("Location: login.php");
		exit;
	}
} else {
	header("location: login.php");
	exit;
}

//echo comments
function filterComments($arr) {
	global $groupName;
	return $arr["groupName"] == $groupName;
}
$dsn = "mysql:host=localhost;dbname=epiz_31976759_OurCommunity";
$pdo = new PDO($dsn, "epiz_31976759", "xhb1FTZFr4SdTM9", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
$stmt = $pdo->prepare("SELECT * FROM epiz_31976759_OurCommunity.Comments where groupName = ?");
$stmt->execute([$groupName]);
$comments = $stmt->fetchAll();
if ($comments) {
    $maxCommentsNum = 50;
    if (count(array_filter($comments, "filterComments")) > $maxCommentsNum) {
        $extraCommentId = array_filter($comments, "filterComments")[0]["id"];
        mysqli_query($commentsConn, "DELETE FROM epiz_31976759_OurCommunity.Comments WHERE id = $extraCommentId");
    }
	uasort($comments, function ($a, $b) {
		return (($a["id"] < $b["id"]) ? 1 : -1);
	});
    echo json_encode(array_values($comments));
} else {
    echo "[]";
}

?>