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
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
    <style>
        main {
            padding: 50px;
            text-align: right;
        }
        h2 {
            text-align: right;
        }
        table {
            table-layout: auto;
        }
        table, td, th {
            text-align: right;
        }
        th {
            padding: 5px;
            width: 1px;
            white-space: nowrap;
        }
        .align-top {
            vertical-align: top;
        }
        .map {
            width: 45vw;
            height: 35vw;
        }
        @media only screen and (max-width: 490px) {
            main {
                padding: 10px;
            }
        }
    </style>
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
            <a href="services.php">خدماتنا</a>
            <a href="about.php">عن الموقع</a>
            <span class="disabled">اتصل بنا</span>
        </nav>
    </header>
    <main>
        <h2 class="green">اتصل بنا</h2>
        <table>
            <tbody>
                <tr>
                    <th>جوال:</th>
                    <td>المواقع ﻻ تملك هواتف</td>
                </tr>
                <tr>
                    <th>بريد إلكتروني:</th>
                    <td>نحتاج إلى روبوت ليوصله</td>
                </tr>
                <tr>
                    <th>صندوق بريد:</th>
                    <td>بريد نائم وﻻ أجد صندوقه</td>
                </tr>
                <tr>
                    <th>العنوان:</th>
                    <td>شبكة اﻹنترنت</td>
                </tr>
                <tr>
                    <th class="align-top">الخريطة:</th>
                    <td>
                        <img class="map" src="../images/mainImages/map.webp" alt="خريطة" width="300" height="150" />
                    </td>
                </tr>
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