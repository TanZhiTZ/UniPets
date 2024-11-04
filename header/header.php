<?php


if(isset($_POST['submit'])) {
    // Sanitize email
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format');
    }
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $storedHashedPassword = $row['password'];

        // Verify the password using password_verify()
        if (password_verify($pass, $storedHashedPassword)) {
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['userName'] = $row['userName'];
            $_SESSION['userEmail'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            $role = $_SESSION['role'];

            if ($role == "user") {
                header('location:index.php');
            } else if ($role == "admin") {
                header('location:admin/admin-index.php');
            }
        } else {
            echo '<script>alert("Wrong email or password!")</script>';
        }
    } else {
        echo '<script>alert("Wrong email or password!")</script>';
    }
}
?>

<!-- Forum Button -->
<a href="community-forum.php" class="forum-btn" title="Chat with others!">
    <img src="img/forum-icon.png" alt="Community Forum" style="width: 45px; height: 45px;">
</a>

<!-- Sign in pop up -->
<div class="register-container" id="register">
        <div class="frame" style="text-align: center;">
            <h2>Create an account</h2>
            <form action="" id="registration" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="name" id="registerName" class='textbox' name="name" placeholder="User Name" required="required" autofocus>
                </div>
                <div class="field">
                    <input type="email" id="registerEmail" class='textbox' name="email" placeholder="Email" required="required">
                </div>
                <div class="field">
                    <input type="password" id="passwordInput" class='textbox' name="password" placeholder="Password" id="password" required="required">
                </div>
                <div class="field">
                    <input type="password" class='textbox' name="cpassword" placeholder="Confirm Password" id="cpassword" required="required">
                </div>
                <div class="field">
                    <input type="checkbox" onclick="showPass()">Show Password
                </div>
                <!-- Registration php -->
                <?php
                    //ini_set('display_errors', 0);
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($_POST['cpassword']) {
                            $name =  $_POST['name'];
                            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

                            $email = mysqli_real_escape_string($conn, $_POST['email']);
                            $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

                            $pass = mysqli_real_escape_string($conn, $_POST['password']);
                            $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
                            $role = "user";
                            
                            $badWordsFilePath = "badwords.txt";
                            
                            function loadBadWords($filePath) {
                                if (!file_exists($filePath)) {
                                    return [];
                                }
                                
                                // Read the file and split into an array
                                $badWords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                                
                                return $badWords;
                            }
                            
                            function containsInappropriateWords($string, $bad) {
                                foreach ($bad as $word) {
                                    if (stripos($string, $word) !== false) {
                                        return true; // Inappropriate word found
                                    }
                                }
                                return false;
                            }
                            
                            $badWords = loadBadWords($badWordsFilePath);
                            if (containsInappropriateWords($name, $badWords)) {
                                echo '<script> alert("Please use a valid name without inappropriate words!");
                                window.location.href = "index.php"; </script>';
                            } else {
                                
                                                            $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');
                                                            // Check if email already exists
                                                            $checkEmail = $conn->query("SELECT * FROM user WHERE email='$email'");
                                                            if ($checkEmail->num_rows > 0) {
                                                                // header('location:registerFailed.php');
                                                            } else {
                                                                if ($pass === $cpass) {
                                                                    // Hash and salt the password
                                                                    $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
                                
                                                                    $query = "INSERT INTO user (userName, email, password, role) VALUES ('$name', '$email', '$hashedPassword', '$role')";
                                                                    if ($conn->query($query)) {
                                                                        header('location:register.php');
                                                                    } else {
                                                                        echo 'Error: ' . $conn->error;
                                                                    }
                                                                } else {
                                                                    echo 'Passwords do not match!';
                                                                }

                            }
                            }
                        }
                    }
                ?>
                <div id="response" style="color:red; font-size:12px;"></div>
                <div class="field">
                    <button class="buttondeco" name="register" type="submit"><b>Register</b></button>
                </div>
                <div class="field">
                    <a style="font-family:'verdana'" class="open-login-btn">Already have an account?</a>
                </div>
            </form>
        </div>
</div>

<!-- Log in pop up -->
<div class="login-container" id="login">
        <div class="frame" style="text-align: center;">
            <img class="login-logo" src="img/UniPets.jpg" alt="main_logo" width="235"/>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="email" class="textbox" name="email" placeholder="Email" required="required" autofocus>
                </div>
                <div class="field">
                    <input type="password" class="textbox" name="password" placeholder="Password" id="pass" required="required">
                </div>
                 <div class="field">
                     <button class="buttondeco" name="submit" type="submit"><b>Log In</b></button>
                </div>
                <br/><div style="width:90%; width:100%;"><hr color="#999999"></div><br/>
                <div class="field">
                    <!--<a style="font-family:'verdana'" href="password-reset.php">Forgot password?</a>-->
                </div>
            </form>
        </div>
</div>

<!-- registration button-->
<script>
document.getElementById('registration').addEventListener('submit', function(event) {
    // Prevent form submission initially
    event.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const name = formData.get('name');
    const email = formData.get('email');
    const password = formData.get('password');
    const cpassword = formData.get('cpassword');

    // Validation
    const responseDiv = document.getElementById('response');
    responseDiv.innerHTML = ''; // Clear previous messages

    // Function to check password strength
    function isStrongPassword(password) {
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&()\[\]])[A-Za-z\d@$!%*?&()\[\]]{8,}$/;
        return passwordPattern.test(password);
    }

    // Check password length and strength
    if (password.length < 8) {
        responseDiv.innerHTML = 'Password must be at least 8 characters long.';
        return;
    }

    if (!isStrongPassword(password)) {
        responseDiv.innerHTML = 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
        return;
    }

    // Check if passwords match
    if (password !== cpassword) {
        responseDiv.innerHTML = 'Passwords do not match.';
        return;
    }

    // Check email format
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        responseDiv.innerHTML = 'Please enter a valid email address.';
        return;
    }

    // If all validations pass, submit the form traditionally (refresh the page)
    this.submit();
});
</script>

<!-- Page Header -->
<table class="header">
    <tr style="padding:10px;">
    <!-- Logo -->
    <th width="30%" style="display: table-cell;">
        <div>
            <a href="/UniPets"><img class="header-logo" src="img/UniPets.jpg" alt="main_logo" width="235"/></a>
        </div>
    </th>

    <!-- Navigation List -->
    <th width="auto" style="display: table-cell;">
        <nav class="header-nav-list">
            <div class="header-nav-item header-nav-item--collection header-nav-item--active header-nav-item--homepage underline-hover">
                <a href="/UniPets" aria-current="page" tabindex="0">HOME</a>
            </div>
            <div class="header-nav-item header-nav-item--collection underline-hover">
                <a href="about-us.php" tabindex="0">ABOUT US</a>
            </div>
            <div class="header-nav-item header-nav-item--folder underline-hover">
                <a class="header-nav-folder-title" href="pet-list.php" tabindex="0">ADOPT</a>
                <div class="header-nav-folder-content">
                    <div class="header-nav-folder-item">
                        <a href="cat-list.php" tabindex="0">CATS</a>
                    </div>
                    <div class="header-nav-folder-item">
                        <a href="dog-list.php" tabindex="0">DOGS</a>
                    </div>
                </div>
            </div>
            <div class="header-nav-item header-nav-item--folder underline-hover">
                <a class="header-nav-folder-title" href="about-pets.php" tabindex="0">ABOUT PETS</a>
                <div class="header-nav-folder-content">
                    <div class="header-nav-folder-item">
                        <a href="products.php" tabindex="0">PET ACCESSORIES</a>
                    </div>
                </div>
            </div>
            <div class="header-nav-item header-nav-item--collectio underline-hover">
                <a href="donation.php" tabindex="0">DONATION</a>
            </div>
        </nav>
    </th>

    <!--User Sign up and Cart-->
    <?php
        if (isset($_SESSION['userName'])) {
            $name = $_SESSION['userName'];
            $id = $_SESSION['userId'];
            // ini_set('display_errors', 0);

            echo "
            <th width='7%'></th>
            <th width='10%'>
                    <div align='center'>
                        <b>
                            <a href='user-profile.php?id=$id' style='color: black; font-size:16px;'>$name</a>
                        </b>
                    </div>
                </th>
                
                <th width='3%' style='display: table-cell; justify-content: center;'>
                    <a href='cart.php'>
                        <span class='material-symbols-outlined'>
                                shopping_cart_checkout
                        </span>
                    </a>
                </th>

                <th width='10%'>
                <center><a href='config/logout.php'>Log Out</a></center>
                </th>
            
                ";
            
            echo "
            ";
            
        } else {

            echo '
            <th width="10%"></th>

            <th width="10%">
                <button class="open-register-btn">
                    <span><b>SIGN UP</b></span>
                </button>
            </th>

            <th width="10%" style="display: table-cell ;">
                <a>
                    <span class="material-symbols-outlined">
                            shopping_cart_checkout
                    </span>
                </a>
            </th>
                ';
        }
        ?>
    </tr>
</table>

<script>
        //Scroll up
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll('.scroll-up-animation');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, { threshold: 0.1 });
            
            elements.forEach(element => {
                observer.observe(element);
            });
        });

        //Registration and Login form pop up
        const register = document.getElementById('register');
        const openRegisterBtn = document.querySelector('.open-register-btn');

        const login = document.getElementById('login');
        const openLoginBtn = document.querySelector('.open-login-btn');

        // Open registration / login form
        openRegisterBtn.addEventListener('click', function() {
            register.style.display = 'flex';
            document.body.classList.add('register-open');
        });

        openLoginBtn.addEventListener('click', function() {
            register.style.display = 'none';
            login.style.display = 'flex';
            document.body.classList.add('login-open');
        });

        // Close registration / login form when clicking outside the form
        window.addEventListener('click', function(event) {
            if (event.target == register) {
                register.style.display = 'none';
                document.body.classList.remove('register-open');
            }
        });

        window.addEventListener('click', function(event) {
            if (event.target == login) {
                login.style.display = 'none';
                document.body.classList.remove('login-open');
            }
        });
    </script>