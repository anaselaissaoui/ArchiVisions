<?php

session_start();
require "database.php";

$query = "SELECT DISTINCT work_title, work_author, work_img, work_id, work_state FROM works WHERE work_dispo= 1";
$querymem = "SELECT * FROM member WHERE mem_id = {$_SESSION['mem_id']}";
$querybook = "SELECT * FROM booking WHERE mem_id = {$_SESSION['mem_id']} AND book_status = 'in progress' ";
$content = $conn->prepare($query);
$content1 = $conn->prepare($querymem);
$content2 = $conn->prepare($querybook);
$content->execute();
$content1->execute();
$content2->execute();


$results = $content->fetchAll();
$results1 = $content1->fetchAll();
$results2 = $content2->fetchAll();
foreach ($results1 as $row) {
    $current_value = $row['mem_res'];
    $av_res = 3 - $current_value;
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
    <link rel="stylesheet" href="https://kit.fontawesome.com/f06fa41670.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>My Profile</title>
</head>

<body style="background-color: #fff;">


    <header>
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./home.php"><img src="./img/logo1.png" alt="" height="60px"></a>
            </div>

            <form method="post" class="d-flex w-25 ms-auto">
                <input class="form-control border-0" type="search" id="search" placeholder="Search">
            </form>
            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="rounded-circle me-lg-2" src="img/user.png" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none fw-bold d-lg-inline-flex"><?php echo $_SESSION['mem_username'] ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="./profile.php" class="dropdown-item">My Profile</a>
                        <a href="./reservations.php" class="dropdown-item">My Reservations</a>
                        <a href="./signout.php" class="dropdown-item">Log Out</a>
                    </div>
                </div>
            </div>
        </nav>

    </header>


    <main class="container px-4">


        <div class="container mb-5 mt-2 px-5">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-diagram-3-fill text-primary" style="font-size: 3rem;"></i>
                        <div class="ms-3">
                            <p class="mb-2" style="color:#757575;">Available Items</p>
                            <h6 class="mb-0" style="color:#009cff;"><?php echo (count($results)); ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-graph-up-arrow text-primary" style="font-size: 3rem;"></i>
                        <div class="ms-3">
                            <p class="mb-2" style="color:#757575;">Available Reservations</p>
                            <h6 class="mb-0" style="color:#009cff;"><?php echo $av_res; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-file-earmark-arrow-up-fill text-primary" style="font-size: 3rem;"></i>
                        <div class="ms-3">
                            <p class="mb-2" style="color:#757575;">Open Reservations</p>
                            <h6 class="mb-0" style="color:#009cff;"><?php echo (count($results2)); ?></h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <i class="bi bi-archive-fill text-primary" style="font-size: 3rem;"></i>
                        <div class="ms-3">
                            <p class="mb-2" style="color:#757575;">Borrowed</p>
                            <h6 class="mb-0">$1234</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-5  px-5">
            <div class="container">
                <h1 class="text-primary">Edit Profile</h1>
                <hr>
                <div class="row justify-content-center">

                    <div class="col-md-7 personal-info ms-5">

                        <h3>Personal info</h3>
                       

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="name">Name</label>
                                        <input disabled type="text" class="form-control py-3 toEdit" name="name" placeholder="<?php echo $row['mem_name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="username">Username</label>
                                        <input disabled type="text" class="form-control py-3 toEdit" name="username" placeholder="<?php echo $row['mem_username']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="cin">ID Number</label>
                                        <input disabled type="text" class="form-control py-3" name="cin" placeholder="<?php echo $row['mem_cin']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="address">Address</label>
                                        <input disabled type="text" class="form-control py-3 toEdit" name="address" placeholder="<?php echo $row['mem_address']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="phoneNumber">Phone Number</label>
                                        <input disabled type="number" class="form-control py-3 toEdit" name="phoneNumber" placeholder="<?php echo $row['mem_phone']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="birthday">Birthday</label>
                                        <input disabled type="date" class="form-control py-3 datetimepicker-input" name="birthday" placeholder="<?php echo $row['mem_birthd']; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-secondary fw-bolder" for="email">Email</label>
                                        <input disabled type="email" class="form-control py-3" name="email" placeholder="<?php echo $row['mem_email']; ?>" required>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <button class="btn btn-primary w-25" id="update-btn">Update
                                        Now</button>
                                    <button class="btn btn-primary w-25" id="save-btn" style="display: none;" name="submit" type="submit">Save
                                        edits</button>
                                    <button class='btn  bg-danger'><a href='./deleteAcc.php' class='text-white fw-bold text-decoration-none'>DeleteAccount</a></button>
                                </div>
                                <?php
                        if (isset($_POST['submit'])) {

                            $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
                            $username = isset($_POST['username']) ? filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
                            $address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
                            $phone = isset($_POST['phoneNumber']) ? filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT) : '';

                            $queryUpdate = "UPDATE member SET  mem_name = '" . ($name != '' ? $name : $row['mem_name']) . "', mem_username = '" . ($username != '' ? $username : $row['mem_username']) . "', mem_phone = '" . ($phone != '' ? $phone : $row['mem_phone']) . "', mem_address = '" . ($address != '' ? $address : $row['mem_address']) . "' WHERE member . mem_id = {$_SESSION['mem_id']}";
                            $content3 = $conn->prepare($queryUpdate);
                            if ($content3->execute() === TRUE) {
                                echo "<span class='text-center fw-bold pt-2' style='color:#00D100;'>Record updated successfully</span>";
                            } else {
                                echo "<span class='text-danger text-center fw-bold pt-2'>Error updating</span>";
                            }
                        }

                        ?>

                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <hr>


        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="search-results">

        </div>



    </main>
    <footer>
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        © <a href="#" class="text-decoration-none">ArchiVisions</a>, All Right Reserved.
                    </div>
                    <div class="col-12 col-sm-6 text-center text-sm-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a href="https://github.com/anaselaissaoui" class="text-decoration-none">El Aissaoui
                            Anas</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Get the input fields and update button
        const inputs = document.querySelectorAll('.toEdit');
        const updateBtn = document.getElementById('update-btn');
        const saveBtn = document.getElementById('save-btn');

        // Disable the input fields by default
        inputs.forEach(input => {
            input.disabled = true;
        });

        // Enable the input fields when the user clicks the update button
        updateBtn.addEventListener('click', () => {
            inputs.forEach(input => {
                input.disabled = false;
            });
            updateBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
        });
        saveBtn.addEventListener('click', () => {
            inputs.forEach(input => {
                input.disabled = true;
            });
            updateBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
        });
    </script>
</body>

</html>