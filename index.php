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

    <?php
        if(isset($_GET['log-in'])){
        ?>
            <!-- LOGIN PAGE -->
            <section class="signup">
                <h1 id="title">Hi, Welcome Back!👋</h1>
                <div class="underline"></div>
                <form method="post" action="index.php">
                    <!-- input section -->
                    <div class="input-group">
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
                            <input type="checkbox" id="check-remember" value="remember-me"
                            name="remember-me">
                            <label for="remember-me"> Remember Me?</label>
                        </div>

                        <div class="forgot-pass">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>

                    <!-- login/logout buttons -->
                    <button class="signup-btn" name="loginBtn" id="loginBtn" style="margin-top: 30px;">Log in</button>
                    <div class="nav-login">
                        <p id="form-type">Don't have an account? </p><a href="index.php"  id="loginBtn">Sign Up</a>
                    </div>

                </form>
            </section>

        <?php
        }else{
        ?>
            <!-- SIGNUP PAGE -->
            <section class="signup">
                <h1 id="title">Create an Account! 🎉</h1>
                <div class="underline"></div>
                <form method="post" action="index.php">
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

                    <!-- login/logout buttons -->
                    <button class="signup-btn" name="signupBtn" id="signupBtn">Sign Up</button>
                    <div class="nav-login">
                        <p id="form-type">Already have an account? </p><a href="?log-in=1"  id="loginBtn">Login</a>
                    </div>

                </form>
            </section>

        <?php

        }
    ?>

</body>
</html>

<?php
    
    require_once("admin/inc/config.php");

    //SIGNUP
    if(isset($_POST["signupBtn"])){
        
        $fullName = mysqli_real_escape_string($db, $_POST['fullName']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, sha1($_POST['password']));
        $userRole = "voter";
    
        // Checking if email already exists in the database
        $check_query = mysqli_query($db, "SELECT * FROM users WHERE email = '".$email."'");

        if(mysqli_num_rows($check_query) > 0) {
            // Email already exists, show error message
            ?>
            <script>
                alert("This email is already registered. Please use a different email address.");
                location.assign("index.php?sign-up=1&email_exists=1");
            </script>
            <?php
        } 
        else {
            // Email doesn't exist and inserting user details into the database
            $query_result = mysqli_query($db, "INSERT INTO users(fullName, email, password, userRole) VALUES('".$fullName."','".$email."','".$password."','".$userRole."')");
    
            if ($query_result) {
                // Successful registration
                ?>
                <script>
                    alert("Your account has been created successfully! Please Login to get you in.");
                    location.assign("index.php?log-in=1");
                </script>
                <?php
            } else {
                // Database error
                ?>
                <script>
                    alert("Unable to add user data to the database!");
                    location.assign("index.php?sign-up=1&database_error=1");
                </script>
                <?php
            }
        }
    }

    //LOGIN
    else if(isset($_POST["loginBtn"])){
        // email password loginBtn
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $password = mysqli_real_escape_string($db,sha1($_POST['password']));

        $fetchData = mysqli_query($db,"SELECT * FROM users WHERE email = '".$email."'") or die(mysqli_error($db));

        if(mysqli_num_rows($fetchData)>0){
            $data = mysqli_fetch_assoc($fetchData);
            if($email == $data["email"] AND $password == $data["password"]){
                
                session_start();
                $_SESSION['userRole'] = $data['userRole'];
                $_SESSION['fullName'] = $data['fullName'];
                $_SESSION['user_id'] = $data['id'];

                if($data['userRole'] == "admin"){
                    $_SESSION['key'] = 'AdminKey';
                ?>
                    <script>location.assign("admin/index.php?homePage=1");</script>
                <?php
                }else{
                    $_SESSION['key'] = 'VoterKey';
                ?>
                    <script>location.assign("voter/index.php");</script>
                <?php
                }


            }else{
                ?>
                <script>
                    location.assign("index.php?log-in=1&invalid_access=1");
                    alert("Invalid email or password");
                </script>
                    
                <?php
            }

        }else{
        ?>
            <script>
            location.assign("index.php?");
            alert("Sorry, you are not registered with us!");
            </script>
            
        <?php
        }

        
    }



?>
