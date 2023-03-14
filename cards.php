<?php

if (count($results) > 0) {
    $grouped_works = array();
    foreach ($results as $row) {
        $grouped_works[$row['work_title']][] = $row;
    }
    // sort the array by work_state in descending order
    usort($grouped_works, function($a, $b) {
        $a_state = $a[0]['work_state'];
        $b_state = $b[0]['work_state'];
        return ($a_state == $b_state) ? 0 : (($a_state > $b_state) ? -1 : 1);
    });
                    foreach ($grouped_works as $group) {
                        $row = $group[0];
                        echo '<div class="col">
                        <div class="card h-100 border-primary border-1 shadow-lg">
                            <img src="' . $row['work_img'] . '" class="card-img-top img-fluid" style="height: 350px; object-fit: cover;" alt="">
                            <div class="card-body mt-auto">
                            <h5 class="card-title text-primary">' . $row['work_title'] . '</h5>
                            <p class="card-text">' . $row['work_author'] . '</p>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-center">
                            <a id="' . $row['work_id'] . '" class="btn btn-primary me-3" onclick="bookFunction(' . $row['work_id'] . ')">Book</a>
                            <a id="' . $row['work_id'] . '" onclick="detailsFunction()" class="btn btn-outline-primary" style="text-decoration:none;">Details</a>
                            </div>
                        </div>
                        </div>';
                    }
                } else {
                    echo "<h2 class='text-center text-danger'>No Results Found</h2>";
                }

            ?>
