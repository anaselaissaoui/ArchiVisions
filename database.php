<?php 
            try{
              $conn = new PDO("mysql:host=127.0.0.1;dbname=archivision;charset=utf8mb4;", 'root', '');                
            }
            catch(PDOException $e){
              echo 'Erreur : ' . $e->getMessage();
            }
    ?>