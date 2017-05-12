<?php
include 'includes/db.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome</title>

        <script  src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <style>
        </style>

    </head>

    <body>
        <script>
            function RedirectDash() {
                window.location="http://localhost/registrationform/dashboard.php";
            }
            function RedirectNormReg() {
                window.location="http://localhost/registrationform/index.php";
            }
        </script>
        <div class='container'>
            <h1>Welcome! <?php  echo $_SESSION['name'];  ?></h1>
            <pre>
                Your Registration Was Completed!!!  Congrats boi!!!
            </pre>
            <input type="button" value="Go to Registration" onclick="RedirectNormReg();" />
            <input type="button" value="Change your Password" onclick="RedirectDash();" />
        </div>
    </body>
</html>