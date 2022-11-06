<?php
session_start();
if (!isset($_POST["credential"]) || !isset($_POST["g_csrf_token"])) {
    header("location: login.php");
}
$cCsrfToken = $_COOKIE["g_csrf_token"];
$pCsrfToken = $_POST["g_csrf_token"];
if (!$cCsrfToken || !$pCsrfToken || $cCsrfToken != $pCsrfToken) {
    header("location: login.php");
} else {
    require_once "vendor/autoload.php";
    $client = new Google_Client(["client_id" => "368121326006-dm1as132picum16rhrve2dfnf2fv57p4.apps.googleusercontent.com"]);
    $payload = $client->verifyIdToken($_POST["credential"]);
    if ($payload) {
        $dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
        $pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
        $stmt = $pdo->prepare("SELECT * FROM b16_32390973_OurCommunity.Users WHERE email = ?");
        $stmt->execute([$payload["email"]]);
        $info = $stmt->fetch();
        if ($info) {
			$token = bin2hex(random_bytes(16));
			$pdo->query("UPDATE b16_32390973_OurCommunity.Users SET token = '" . $token . "' WHERE id = " . $info["id"]);
			$_SESSION["name"] = $info["name"];
			$_SESSION["token"] = $token;
			setcookie("name", $info["name"], time() + 86400 * 30, "/");
			setcookie("token", $token, time() + 86400 * 30, "/");
			header("Location: index.php");
			exit;
        } else {
            $username = (strlen($payload["given_name"] . " " . $payload["family_name"]) <= 30) ? ($payload["given_name"] . " " . $payload["family_name"]) : $payload["given_name"];
            $_SESSION["name"] = $username;
            $_SESSION["email"] = $payload["email"];
            $dsn = "mysql:host=localhost;dbname=b16_32390973_OurCommunity";
            $pdo = new PDO($dsn, "b16_32390973", "1e2z3z4e5l@G", array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));	
            $stmt = $pdo->prepare("SELECT 1 FROM b16_32390973_OurCommunity.Users WHERE name = ?");
            $stmt->execute([$username]);
            $row = $stmt->fetch();
            if ($row) {
                $_SESSION["nameErr"] = "*name already used by another user";
            }
            header("location: signup.php");
        }
    } else {
        header("location: login.php");
    }
}