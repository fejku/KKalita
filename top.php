<?php
    require './common.php';
    require './pomocnicze/funkcje.php'
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="./style/styl.css" />
        <script type="text/javascript" src="jquery-2.0.3.min.js"></script>
        <title></title>
    </head>
    <body>
        <div id="pasekGora">
            <div id="logowanie">
                <?php 
                    if(Zalogowany())
                    {
                        echo 'Witaj '.$_SESSION['user']['username'];
                        echo '<a href="logout.php">Wyloguj</a>';
                    }
                    else
                    {
                        echo "<a href=\"login.php?skad=".basename($_SERVER['REQUEST_URI'])."\">Zaloguj</a>";
                    }
                ?>
            </div>
        </div>
        <div id="glowny">
            <div id="logo">
                <a href="index.php"></a>
            </div>
            <div id="menu">
                <ul>
                    <li><a href="index.php">Strona główna</a></li>
                    <li><a href="zainteresowania.php">Zainteresowania</a></li>
                    <li><a href="projekty.php">Moje projekty</a></li>
                    <li><a href="inneStrony.php">Moje inne strony</a></li>
                    <li><a href="cv.php">CV</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                </ul>
            </div>
            <div id="zawartosc">