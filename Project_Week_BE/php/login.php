    <?php
        require_once "footer.php";
        require_once "navbar.php";
        require_once "db_connect.php";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION["adm"]) || isset($_SESSION["user"]) || isset($_SESSION["shelter"])) {
            header("Location: home.php");
            exit;
        }

        $email = $passError = $emailError = "";
        $error = false;

        function cleanInputs($input) {
            $data = trim($input);
            $data = strip_tags($data);
            $data = htmlspecialchars($data);

            return $data;
        }

        if (isset($_POST["login"])) {
            $email = cleanInputs($_POST["email"]);
            $passwordOrPhone = cleanInputs($_POST["password"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
                $emailError = "Please enter a valid email address";
            }

            if (empty($passwordOrPhone)) {
                $error = true;
                $passError = "Password/Phone number can't be empty!";
            }

            if (!$error) {
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($connect, $sql);

                if ($result && mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    if ($row["status"] == "user") {
                        $hashedPassword = hash("sha256", $passwordOrPhone);
                        if ($hashedPassword == $row["password"]) {
                            $_SESSION["user"] = $row["id"];
                            echo "<script>window.location.href = 'home.php';</script>";
                            exit;
                        } else {
                            echo "<div class='alert alert-danger'><p>Wrong credentials, please try again.</p></div>";
                        }
                    } else {
                        if ($passwordOrPhone == $row["phone"]) {
                            if ($row["status"] == "shelter") {
                                $_SESSION["shelter"] = $row["id"];
                                echo "<script>window.location.href = 'agency.php';</script>";
                                exit;
                            } else {
                                $_SESSION["adm"] = $row["id"];
                                echo "<script>window.location.href = '../php/Admin/index.php';</script>";
                                exit;
                            }
                        } else {
                            echo "<div class='alert alert-danger'><p>Wrong credentials, please try again.</p></div>";
                        }
                    }
                } else {
                    echo "<div class='alert alert-danger'><p>Wrong credentials, please try again.</p></div>";
                }
            }
        }
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login page</title>
        <link rel="stylesheet" href="../css/update.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <style>
            .login-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .login-form {
                display: flex;
                flex-wrap: nowrap;
                width: 50%; /* Adjust form width */
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                position: relative;
                float: center; /* Float form to the right */
            }

            .login-form img {
                width: 50%; /* Adjust image width */
                float: right; /* Float image to the left */
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <?= $nav ?>

        <div class="login-container">
            <div class="login-form">
                <form method="post">
                    <div class="mb-4 mt-5">
                        <label for="email" class="form-label">Email address:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>" >
                        <span class="text-danger"><?= $emailError ?></span>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password/Phone Number:</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="text-danger"><?= $passError ?></span>
                    </div>
                    <button name="login" type="submit" class="btn text-white me-3" id="upBtn">Login</button><br>
                    <span class="ms-2">You don't have an account? <a href="register.php">Register here</a></span>
                </form>
                <img src="../images/login.png" alt="Image">
            </div>
        </div>

        <?= $footer ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
    </html>
