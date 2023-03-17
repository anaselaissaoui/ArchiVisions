<?php 
session_start();
require "database.php";

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
    <link rel="shortcut icon" href="./img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./style.css">
    <title>Admin - Sign In</title>
</head>

<body>

    <header class="">
        <div class="container-fluid px-5">
            <div class="align-items-center d-flex justify-content-between px-5 py-3">
                <a href="./dashboard.php"><img src="./img/logo1.png" alt="" height="60px"></a>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="./img/works.png" alt="">
            </div>
            <div class="text-center mt-4 name">
                Add Work
            </div>
            <form class="p-3 mt-3" method="post" enctype="multipart/form-data">
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-cursor-text"></span>
        <input type="text" name="title" id="title" placeholder="Title" />
    </div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-person"></span>
        <input type="text" name="author" id="author" placeholder="Author" />
    </div>
    <div class="form-field d-flex align-items-center">
  <span class="bi bi-image"></span>
  <label for="image">Upload Image</label>
  <input type="file" name="image" id="image"accept="image/*">
</div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-bricks"></span>
        <select name="state" id="state">
            <option value="4">New</option>
            <option value="3">Used - Like New</option>
            <option value="2">Used - Good</option>
            <option value="1">Used - Bad</option>
        </select>
    </div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-person"></span>
        <select name="type" id="type">
            <option value="BOOK">Book</option>
            <option value="DVD">DVD</option>
            <option value="MAGAZINE">Magazine</option>
        </select>
    </div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-person"></span>
        <input type="number" name="pages" id="pages" placeholder="Pages" />
    </div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-calendar"></span>
        <input type="date" name="pub_d" id="pub_d" placeholder="Publish Date" />
    </div>
    <div class="form-field d-flex align-items-center">
        <span class="bi bi-calendar"></span>
        <input type="date" name="purch_d" id="purch_d" placeholder="Purchase Date" />
    </div>

            
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title  = $_POST['title'];
    $author = $_POST['author'];
    $state = $_POST['state'];
    $type = $_POST['type'];
    $pages = $_POST['pages'];
    $pub_d = $_POST['pub_d'];
    $purch_d = $_POST['purch_d'];
    $libid = $_SESSION['lib_id'];
    $dispo = "0";

    if (!isset($title) || !isset($author) || !isset($state) 
    || !isset($type) || !isset($pages) || !isset($pub_d) 
    || !isset($purch_d) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        echo '<h6 class="text-danger">**please enter all the values</h6>';
    } else {

	$imagename = $_FILES['image']['tmp_name'];
        $filename = $_FILES["image"]["name"];
        $fileExtension = explode('.', $filename);
        $fileExtension = end($fileExtension);
        $filename = uniqid('', true) . ".$fileExtension";
        $folder = "./img/" . $filename;
        move_uploaded_file($imagename, $folder);

        $allowedExtensions = array('jpg', 'png', 'jpeg');
        if (!in_array($fileExtension1, $allowedExtensions)){

            echo  "<span class='error-message'>Only JPG and PNG and JPEG Extensions are allowed!'</span>";
        }
            $stmt = $conn->prepare("INSERT INTO works (work_title, work_author, work_img,work_state, work_type, work_pub_d, work_purch_d,work_pages,work_dispo, lib_id) 
            VALUES ( :work_title,  :work_author,  :work_img, :work_state,  :work_type,  :work_pub_d,  :work_purch_d, :work_pages, :work_dispo, :lib_id)");
             
                $stmt->bindParam(':work_title', $title);
                $stmt->bindParam(':work_author', $author);
                $stmt->bindParam(':work_img', $folder);
                $stmt->bindParam(':work_state', $state);
                $stmt->bindParam(':work_type', $type);
                $stmt->bindParam(':work_pub_d', $pub_d);
                $stmt->bindParam(':work_purch_d', $purch_d);
                $stmt->bindParam(':work_pages', $pages);
                $stmt->bindParam(':work_dispo', $dispo);
                $stmt->bindParam(':lib_id', $libid);

                $stmt->execute();
                header ("location: works.php");
	}
	
	
}

                if (isset($error)) {
                    echo "<p class='para' style='color: red;'>" . $error . "</p>";
                }


                ?>

                <button type="submit" class="btn mt-3">Add</button>
            </form>

        </div>





    </main>

    <div>

    </div>

</body>

</html>
<style>
    .wrapper {
        max-width: 600px;
        min-height: 500px;
        margin: 20px auto;
        padding: 20px 30px 30px 30px;
        background-color: #ecf0f3;
        border-radius: 15px;
        box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
    }

    .logo {
        width: 80px;
        margin: auto;
    }

    .logo img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;

    }

    .wrapper .name {
        font-weight: 600;
        font-size: 1.4rem;
        letter-spacing: 1.3px;
        padding-left: 10px;
        color: #555;
    }

    .wrapper .form-field input , select{
        width: 100%;
        display: block;
        border: none;
        outline: none;
        background: none;
        font-size: 1.2rem;
        color: #666;
        padding: 10px 15px 10px 10px;
        /* border: 1px solid red; */
    }

    .wrapper .form-field  {
        padding-left: 10px;
        margin-bottom: 20px;
        border-radius: 20px;
        box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
    }

    .wrapper .form-field .bi {
        color: #555;
    }

    .wrapper .btn {
        box-shadow: none;
        width: 100%;
        height: 40px;
        background-color: #03A9F4;
        color: #fff;
        border-radius: 25px;
        box-shadow: 3px 3px 3px #b1b1b1,
            -3px -3px 3px #fff;
        letter-spacing: 1.3px;
    }

    .wrapper .btn:hover {
        background-color: #039BE5;
    }

    .wrapper a {
        text-decoration: none;
        font-size: 0.8rem;
        color: #03A9F4;
    }

    .wrapper a:hover {
        color: #039BE5;
    }

    @media(max-width: 380px) {
        .wrapper {
            margin: 30px 20px;
            padding: 40px 15px 15px 15px;
        }
    }
   
    .wrapper .form-field label{
        width: 145%;
        display: block;
        border: none;
        outline: none;
        background: none;
        font-size: 1.2rem;
        color: #666;
        padding-left:10px;
    }

    input[type="file"]::-webkit-file-upload-button {
  color: #fff;
  border-radius: 25px;
  box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
  outline: none;
  border: none;
  cursor: pointer;
  font-size: 0.8rem;
 
}
input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
}

 input[type="file"] {
  opacity: 0;
}


    
</style>