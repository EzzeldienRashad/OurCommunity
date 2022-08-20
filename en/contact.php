<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<title>OurCommunity</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="Ezzeldien Rashad" />
	<meta name="description" content="OurCommunity website for playing, meeting friends and a lot more">
	<meta name="keywords" content="community, chat, message friends, meeting, playing games" />
	<script type="text/javascript" src="scripts/index.js" defer></script>
	<link rel="icon" href="../images/mainImages/logo.webp">
	<link rel="stylesheet" href="styles/index.css" />
    <style>
        main {
            padding: 50px;
            text-align: left;
        }
        h2 {
            text-align: left;
        }
        table {
            table-layout: auto;
        }
        table, td, th {
            text-align: left;
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
            width: 50vw;
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
            <img src="../images/mainImages/logo.webp" alt="OurCommunity-logo" width="150" height="120" />
            <h1>
                OurCommunity
                <br />
                <span class="green">for playing and meeting friends</span>
            </h1>
            <a href="../ar" class="switch-lang" hreflang="ar">العربية</a>
        </div>
        <div class="menu-cont">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            menu
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="about.php">about</a>
            <a href="customers.php">Users</a>
            <span class="disabled">Contact Us</span>
        </nav>
    </header>
    <main>
        <h2 class="green"> Contact OurCommunity</h2>
        <table>
            <tbody>
                <tr>
                    <th>Mobile :</th>
                    <td>Websites don't have phones</td>
                </tr>
                <tr>
                    <th>Email :</th>
                    <td>There's no one to answer emails, so.....</td>
                </tr>
                <tr>
                    <th>Address :</th>
                    <td>A planet in the universe called Earth</td>
                </tr>
                <tr>
                    <th class="align-top">Map :</th>
                    <td>
                        <img class="map" src="../images/mainImages/map.webp" alt="map" width="300" height="150" />
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        <div class="footer-links">
            <a href="about.php">about</a>
            <a href="contact.php">Contact Us</a>
            <a href="../ar" class="fright" hreflang="ar">العربية</a>
        </div>
        <div class="footer-info">
        All rights reserved for OurCommunity @ 2022 - <?php echo date("Y") ?>
        </div>
    </footer>
</body>
</html>