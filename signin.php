<?php
session_start();
require "database.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>ArchiVisions - Sign In</title>
</head>

<body>

    <header class="">
        <div class="container-fluid px-5">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./index.html"><img src="./img/logo1.png" alt="" height="60px"></a>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="container-xxl">
            <div class="container">
                <div class="row g-5 bg-light mt-2 content rounded">
                    <div class="col-lg-6 col-12">
                        <img src="./img/background_signup.jpg" alt="" style="max-width: 100%;
        max-height: 100%;">
                    </div>

                    <div class="col-lg-6" style="display:flex;align-items: center; justify-content: center;">
                        <div class="wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <h2 class="mb-5 text-primary text-center text-uppercase">Sign In</h2>
                            <form method="post">
                                <div class="row g-3">

                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                            <label for="password">Password</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" name="submit" type="submit">Sign In</button>
                                    </div>
                                </div>
                                <?php
                                if (isset($_POST['submit'])) {
                                    echo "1";

                                $Email = $_POST['email'];
                                $Password = $_POST['password'];
                                $Pass = md5($Password);
                                



                                //check if the input in email format
                                if (empty($Email) && !filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                                $error = "<div class='error'>*Your Email is required, try again.</div>";
                                }
                                else if (empty($Password)) {
                                $error = "<div class='error'>*Password is required.</div>";
                                } else {
                                    echo "2";
                                    $stmt = $conn->prepare("SELECT * FROM member WHERE mem_email=:email AND mem_pass=:password");
                                    $stmt->bindParam(':email', $Email);
                                    $stmt->bindParam(':password', $Pass);
                                    $stmt->execute();
                                    $rowCount = $stmt->rowCount();
                                    echo "5";
                                    if ($rowCount === 1) {
                                        echo "6";
                                        $row = $stmt->fetch();
                                        echo "3";


                                if ($row['mem_email'] === $Email && $Pass === $row['mem_pass']) {
                                    echo "3";
                                //
                                $_SESSION['mem_name'] = $row['mem_name'];
                                $_SESSION['mem_id'] = $row['mem_id'];
                                $_SESSION['mem_username'] = $row['mem_username'];

                                header("Location: ./home.php");
                                } else {

                                $error = "<div class='error'>*the Email or the Password incorrect, try again.</div>";
                                }
                                }

                                if (!empty($error)) {
                                echo $error;
                                unset($error);
                                }}}
                                ?>

                            </form>
                        </div>
                    </div>
                </div>
            </div>




    </main>

    <div>

    </div>

</body>

</html>