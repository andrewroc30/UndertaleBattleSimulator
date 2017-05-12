<?php
include 'includes/db.php';
session_start();
ob_start();
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
        <h1>Register for Undertale Battle Simulator</h1>

        <script>
            function RedirectDash() {
                window.location="http://localhost/UndertaleBattleSimulator/dashboard.php";
            }
            function RedirectLogin() {
                window.location="http://localhost/UndertaleBattleSimulator/login.php";
            }
            $(document).ready(function(){
                $(".username").on('change',function(){
                    var u = $('.username').val();
                    if(u.length < 6){
                        alert("Username must have at least 6 characters!");
                    }
                });

                $(".password").on('change',function(){
                    var u = $('.username').val();
                    var p = $('.password').val();
                    var p2 = $('.password2').val();
                    if(!(p === p2) && !(p2 === "")){
                        alert("Passwords must match!");
                    }
                    if(p.includes(u)){
                        alert("Password must not contain username!");
                    }
                    if(p.length<5){
                        alert("Password must be at least 5 characters long!");
                    }
                });

                $(".password2").on('change',function(){
                    var u = $('.username').val();
                    var p = $('.password').val();
                    var p2 = $('.password2').val();
                    if(!(p === p2) && !(p2 === "")){
                        alert("Passwords must match!");
                    }
                    if(p.includes(u)){
                        alert("Password must not contain username!");
                    }
                    if(p.length<5){
                        alert("Password must be at least 5 characters long!");
                    }
                });

                $(".email").on('change',function(){
                    var e = "" + $.trim($('.email').val());
                    var e2 = "" + $.trim($('.email2').val());
                    if(!(e === e2) && !(e2 === "") && !(e === "")){
                        alert("Emails must match!");
                    }
                    var atP = e.indexOf("@");
                    var dotP = e.lastIndexOf(".");
                    if(atP>dotP){
                        alert("Email must have a dot after the @!");
                    }
                });

                $(".email2").on('change',function(){
                    var e = "" + $.trim($('.email').val());
                    var e2 = "" + $.trim($('.email2').val());
                    if(!(e === e2) && !(e2 === "") && !(e === "")){
                        alert("Emails must match!");
                    }
                    var atP = e.indexOf("@");
                    var dotP = e.lastIndexOf(".");
                    if(atP>dotP){
                        alert("Email must have a dot after the @!");
                    }
                });


                $("#regform").submit(function(event) {

                    $('#test').hide();
                    $('#test').val('');

                    $('.feedback').html('');

                    var formOk = true;

                    var username = $('.username').val();
                    var password = $('.password').val();
                    var password2 = $('.password2').val();
                    var email = "" + $.trim($('.email').val());
                    var email2 = "" + $.trim($('.email2').val());

                    if(username.length !== 0){
                        if(username.length < 6){
                            $('.feedback').append("<div class='alert alert-warning'>Username must have at least 6 characters!</div>");
                            formOk = false;
                        }
                        else{
                            $('.feedback').append('Your username is:  <strong>' + username + '</strong> <br />');
                        }
                    }

                    if(password.length !== 0){
                        if(!(password === password2)){
                            $('.feedback').append("<div class='alert alert-warning'>Passwords must match!</div>");
                            formOk = false;
                        }
                        if(password.includes(username)){
                            $('.feedback').append("<div class='alert alert-warning'>Password must not contain username!</div>");
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

                    if(email.length !== 0){
                        if(!(email === email2)){
                            $('.feedback').append("<div class='alert alert-warning'>Emails must match!</div>");
                            formOk = false;
                        }
                        atPos = email.indexOf("@");
                        dotPos = email.lastIndexOf(".");
                        if(atPos > dotPos){
                            $('.feedback').append("<div class='alert alert-warning'>Email must have a dot after the @!</div>");
                            formOk = false;
                        }
                        else if(atPos < dotPos && email === email2){
                            $('.feedback').append('Your email is: <strong>' + email + '</strong>');
                        }
                    }

                    if(formOk == false)
                        event.preventDefault();
                    else
                        $('#test').val(1);
                })
            })
        </script>

        <?php
        if(isset($_POST['username'])){
            if(strlen($_POST['username']) > 5)
                echo 'Your username is:  <strong>' . $_POST['username'] . '</strong> <br />';
            else
                echo "<div class='alert alert-warning'>Username must have at least 6 characters!</div>";
        }

        if(isset($_POST['password'])){
            if(!($_POST['password'] == $_POST['password2'])){
                echo "<div class='alert alert-warning'>Passwords must match!</div>";}
            if(strpos($_POST['password'],$_POST['username'])){
                echo "<div class='alert alert-warning'>Passwords must not contain username!</div>";}
            if(strlen($_POST['password']) < 5){
                echo "<div class='alert alert-warning'>Password must be at least 5 characters long!</div>";}
            elseif(strlen($_POST['password']) > 4 && ($_POST['password'] == $_POST['password2'])){
                echo 'Your password is: <strong>' . $_POST['password'] . '</strong> <br />';}
        }

        if(isset($_POST['email'])){
            $email = trim($_POST['email']);
            $email2 = trim($_POST['email2']);

            if(!($email == $email2))
                echo "<div class='alert alert-warning'>Emails must match!</div>";
            $atPosition = strpos($email, '@');
            $dotPosition = strrpos($email, '.');
            if($dotPosition < $atPosition)
                echo "<div class='alert alert-warning'>Email must have a dot after the @!</div>";

            if($dotPosition > $atPosition && $email == $email2)
                echo 'Your email is: <strong>' . $_POST['email'] . '</strong> <br />';
        }

        if(isset($_POST['test'])){
            $name = $_POST['username'];
            $password = sha1($_POST['password']);
            echo '<br /> We should register this user! <br />';	
            $query = "INSERT INTO `users` (`username`, `email`, `password`, `highscore`) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '0');";

            if(mysqli_query($mysqli, $query)){
                echo "New Record Created Succesfully";
                echo "Affected rows:  " . mysqli_affected_rows($mysqli);
                if(mysqli_affected_rows($mysqli) == 1){
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    header('Location:  http://localhost/UndertaleBattleSimulator/login.php');
                }
            }
            else{
                echo "Error:  " . $query . "<br />" . mysqli_error($mysqli);
            }
        }
        ?>

        <div class="feedback"></div>

        <form method="post" id="regform">
            Username: <input type="text" name="username" placeholder="Enter your Username" class="username" required/>
            <br />
            Password: <input type="password" name="password" placeholder="Enter your Password" class="password" required/>
            <br />
            Confirm Password: <input type="password" name="password2" placeholder="Re-Enter your Password" class="password2" required/>
            <br />
            Email: <input type="email" name="email" placeholder="Enter your Email" class="email" required/>
            <br />
            Confirm Email: <input type="email" name="email2" placeholder="Re-Enter your Email" class="email2" required/>
            <br />

            <input type="submit" id="submit" value="Click to Submit" />
            <input type="hidden" id="test" name="test" visibility="hidden" />
            <input type="button" value="Change your Password" onclick="RedirectDash();" />
            <input type="button" value="Login" onclick="RedirectLogin();" />

        </form>


    </body>
</html>