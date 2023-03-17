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
    <title>My Profile</title>
</head>

<body style="background-color: #fff;">

<div class="modal-open">
        <div class="modal fade show" id="exampleModalCenter" tabindex="-3" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: hidden;" aria-modal="true">
            </div></div>


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
                    <div class="dropdown-menu dropdown-menu-end bg-primary border-0 rounded-0 rounded-bottom m-0">
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
                <h1 class="text-primary">My Reservations</h1>
                <hr>

                <div class="rounded my-3 h-100  mx-auto">
                    <form action="" method="POST">
                        <input type="hidden" name="mem_id" value="<?php echo $_SESSION['mem_id']; ?>">

                        <select class="form-select w-25 mx-auto" aria-label="Default select example" name="filter">
                            <option selected value="ALL">All</option>
                            <option value="IN PROGRESS">In Progress</option>
                            <option value="BORROWED">Borrowed</option>
                            <option value="CLOSED">Closed</option>
                        </select>

                    </form>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4" id="search-results">


                </div>
            </div>
            <hr>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script defer>
        $(document).ready(function() {
            
            var filterValue = $('select[name="filter"]').val(); // get the initial value of the select
            var memId = $('input[name="mem_id"]').val(); // get the mem_id value
            console.log(filterValue);
            getFilteredResults(filterValue, memId);

            $('select[name=filter]').change(function() {
                filterValue = $(this).val(); // get the value of the selected radio button
                console.log(filterValue);
                getFilteredResults(filterValue, memId);
            });



            $('a[data-workk-id]').click(function() {
                console.log("clicked");
            var workId = $(this).data('workk-id');

            $.ajax({
            url: 'details.php',
            type: 'POST',
            data: { work_id: workId },
                success: function(response) {
                console.log('done');
            $('#exampleModalCenter').html(response);
            $('#exampleModalCenter').modal('show');
                    },
      error: function() {
        alert('Error fetching work data');
      }
    });
  });

        });

       

        function getFilteredResults(filterValue, memId) {
            $.ajax({
                type: 'POST',
                url: 'reservationsFliter.php',
                data: {
                    filter: filterValue,
                    mem_id: memId,
                },
                success: function(response) {
                    $('#search-results').html(response);
                }
            });

            
        }
    </script>


</body>

</html>