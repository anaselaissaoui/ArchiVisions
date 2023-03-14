<?php 
require "database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name  = $_POST['name'];
    $UserName = $_POST['username'];
    $CIN  = $_POST['cin'];
    $Address= $_POST['address'];
    $Phone = $_POST['phoneNumber'];
    $Birthday = $_POST['birthday'];
    $Email = $_POST['email'];
    $Password  = md5($_POST['password']);
    $RePassword  = md5($_POST['repassword']);
    $Type = $_POST['type'];
    $Penalty = "0";
    $CreationDate = date('Y-m-d');
    $error = "";

	if (empty($Name) || empty($UserName) || empty($CIN)|| empty($Address)|| empty($Phone) || empty($Birthday) || empty($Email) ||  empty($Password) || empty($RePassword)||empty($Type)) {
		$error = 'Please enter all the values';
	} elseif ($Password !== $RePassword) {
		$error = 'Passwords do not match';
	} elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
		$error = 'Invalid email format';
	} else {
            $stmt = $conn->prepare("INSERT INTO member (mem_cin, mem_name, mem_username, mem_address, mem_email, mem_pass, mem_type, mem_phone, mem_birthd, mem_penalty, mem_cr_acc) 
            VALUES (:mem_cin, :mem_name, :mem_username, :mem_address, :mem_email, :mem_pass, :mem_type, :mem_phone, :mem_birthd, :mem_penalty, :mem_cr_acc)");
                $stmt->bindParam(':mem_cin', $CIN);
                $stmt->bindParam(':mem_name', $Name);
                $stmt->bindParam(':mem_username', $UserName);
                $stmt->bindParam(':mem_address', $Address);
                $stmt->bindParam(':mem_email', $Email);
                $stmt->bindParam(':mem_pass', $Password);
                $stmt->bindParam(':mem_type', $Type);
                $stmt->bindParam(':mem_phone', $Phone);
                $stmt->bindParam(':mem_birthd', $Birthday);
                $stmt->bindParam(':mem_penalty', $Penalty);
                $stmt->bindParam(':mem_cr_acc', $CreationDate);

                $stmt->execute();
                header ("location: signin.php");
	}
	
	
}
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
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>ArchiVisions - Sign Up</title>
</head>

<body>


    <header class="bg-light">
        <div class="container-fluid px-5">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./index.html"><img src="./img/logo1.png" alt="" height="60px"></a>
                <a href="./signin.php"><button class="btn btn-primary m-2 px-4">Sign In</button></a>
            </div>
        </div>
    </header>

    <main class="container">
    <div class="container-xxl py-3">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                    <h6 class="section-title text-center text-primary text-uppercase">Join Us</h6>
                    <h1 class="mb-5">Explore, Create, Learn: <span class="text-primary text-uppercase">Borrow Works!</span></h1>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="./img/image2.jpg" style="margin-top: 25%; visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="./img/image1.jpg" style="visibility: visible; animation-delay: 0.3s; animation-name: zoomIn;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="./img/image4.jpg" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="./img/image3.jpg" style="visibility: visible; animation-delay: 0.7s; animation-name: zoomIn;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                                            <label for="username">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="cin" placeholder="ID Number" required>
                                            <label for="cin">ID Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                                            <label for="address">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="phoneNumber" placeholder="Phone Number" required>
                                            <label for="phoneNumber">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control datetimepicker-input" name="birthday" placeholder="Birthday" required>
                                            <label for="birthday">Birthday</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" name="type">
                                            <option value="" disabled selected>-----</option>
                                              <option value="Student">Student</option>
                                              <option value="Housewife">Housewife</option>
                                              <option value="Official">Official</option>
                                              <option value="Artist">Artist</option>
                                              <option value="Entrepreneur">Entrepreneur</option>
                                              <option value="Military">Military</option>
                                              <option value="Business Man">Business Man</option>
                                              <option value="Researcher or Academic">Researcher or Academic</option>
                                            </select>
                                            <label for="select1">Select Type</label>
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" name="repassword" placeholder="Confirm - Password" required>
                                            <label for="repassword">Confirm - Password</label>
                                        </div>
                                    </div>
                                    
                                            <?php
                                            
                                            if(isset($error)){
                                                echo "<p class='para' style='color: red;'>" . $error . "</p>";
                                            }
                                            
                                            
                                            ?>
                                    
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Register Now</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <span class="">Already have an account? <a href="./signin.php" class="have">Sign In</a> </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>

    <div>

    </div>

</body>

</html>