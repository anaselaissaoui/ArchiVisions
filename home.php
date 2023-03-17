<?php

session_start();
require "database.php";
if (isset($_POST['btnradio'])) {
    $selected_type = $_POST['btnradio'];
} else {
    $selected_type = 'ALL';
}

$querymem = "SELECT mem_res FROM member WHERE mem_id = {$_SESSION['mem_id']}";

$querybook = "SELECT * FROM booking WHERE mem_id = {$_SESSION['mem_id']} AND book_status = 'in progress' ";


if ($selected_type == 'ALL') {
    $query = "SELECT DISTINCT work_title, work_author, work_img, work_id, work_state FROM works WHERE work_dispo= 1";
} else {
    $query = "SELECT DISTINCT work_title, work_author, work_img, work_id, work_state FROM works WHERE work_dispo= 1 AND work_type = '$selected_type'";
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://kit.fontawesome.com/f06fa41670.css" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>ArchiVisions</title>
</head>

<body style="background-color: #fff;">

<div class="modal-open">
        <div class="modal fade show" id="exampleModalCenter" tabindex="-3" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: hidden;" aria-modal="true">
            </div></div>
                          


    <header>
        <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./index.html"><img src="./img/logo1.png" alt="" height="60px"></a>
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

    <main class="container pt-4 px-4">

        <div class="container my-5  px-5">
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
            <div class=" rounded h-100  text-center">
                <form action="" method="post">
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="filter" value="ALL" id="btnradio1" autocomplete="off" checked="">
                        <label class="btn btn-outline-primary" for="btnradio1">ALL</label>

                        <input type="radio" class="btn-check" name="filter" value="BOOK" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">BOOK</label>

                        <input type="radio" class="btn-check" name="filter" value="MAGAZINE" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">MAGAZINE</label>

                        <input type="radio" class="btn-check" name="filter" value="DVD" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">DVD</label>
                    </div>
                </form>
            </div>


        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="search-results">
            <?php foreach ($results1 as $row) {
                if ($row['mem_res'] >= 3) {
                    echo "<h2 class='text-danger fw-bolder'>Sorry you reached the max of booking operations , try after you return a borrowed work or canceled booking.</h2>";
                } else {
                    include "cards.php";
                }
            }; ?>
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

    <script>
        $(document).ready(function() {
            $('input[type=radio][name=filter]').change(function() {
                var filterValue = $(this).val(); // get the value of the selected radio button
                var searchValue = $('#search').val(); // get the value of the search input
                $.ajax({
                    type: 'POST',
                    url: 'search.php',
                    data: {
                        filter: filterValue,
                        search: searchValue
                    }, // send both the selected radio button value and search input value to the PHP script
                    success: function(response) {
                        // display the filtered results returned from the PHP script
                        $('#search-results').html(response);
                    }
                });
            });

            $('#search').keyup(function() {
                var search = $(this).val();
                var filterValue = $('input[type=radio][name=filter]:checked')
                    .val(); // get the value of the checked radio button
                $.ajax({
                    type: 'POST',
                    url: 'search.php',
                    data: {
                        search: search,
                        filter: filterValue // send both the search input value and checked radio button value to the PHP script
                    },
                    success: function(response) {
                        $('#search-results').html(response);
                    }
                });
            });
            $('a[data-workk-id]').click(function() {
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

        function bookFunction(workId) {
            if (workId === undefined) {
                console.warn('workId is undefined: ', workId)
                return;
            }
            const booking = `<div class="modal bg-dark bg-opacity-75 py-5" id="modal" tabindex="-1">
    <div class="modal-dialog my-5">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Booking Confirmation</h5>
          <button type="button" class="btn-close cloBtn"  data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>are you sure that you want to book this work ?</p>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-secondary cloBtn"  data-bs-dismiss="modal">Cancel</a>
          <a href="./confirmBook.php?id=` + workId + `" type="button" class="btn btn-primary">Confirm</a>
        </div>
      </div>
    </div>
  </div>`;
            document.getElementById("search-results").insertAdjacentHTML("beforebegin", booking);
            let modal = document.getElementById("modal");
            modal.style.display = "block";

            let closeButton = document.querySelectorAll(".cloBtn");
            for (let i = 0; i < closeButton.length; i++) {
                closeButton[i].addEventListener("click", function() {
                    modal.style.display = "none";
                });
            }
        };
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
</style>