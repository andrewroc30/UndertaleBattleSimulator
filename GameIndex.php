<?php
include 'includes/db.php';
session_start();
ob_start();

if(isset($_SESSION['name'])==false){
    header('Location:  http://localhost/UndertaleBattleSimulator/forbidden.php');
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="mobile-web-app-capable" content="yes">
        <!-- LOOK AT UP AND RUNNING WITH PHONEGAP BUILD (CHRIS GRIFFITH) -->
        <meta name="viewport" content="width=device-width">
        <link rel="icon" sizes="196x196" href="images/UndertaleHeartEdited.png">
        <script  src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>
        <title>Undertale Battle Simulator</title>
        <script src="libs/phaser.js"></script>
        <script src="Boot.js"></script>
        <script src="Preloader.js"></script>
        <script src="StartMenu.js"></script>
        <script src="Game.js"></script>
        <style>
            body{
                padding: 0;
                margin: 0;
                background-color: #000000;
            }
        </style>
    </head>
    <body>
        <!--<div class="overlay">

<input type="text">
</div>-->
        <!--<div id="gameContainer" style="display:none"></div>-->
        <script type="text/javascript">
            window.onload = function(){
                var game = new Phaser.Game(1600, 800, Phaser.AUTO, 'gameContainer');
                game.state.add('Boot', UndertaleBattleSimulator.Boot);
                game.state.add('Preloader', UndertaleBattleSimulator.Preloader);
                game.state.add('StartMenu', UndertaleBattleSimulator.StartMenu);
                game.state.add('Game', UndertaleBattleSimulator.Game);
                game.state.start('Boot');
            }
        </script>
    </body>
</html>