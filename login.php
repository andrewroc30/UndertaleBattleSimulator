<?php
include 'includes/db.php';
session_start();
ob_start();
$errorMessage = "";

if(isset($_POST['email'])){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if(strlen($email)<3){
        $errorMessage .= "enter an email <br />";
    }
    if(strlen($password)<3){
        $errorMessage .= "enter a password <br />";
    }
    if(strlen($errorMessage) === 0){
        $query = "SELECT * FROM `users` WHERE `password` = '" . $password ."'AND `email` = '" . $email . "'";
        if($result = mysqli_query($mysqli,$query)){
            $numRowsSelected = mysqli_num_rows($result);
            if($numRowsSelected === 1){
                $row = mysqli_fetch_assoc($result);
                $_SESSION['name'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header('Location:  http://localhost/UndertaleBattleSimulator/GameIndex.php');
            }
            else{
                $errormessage .= '<br /> Invalid Email or Password';
            }
        }
        echo $result;
        echo $errormessage;
    }
}


?>



<!DOCTYPE html>
<html>
    <title>Registration Form</title>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script  src="https://code.jquery.com/jquery-2.2.4.min.js" ></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <head>
    </head>

    <body>
        <h1>Login</h1>

        <script>
            function RedirectIndex() {
                window.location="http://localhost/UndertaleBattleSimulator/index.php";
            }
            function RedirectDash() {
                window.location="http://localhost/UndertaleBattleSimulator/dashboard.php";
            }
            $(document).ready(function(){
                $("#regform").submit(function(event) {

                    $('#test').hide();
                    $('#test').val('');

                    $('.feedback').html('');

                    var formOk = true;

                    var password = $('.password').val();
                    var email = "" + $.trim($('.email').val());


                    if(formOk == false)
                        event.preventDefault();
                    else
                        $('#test').val(1);
                });
            })
        </script>

        <div class="feedback"></div>

        <form method="post" id="regform">
            Password: <input type="password" name="password" placeholder="Enter your Password" class="password" required/>
            <br />
            Email: <input type="email" name="email" placeholder="Enter your Email" class="email" required/>
            <br />

            <input type="submit" id="submit" value="Click to Submit" />
            <input type="hidden" id="test" name="test" visibility="hidden" />
            <input type="button" value="Go to Registration" onclick="RedirectIndex();" />
            <input type="button" value="Change your Password" onclick="RedirectDash();" />

        </form>


    </body>
</html>