<?php
session_start();
// Check if the user is signed in
$signedIn = false;
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
	if ($resultToken && $resultToken == $token) {
		$signedIn = true;
	}
}
// log user out if they press logout
if (isset($_POST["logout"])) {
	unset($_SESSION["name"]);
	unset($_SESSION["token"]);
	unset($_SESSION["groupName"]);
	unset($_SESSION["groupToken"]);
	setcookie("name", "", time() - 3600, "/");
	setcookie("token", "", time() - 3600, "/");
	setcookie("groupName", "", time() - 3600, "/");
	setcookie("groupToken", "", time() - 3600, "/");
    $signedIn = false;
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
    <script src="scripts/index.js" defer></script>
    <script src="https://kit.fontawesome.com/5cf0e9fc67.js" crossorigin="anonymous"></script>
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
</head>
<body>
    <header>
        <div class="menu-cont">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            القائمة
        </div>
        <nav>
            <span class="disabled">الرئيسية</span>
            <a href="services.php">خدماتنا</a>
            <a href="about.php">عن الموقع</a>
            <a href="contact.php">اتصل بنا</a>
            <a href="../en" hreflang="en" lang="en">English</a>
            <button class="login-menu-button">
                <?php
                if ($signedIn) {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../images/users/user.png' width='40' height='40'/>";
                } else {
                    echo "<i class='fa-solid fa-caret-down fa-2xl'></i><img src='../images/users/anonymous.png' width='40' height='40'/>";
                }
                ?>
            </button>
            <div class="login-menu hidden">
                <?php
                if ($signedIn) {
                    echo "
                    <div>$name</div>
                    <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' >
                        <input type='submit' name='logout' value='تسجيل الخروج' />
                    </form>
                    ";
                } else {
                    echo "<a href='message/login.php?page=main'>تسجيل الدخول</a>";
                }
                ?>
            </div>
        </nav>
    </header>
    <main>
        <section id="slider">
            <div class="slider-description">
                <div class="slider-progress">
                    <div class="progress-bar">
                        <progress value="0" max="100"></progress>
                        <progress value="0" max="100"></progress>
                        <progress value="0" max="100"></progress>
                    </div>
                </div>
                <div class="descriptions">
                    <div class="description">
                        <h1>يمكنك اللعب, الدردشة مع اﻷصدقاء, وغير ذلك الكثير!</h1>
                    </div>
                    <div class="description">
                        <h1>أفضل موقع لمحاربة الملل واﻹستمتاع بالوقت!</h1>
                    </div>
                    <div class="description">
                        <h1>أهلًا بك فى مجتمعنا!</h1>
                    </div>
                </div>
            </div><div class="moving-slider">
                <div class="pics-cont">
                    <a href="services.php">
                        <img src="../images/mainImages/logo.webp" alt="مجتمعنا" width="400" height="320" />
                    </a>
                    <a href="games">
                        <img src="../images/mainImages/games.webp" alt="لعب" width="400" height="320" />
                    </a>
                    <a href="message">
                        <img src="../images/mainImages/message.webp" alt="شات" width="400" height="320" />
                    </a>
                    <a href="services.php">
                        <img src="../images/mainImages/logo.webp" alt="مجتمعنا" width="400" height="320" />
                    </a>
                </div>
            </div>
        </section>
        <section id="services">
            <img src="../images/mainImages/services.webp" width="300" height="300" alt="خدماتنا" />
            <div class="services-desc">
                <p>
                    أهلًا فى مجتمعنا, الخيار اﻷفضل للعب ومقابلة اﻷصدقاء!
                    فى هذا الموقع, نقدم العديد من المميزات لتستطيع التغلب على الملل والتحدث مع أصدقائك من أى مكان.
                    يمكنك اﻹختيار من بين العديد من الخيارات لقضاء وقتك بأفضل صورة ممكنة.
                    نقوم دائمًا بتطوير أنفسنا من أجل تقديم أفضل خدمة للمستخدمين.
                </p>
            </div>
        </section>
        <h2 id="offers-title">ما نقدمه</h2>
        <section id="offers">
            <a class="offer" href="message">
                <div class="offer-pic">
                    <i class="fa-solid fa-comment"></i>
                </div>
                <span class="offer-title">شات</span>
                <p class="offer-desc">
                    نظام دردشة فورى يتيح التواصل مع أى شخص حول العالم, باﻹضاقة ﻹمكانية إرسال اﻹيميلات, اﻹعجاب بتعليق أو حذفه, 
                    أو التعليق على تعليق آخر.
                </p>
            </a>
            <a class="offer" href="games">
                <div class="offer-pic">
                    <i class="fa-solid fa-gamepad" ></i>
                </div>
                <span class="offer-title">اﻷلعاب</span>
                <p class="offer-desc">
                    هناك العديد من اﻷلعاب التى يقدمها الموقع, مما يتيح لك القضاء على الملل واﻹستمتاع بوقتك.
                </p>
            </a>
            <div class="offer">
                <div class="offer-pic">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="offer-title">المستخدمين</span>
                <p class="offer-desc">
                    يمكنك الذهاب لقسم المستخدمين والعثور على أصدقائك ومحادثتهم فى غرف خاصة.
                </p>
            </div>
        </section>

        <section id="faq">
            <h2>اﻷسئلة الشائعة</h2>
            <div class="faq-col1">
                <button class="accordion">هل هذا الموقع آمن؟<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>هذا الموقع آمن ومؤمن ومحمى ﻷقصى درجة, وﻻ يمكن ﻷى هاكر فى العالم اختراقه مهما كانت قدراته(أو على اﻷقل حتى اﻵن....)</p>
                </div>
                <button class="accordion">هل هذا الموقع جيد؟<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>ما الذى تتحدث عنه! هذا الموقع هو أفضل موقع فى هذا العالم وإلى اﻷبد!!!!!!.</p>
                </div>
            </div>
            <div class="faq-col2">
                <button class="accordion">كم لعبة فى هذا الموقع؟<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>فى هذا الموقع عدد ﻻ نهائى من اﻷلعاب.</p>
                </div>
                <button class="accordion">هل هذا الموقع يتطور دائمًا؟<i class="fa-solid fa-chevron-down"></i></button>
                <div class="answer">
                    <p>نعم. نعم. إنه يتطور كل يوم. كل دقيقة. كل ثانية. إنه يتطور دائمًا وإلى اﻷبد. إلى اﻷبد.</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">عن الموقع</a>
            <a href="contact.php">اتصل بنا</a>
            <a href="../en" class="fleft" hreflang="en" lang="en">English</a>
        </div>
        <div class="footer-info">
            حقوق النشر محفوظة لموقع مجتمعنا @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>