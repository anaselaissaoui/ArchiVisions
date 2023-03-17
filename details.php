<?php
require 'database.php';
$workId = $_POST['work_id'];
echo "1";


$stmt = $conn->prepare('SELECT * FROM works WHERE work_id = :work_id');
$stmt->bindParam(':work_id', $workId);
$stmt->execute();
echo "2";
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$html = '
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-body py-0">
        <div class="d-flex justify-content-evenly align-items-center">
          <img class="bg-image promo-img me-3 w-50" src="'. $row['work_img'].'">
          <div class="content-text p-4 px-5 align-item-stretch">
            <div class="text-center">
              <h3 class="mb-3 text-primary line">'.$row['work_title'].'</h3>
              <p class="mb-5 fw-semibold">'.$row['work_author'].'</p>
              <p class="mb-5 fw-bold">'.$row['work_type'].'</p>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>'
;

echo $html;
?>