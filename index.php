<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ballotify</title>
    <link rel="stylesheet" href="./style/signup.css">
</head>
<body>
    <section class="content">
        <div class="logo">
            <img height="60" src="./assets/positive-vote.png" alt="">
            <h1>Ballotify</h1>
        </div>
        <div class="description">
            <p>Join the movement for democratic engagement,where your voice matters and your vote makes a difference. Together, let's shape a brighter tomorrow through the power of digital democracy.</p>
        </div>
        <div class="more">
            <a target="_blank" href="https://www.altamed.org/articles/5-reasons-why-you-should-vote">More</a>
        </div>
    </section>

    <section class="signup">
        <h1 id="title">Create an Account</h1>
        <div class="underline"></div>
        <form method="POST">
            <!-- input section -->
            <div class="input-group">
                <div class="input-field" id="nameField">
                    <input type="text" name="fullName" required>
                    <div class="labelLine">Full Name</div>
                </div>
                <div class="input-field">
                    <input type="email" name="email" required>
                    <div class="labelLine">Email Address</div>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <div class="labelLine">Password</div>
                </div>
            </div>
            
            <!-- user help section -->
            <div class="user-help" id="userHelp">
                <div class="checkmark">
                    <input type="checkbox" id="check-remember" value="remember-me">
                    <label for="remember-me"> Remember Me?</label>
                </div>

                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
            </div>

            <!-- login/logout buttons -->
            <button class="signup-btn" name="signupBtn" id="signupBtn">Sign Up</button>
            <div class="nav-login">
                <p id="form-type">Already have an account? </p><a href="#"  id="loginBtn">Login</a>
            </div>

        </form>
    </section>

<script>
    // location.assign("index.php?sign-up=1");
    let signupBtn = document.getElementById("signupBtn");
    let formType = document.getElementById("form-type");
    let loginBtn = document.getElementById("loginBtn");
    let nameField = document.getElementById("nameField");
    let title = document.getElementById("title");
    let userHelp = document.getElementById("userHelp");
    let isLoginForm = false;
    loginBtn.onclick = function(){
        if (isLoginForm) {
            // location.assign("index.php?sign-up=1");
            title.innerHTML = "Create an Account";
            signupBtn.innerHTML = "Sign Up";
            formType.innerHTML = "Already have an account?";
            loginBtn.innerHTML = "Login";
            isLoginForm = false;
            signupBtn.style.marginTop = "10px";
            userHelp.style.visibility = "hidden";
            nameField.style.maxHeight = "100px"; 
            nameField.style.opacity = "1"; 
            signupBtn.setAttribute("name","signupBtn");

        } else {
            // location.assign("index.php?log-in=1");
            title.innerHTML = "Hi, Welcome Back!👋";
            signupBtn.innerHTML = "Login";
            formType.innerHTML = "Don't have an account?";
            loginBtn.innerHTML = "Sign Up";
            isLoginForm = true;
            signupBtn.style.marginTop = "30px";
            userHelp.style.visibility = "visible";
            nameField.style.maxHeight = "0"; 
            nameField.style.opacity = "0"; 
            signupBtn.setAttribute("name","loginBtn");

        }
    };
</script>

</body>
</html>

<?php

    require_once("admin/inc/config.php");

    //SIGNUP
    if(isset($_POST["signupBtn"])){
        $fullName = mysqli_real_escape_string($db,$_POST['fullName']); //removes any special characters that may interfere with the query operations.
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $password = mysqli_real_escape_string($db,sha1($_POST['password']));
        $userRole = "voter" ;

        mysqli_query($db,"INSERT INTO users(fullName,email,password,userRole) VALUES('".$fullName."','".$email."','".$password."','".$userRole."')") or die(mysqli_error($db));
        
        ?>
        <script>
            // location.assign("index.php?registered=1");
            // alert("Your account has been created successfully!");
        </script>
        
        <?php
    }else{
        ?>
        <script> 
            // location.assign("index.php?invalid=1");
            // alert("Please check your details again!");
        </script>
        <?php
    }


    //LOGIN
    if(isset($_POST["loginBtn"])){
    // email password loginBtn
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $password = mysqli_real_escape_string($db,sha1($_POST['password']));

        $fetchData = mysqli_query($db,"SELECT * FROM users WHERE email = '".$email."'") or die(mysqli_error($db));

        if(mysqli_num_rows($fetchData)>0){
            $data = mysqli_fetch_assoc($fetchData);
            if($email == $data["email"] AND $password == $data["password"]){

            }else{
                ?>
                <script>
                // location.assign("index.php?invalid_access=1");
                // alert("Invalid email or password");
                </script>
                    
                <?php
            }

        }else{
        ?>
            <script>
            // location.assign("index.php?not_registered=1");
            // alert("Sorry, you are not registered with us!");
            </script>
            
        <?php
        }

        
    }

    


?>