<?php
include 'includes/db.php';
session_start();
ob_start();

$errorMessage = "";
$output = "";

if(isset($_SESSION['name'])==false){
    header('Location:  http://localhost/UndertaleBattleSimulator/forbidden.php');
}
else{
    $name = $_SESSION['name'];
    if(isset($_POST['password'])){
        if(!($_POST['password'] == $_POST['password2'])){
            echo "<div class='alert alert-warning'>Passwords must match!</div>";
            $errorMessage .= "Passwords must match! <br />";
        }
        if(strlen($_POST['password']) < 5){
            echo "<div class='alert alert-warning'>Password must be at least 5 characters long!</div>";
            $errorMessage .= "Password must be at least 5 characters long! <br />";
        }
        elseif(strlen($_POST['password']) > 4 && ($_POST['password'] == $_POST['password2'])){
            //echo 'Your new password is: <strong>' . $_POST['password'] . '</strong> <br />';
        }
    }

    if(isset($_POST['test'])){
        $password = $_POST['password'];
        $newpassword = sha1($password);
        $email = $_SESSION['email'];
        echo '<br /> We should register this user! <br />';	
        $query = "UPDATE `users` SET `password`= '" . $newpassword . "' WHERE `email` = '" . $email . "';";
        if(mysqli_query($mysqli, $query)){
            echo "New Password Created Succesfully <br />";
            echo "Affected rows:  " . mysqli_affected_rows($mysqli);
            if(mysqli_affected_rows($mysqli) == 1){
                $_SESSION['password'] = $newpassword;
                $_SESSION['name'] = $name;
                //$_SESSION['email'] = $email;
                //header('Location:  http://localhost/registrationform/welcome.php');
                //die($query);
            }
        }
        else{
            echo "Error:  " . $query . "<br />" . mysqli_error($mysqli);
        }
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
        <h1>Update Password</h1>

        <div class="well">
            <?php
            if(strlen($errorMessage)>0){
                echo '<div class="alert alert-warning">' . $errorMessage . '</div>';
            }
                //echo $output;
            ?>
        </div>
       
        <script>
            function RedirectNormReg() {
                window.location="http://localhost/UndertaleBattleSimulator/index.php";
            }
            function RedirectLogin() {
                window.location="http://localhost/UndertaleBattleSimulator/login.php";
            }
            $('document').ready(function(){
                $(".password").on('change',function(){
                    var p = $('.password').val();
                    var p2 = $('.password2').val();
                    if(!(p === p2) && !(p2 === "")){
                        alert("Passwords must match!");
                    }
                    if(p.length<5){
                        alert("Password must be at least 5 characters long!");
                    }
                });

                $(".password2").on('change',function(){
                    var p = $('.password').val();
                    var p2 = $('.password2').val();
                    if(!(p === p2) && !(p2 === "")){
                        alert("Passwords must match!");
                    }
                    if(p.length<5){
                        alert("Password must be at least 5 characters long!");
                    }
                });


                $("#regform").submit(function(event) {

                    $('#test').hide();
                    $('#test').val('');

                    $('.feedback').html('');

                    var formOk = true;

                    var password = $('.password').val();
                    var password2 = $('.password2').val();

                    if(password.length !== 0){
                        if(!(password === password2)){
                            $('.feedback').append("<div class='alert alert-warning'>Passwords must match!</div>");
                            formOk = false;
                        }
                        if(password.length < 5){
                            $('.feedback').append("<div class='alert alert-warning'>Password must be at least 5 characters long!</div>");
                            formOk = false;
                        }
                        else if(password.length > 4 && (password === password2)){
                            $('.feedback').append('Your password is: <strong>' + password + '</strong> <br />');
                        }
                    }

                    if(formOk == false)
                        event.preventDefault();
                    else
                        $('#test').val(1);
                });
            });
        </script>

        <?php
        /*if(isset($_POST['password'])){
            if(!($_POST['password'] == $_POST['password2'])){
                echo "<div class='alert alert-warning'>Passwords must match!</div>";}
            if(strlen($_POST['password']) < 5){
                echo "<div class='alert alert-warning'>Password must be at least 5 characters long!</div>";}
            elseif(strlen($_POST['password']) > 4 && ($_POST['password'] == $_POST['password2'])){
                echo 'Your new password is: <strong>' . $_POST['password'] . '</strong> <br />';}
        }

        if(isset($_POST['test'])){
            $password = $_POST['password'];
            $email = $_POST['email'];
            echo '<br /> We should register this user! <br />';	
            $query = "UPDATE `db1_users` SET `password`= '" . $password . "' WHERE `email` = '" . $email . "';";
            if(mysqli_query($mysqli, $query)){
                echo "New Record Created Succesfully <br />";
                echo "Affected rows:  " . mysqli_affected_rows($mysqli);
                if(mysqli_affected_rows($mysqli) == 1){
                    $_SESSION['password'] = $password;
                    //$_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    //header('Location:  http://localhost/registrationform/welcome.php');
                }
            }
            else{
                echo "Error:  " . $query . "<br />" . mysqli_error($mysqli);
            }
        }*/
        ?>

        <div class="feedback"></div>

        <form method="post" id="regform">
            <!--Email: <input type="email" name="email" placeholder="Enter your Email" class="email" required/>
<br />-->
            Password: <input type="password" name="password" placeholder="Enter your new Password" class="password" required/>
            <br />
            Confirm Password: <input type="password" name="password2" placeholder="Re-Enter your new Password" class="password2" required/>
            <br />

            <input type="submit" id="submit" value="Update Password" />
            <input type="hidden" id="test" name="test" visibility="hidden" />
            <input type="button" value="Go to Registration" onclick="RedirectNormReg();" />
            <input type="button" value="Change your Password" onclick="RedirectLogin();" />

        </form>


    </body>
</html>