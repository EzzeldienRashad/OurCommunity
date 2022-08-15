<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
	<title>مجتمعنا</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="عزالدين رشاد" />
	<meta name="description" content="موقع مجتمعنا للعب ومقابلة اﻷصدقاء وغير ذلك الكثير">
	<meta name="keywords" content="مجتمع, شات, مراسلة اﻷصدقاء, مجموعات, ألعاب" />
	<script type="text/javascript" src="scripts/index.js" defer></script>
	<script type="text/javascript" src="scripts/table.js" defer></script>
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
	<link rel="stylesheet" href="styles/table.css" />
</head>
<body>
    <header>
        <div class="logo-header">
            <img src="../images/mainImages/logo.webp" alt="شعار مجتمعنا" width="150" height="120" />
            <h1>
                مجتمعنا
                <br />
                <span class="green">للعب ومراسلة اﻷصدقاء</span>
            </h1>
            <a href="../en" class="switch-lang" hreflang="en">English</a>
        </div>
        <div class="menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav>
            <a href="index.php">الرئيسية</a>
            <span class="disabled">خدماتنا</span>
            <a href="about.php">عن الموقع</a>
            <a href="contact.php">اتصل بنا</a>
        </nav>
    </header>
    <main>
        <h2> خدمات موقع مجتمعنا </h2>
        <table class="items-table">
            <tbody>
                <?php
                include "../functions/loadItems.php";
                loadItems("services.json", "ar", "../");
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">عن الموقع</a>
            <a href="contact.php">اتصل بنا</a>
            <a href="../en" class="fleft" hreflang="en">English</a>
        </div>
        <div class="footer-info">
            حقوق النشر محفوظة لموقع مجتمعنا @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>