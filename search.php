<?php
require "database.php";
 // $search = isset($_POST['search']) ? $_POST['search'] : '';
    // $content_query = "SELECT * FROM works";
    // if (!empty($search)) {
    //     $content_query .= " WHERE work_title LIKE :search";
    // }
    // $content = $conn->prepare($content_query);
    // if (!empty($search)) {
    //     $content->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
    // }
    // $content->execute();
    // $results = $content->fetchAll();
    // if (count($results)>0){
    //     foreach ($results as $row) {
    //         echo '<div class="col">
    //                   <div class="card h-100 border-primary border-1 shadow-lg">
    //                     <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
    //                     <div class="card-body mt_auto">
    //                       <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
    //                       <p class="card-text">' . $row['work_author'] . '</p>
    //                     </div>
    //                     <div class="card-footer d-flex align-items-center justify-content-center">
    //                       <a href="booking.php" class="btn btn-primary me-3">Book</a>
    //                       <a href="details.php?item_id=' . $row['work_id'] . ' class="btn btn-outline-primary">Details</a>
    //                     </div>
    //                   </div>
    //                 </div>';
    //     }
    // } else {
    //     echo "No Results Found";
    // }
  // Retrieve search query from AJAX request
  $search = $_POST['search'];

  // Retrieve matching works data from the database
  $stmt = $conn->prepare("SELECT * FROM works WHERE work_dispo = 1 AND work_title LIKE ?");
  $stmt->execute(['%'.$search.'%']);
  $works = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

if (count($works) > 0) {
    foreach ($works as $row) {
        // output the card for each work
        echo '<div class="col">
                      <div class="card h-100 border-primary border-1 shadow-lg">
                        <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
                        <div class="card-body mt_auto">
                          <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                          <p class="card-text">' . $row['work_author'] . '</p>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-center">
                          <a href="booking.php" class="btn btn-primary me-3">Book</a>
                          <a href="details.php?item_id='. $row['work_id'] .'" class="btn btn-outline-primary">Details</a>
                        </div>
                      </div>
                    </div>';
    }
} else {
    echo "No Results Found";
}

?>



