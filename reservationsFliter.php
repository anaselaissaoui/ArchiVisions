<?php
require "database.php";

$mem_id = $_POST['mem_id'];
$filter = $_POST['filter'];

if ($filter == 'ALL') {
  $query2 = "SELECT b.book_id, w.work_title, w.work_state, w.work_author, w.work_img, w.work_id
             FROM booking b 
             JOIN member m ON b.mem_id = m.mem_id 
             JOIN works w ON b.work_id = w.work_id 
             WHERE m.mem_id = :mem_id";
} else {
  $query2 = "SELECT b.book_id, w.work_title, w.work_state, w.work_author, w.work_img, w.work_id
             FROM booking b 
             JOIN member m ON b.mem_id = m.mem_id 
             JOIN works w ON b.work_id = w.work_id 
             WHERE m.mem_id = :mem_id AND b.book_status = :status";
}

$stmt = $conn->prepare($query2);
$stmt->bindParam(':mem_id', $mem_id, PDO::PARAM_INT);

if ($filter != 'ALL') {
  $stmt->bindParam(':status', $filter, PDO::PARAM_STR);
}

$stmt->execute();
$results3 = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results3) > 0) {
  foreach ($results3 as $row) {
    // output the card for each work
    echo '<div class="col">
            <div class="card h-100 border-primary border-1 shadow-lg">
              <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
              <div class="card-body mt-auto">
                <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                <p class="card-text">' . $row['work_author'] . '</p>
              </div>
              <div class="card-footer d-flex align-items-center justify-content-center">
                <a onclick="detailsFunction()" class="btn btn-outline-primary">Details</a>
              </div>
            </div>
          </div>';
  }
} else {
  echo "<h2 class='text-center text-danger m-auto'>No Results Found</h2>";
}
?>
