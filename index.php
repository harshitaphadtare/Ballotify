<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ballotify</title>
    <link rel="stylesheet" href="./style/login.css">
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
        <form action="">
            <!-- input section -->
            <div class="input-group">
                <div class="input-field" id="nameField">
                    <input type="text" required>
                    <div class="labelLine">Full Name</div>
                </div>
                <div class="input-field">
                    <input type="email" required>
                    <div class="labelLine">Email Address</div>
                </div>
                <div class="input-field">
                    <input type="password" required>
                    <div class="labelLine">Password</div>
                </div>
            </div>
            
            <!-- user help section -->
            <div class="user-help">
                <div class="checkmark">
                    <input type="checkbox" id="check-remember" value="remember-me">
                    <label for="remember-me"> Remember Me?</label>
                </div>

                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
            </div>

            <!-- login/logout buttons -->
            <button class="signup-btn" id="signupBtn">Sign Up</button>
            <div class="nav-login">
                <p id="form-type">Already have an account? </p><a href="#"  id="loginBtn">Login</a>
            </div>

        </form>
    </section>

<script>
    let signupBtn = document.getElementById("signupBtn");
    let formType = document.getElementById("form-type");
    let loginBtn = document.getElementById("loginBtn");
    let nameField = document.getElementById("nameField");
    let title = document.getElementById("title");
    let isLoginForm = false;

    loginBtn.onclick = function(){
        if (isLoginForm) {
            title.innerHTML = "Create an Account";
            signupBtn.innerHTML = "Sign Up";
            formType.innerHTML = "Already have an account?";
            loginBtn.innerHTML = "Login";
            isLoginForm = false;

            nameField.style.maxHeight = "100px"; // Adjust the height to show the field
            nameField.style.opacity = "1"; // Show the field
        } else {
            title.innerHTML = "Hi, Welcome Back!👋";
            signupBtn.innerHTML = "Login";
            formType.innerHTML = "Don't have an account?";
            loginBtn.innerHTML = "Sign Up";
            isLoginForm = true;

            nameField.style.maxHeight = "0"; // Hide the field
            nameField.style.opacity = "0"; // Hide the field
        }
    };
</script>

</body>
</html>