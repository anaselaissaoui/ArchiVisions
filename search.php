<?php
require "database.php";

// Retrieve search query from AJAX request
$search = $_POST['search'];

// Retrieve filter option from AJAX request
$filter = $_POST['filter'];

// Set default filter value
$work_type = '';

// Update filter value based on selected option
if ($filter === 'BOOK') {
    $work_type = 'BOOK';
} elseif ($filter === 'DVD') {
    $work_type = 'DVD';
} elseif ($filter === 'MAGAZINE') {
    $work_type = 'MAGAZINE';
}

// Prepare SQL query with filter


if (!empty($work_type)) {
  $sql = "SELECT * FROM works WHERE work_dispo = 1 AND work_title LIKE ? AND work_type = ?";
}else{
  $sql = "SELECT * FROM works WHERE work_dispo = 1 AND work_title LIKE ?";
}

$stmt = $conn->prepare($sql);

// Bind search query parameter
$stmt->bindValue(1, '%'.$search.'%');

// Bind filter parameter if present
if (!empty($work_type)) {
    $stmt->bindValue(2, $work_type);
}

$stmt->execute();
$works = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($works) > 0) {
    foreach ($works as $row) {
        // output the card for each work
        echo '<div class="col">
                  <div class="card h-100 border-primary border-1 shadow-lg">
                    <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
                    <div class="card-body mt-auto">
                      <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                      <p class="card-text">' . $row['work_author'] . '</p>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-center">
                      <a  onclick="bookFunction()"class="btn btn-primary me-3">Book</a>
                      <a  onclick="detailsFunction()" class="btn btn-outline-primary">Details</a>
                    </div>
                  </div>
                </div>';
    }
} else {
  echo "<h2 class='text-center text-danger m-auto'>No Results Found</h2>";
}
?>
