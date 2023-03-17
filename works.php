<?php

session_start();
require "database.php";

if (isset($_POST['btnradio'])) {
    $selected_type = $_POST['btnradio'];
} else {
    $selected_type = 'ALL';
}

$querymem = "SELECT * FROM member";

$querybook = "SELECT * FROM booking WHERE book_status = 'in progress' ";
$query3 = "SELECT *FROM loan l 
JOIN booking b ON l.book_id = b.book_id
JOIN member m ON b.mem_id = m.mem_id
JOIN works w ON b.work_id= w.work_id";



$query4 = "SELECT * FROM loan WHERE loan_status = 'OPEN'";
$query5 = "SELECT * FROM works";






if ($selected_type == 'ALL') {
    $query = "SELECT DISTINCT work_title, work_author, work_img, work_id, work_state FROM works WHERE work_dispo= 1";
} else {
    $query = "SELECT DISTINCT work_title, work_author, work_img, work_id, work_state FROM works WHERE work_dispo= 1 AND work_type = '$selected_type'";
}
$content = $conn->prepare($query);
$content1 = $conn->prepare($querymem);
$content2 = $conn->prepare($querybook);
$content3 =  $conn->prepare($query3);
$content4 = $conn->prepare($query4);
$content5 = $conn->prepare($query5);
$content->execute();
$content1->execute();
$content2->execute();
$content3->execute();
$content4->execute();
$content5->execute();


$results = $content->fetchAll();
$results1 = $content1->fetchAll();
$results2 = $content2->fetchAll();
$results3 = $content3->fetchAll();
$results4 = $content4->fetchAll();
$results5 = $content5->fetchAll();




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://kit.fontawesome.com/f06fa41670.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="container-xxxl position-relative bg-white d-flex p-0">
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/admin1.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $_SESSION['lib_name']; ?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="dashboard.php" class="nav-item nav-link"><i class="bi bi-speedometer2 me-2"></i>Reservations</a>
                    <a href="loans.php" class="nav-item nav-link"><i class="bi bi-archive me-2"></i>Loans</a>
                    <a href="works.php" class="nav-item nav-link active"><i class="bi bi-file-richtext-fill me-2"></i>Works</a>
                    <a href="members.php" class="nav-item nav-link"><i class="bi bi-people me-2"></i>Members</a>
                </div>
            </nav>
        </div>

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">


                <div class="navbar-nav align-items-center ms-auto">

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/admin1.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $_SESSION['lib_name']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="adminprofil.php" class="dropdown-item">My Profile</a>
                            <a href="adminsignup.php" class="dropdown-item">Add Admin</a>
                            <a href="adminsignout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">

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
                            <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                            <div class="ms-3">
                                <p class="mb-2" style="color:#757575;">Members</p>
                                <h6 class="mb-0" style="color:#009cff;"><?php echo (count($results1)); ?></h6>
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
                                <h6 class="mb-0" style="color:#009cff;"><?php echo (count($results4)); ?></h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Sale & Revenue End -->





            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0 text-primary">Works</h6>
                        <a href="addwork.php" class="btn btn-outline-primary" style="text-decoration:none;">+ Add Work</a>

                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4" id="search-results">



                    <?php 
                    if (count($results5) > 0) {
                          foreach ($results5 as $row) {
                                            
                                            echo '<div class="col">
                                            <div class="card h-100 border-primary border-1 shadow-lg">
                                                <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
                                                <div class="card-body mt-auto">
                                                <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                                                <p class="card-text">' . $row['work_author'] . '</p>
                                                </div>
                                                <div class="card-footer d-flex align-items-center justify-content-center">
                                                <a data-work-id="'.$row['work_id'].'" class="btn btn-danger me-3" >Delete</a>
                                                <a  onclick="detailsFunction()" class="btn btn-outline-primary" style="text-decoration:none;">Details</a>
                                                </div>
                                            </div>
                                            </div>';
                                        }
                                    } else {
                                        echo "<h2 class='text-center text-danger'>No Results Found</h2>";
                                    }
                    
                    ?> </div></div>
            </div>
            <!-- Recent Sales End -->





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


        </div>



        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
$(document).ready(function() {
    $("button[data-work-id]").click(function(e) {
        e.preventDefault();
        var memId = $(this).data("work-id");
        $.ajax({
            url: "deleteWork.php",
            type: "POST",
            data: {work_id: workId },
            success: function(response) {
                // handle success response
                location.reload(); // reload the page after closing the loan
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // handle error response
                console.log(errorThrown);
            }
        });
    });
});
</script>




</body>

</html>

<style>
    .card {
        transition: transform 0.3s ease;
        transform-origin: center center;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        height: 100vh;
        overflow-y: auto;
        background: var(--light);
        transition: 0.5s;
        z-index: 999;
    }

    .content {
        margin-left: 250px;
        min-height: 100vh;
        background: #FFFFFF;
        transition: 0.5s;
    }

    /*** Button ***/
    .btn {
        transition: .5s;
    }

    .btn.btn-primary {
        color: #FFFFFF;
    }

    .btn-square {
        width: 38px;
        height: 38px;
    }

    .btn-sm-square {
        width: 32px;
        height: 32px;
    }

    .btn-lg-square {
        width: 48px;
        height: 48px;
    }

    .btn-square,
    .btn-sm-square,
    .btn-lg-square {
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: normal;
        border-radius: 50px;
    }


    /*** Navbar ***/
    .sidebar .navbar .navbar-nav .nav-link {
        padding: 7px 20px;
        color: var(--dark);
        font-weight: 500;
        border-left: 3px solid var(--light);
        border-radius: 0 30px 30px 0;
        outline: none;
    }

    .sidebar .navbar .navbar-nav .nav-link:hover,
    .sidebar .navbar .navbar-nav .nav-link.active {
        color: var(--primary);
        background: #FFFFFF;
        border-color: var(--primary);
    }

    .sidebar .navbar .navbar-nav .nav-link i {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FFFFFF;
        border-radius: 40px;
    }

    .sidebar .navbar .navbar-nav .nav-link:hover i,
    .sidebar .navbar .navbar-nav .nav-link.active i {
        background: var(--light);
    }

    .sidebar .navbar .dropdown-toggle::after {
        position: absolute;
        top: 15px;
        right: 15px;
        border: none;
        content: "\f107";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        transition: .5s;
    }

    td{
        color:#757575;
    }
    .sidebar .navbar .dropdown-toggle[aria-expanded=true]::after {
        transform: rotate(-180deg);
    }

    .sidebar .navbar .dropdown-item {
        padding-left: 25px;
        border-radius: 0 30px 30px 0;
    }

    .content .navbar .navbar-nav .nav-link {
        margin-left: 25px;
        padding: 12px 0;
        color: var(--dark);
        outline: none;
    }

    .content .navbar .navbar-nav .nav-link:hover,
    .content .navbar .navbar-nav .nav-link.active {
        color: var(--primary);
    }

    .content .navbar .sidebar-toggler,
    .content .navbar .navbar-nav .nav-link i {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FFFFFF;
        border-radius: 40px;
    }

    .content .navbar .dropdown-toggle::after {
        margin-left: 6px;
        vertical-align: middle;
        border: none;
        content: "\f107";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        transition: .5s;
    }

    .content .navbar .dropdown-toggle[aria-expanded=true]::after {
        transform: rotate(-180deg);
    }

    @media (min-width: 992px) {
        .sidebar {
            margin-left: 0;
        }

        .sidebar.open {
            margin-left: -250px;
        }

        .content {
            width: calc(100% - 250px);
        }

        .content.open {
            width: 100%;
            margin-left: 0;
        }
    }

    @media (max-width: 991.98px) {
        .sidebar {
            margin-left: -250px;
        }

        .sidebar.open {
            margin-left: 0;
        }

        .content {
            width: 100%;
            margin-left: 0;
        }
    }

    @media (max-width: 575.98px) {
        .content .navbar .navbar-nav .nav-link {
            margin-left: 15px;
        }
    }
</style>