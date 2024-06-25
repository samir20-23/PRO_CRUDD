

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../all.php";

    $uploads_dir = 'tour_images/';

    function generateFilename($file) {
        return rand(1000, 10000) . "-" . basename($file["name"]);
    }

    function moveUploadedFile($file, $uploads_dir) {
        $filename = generateFilename($file);
        $target_path = $uploads_dir . $filename;
        if (move_uploaded_file($file["tmp_name"], $target_path)) {
            return $filename;
        }
        return false;
    }

    if (!empty($_FILES["tourImgg"]) && $_FILES['tourImgg']['error'] == UPLOAD_ERR_OK ) {
       if(!empty($_POST["tourName"])){

     
        $tourImgg = moveUploadedFile($_FILES["tourImgg"], $uploads_dir);

if(!empty($_FILES["tourImgg2"]) && $_FILES['tourImgg2']['error'] == UPLOAD_ERR_OK ){
    $tourImgg2 =  moveUploadedFile($_FILES["tourImgg2"], $uploads_dir)   ;
}else{
    $tourImgg2 ="";
}
if(!empty($_FILES["tourImgg3"]) && $_FILES['tourImgg3']['error'] == UPLOAD_ERR_OK ){
    $tourImgg3 =  moveUploadedFile($_FILES["tourImgg3"], $uploads_dir)   ;
}else{
    $tourImgg3 ="";
}
if(!empty($_FILES["tourImgg4"]) && $_FILES['tourImgg4']['error'] == UPLOAD_ERR_OK ){
    $tourImgg4 =  moveUploadedFile($_FILES["tourImgg4"], $uploads_dir)   ;
}else{
    $tourImgg4 ="";
}


        if ($tourImgg) {
            $tourName = filter($_POST["tourName"]);
            $tourPrice = filter($_POST["tourPrice"]);
            $tourDescription = filter($_POST["tourDescription"]);
            $touradddescription = filter($_POST["touradddescription"]);

            try {
                $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $insert = $con->prepare("INSERT INTO $tbnameTour(tour_name, tour_price, tour_description, tour_adddescription, tour_img, tour_img2, tour_img3, tour_img4) VALUES(:tourName, :tourPrice, :tourDescription, :touradddescription, :tourImgg, :tourImgg2, :tourImgg3, :tourImgg4)");
                $insert->bindParam(":tourName", $tourName);
                $insert->bindParam(":tourPrice", $tourPrice);
                $insert->bindParam(":tourDescription", $tourDescription);
                $insert->bindParam(":touradddescription", $touradddescription);
                $insert->bindParam(":tourImgg", $tourImgg);
                $insert->bindParam(":tourImgg2", $tourImgg2);
                $insert->bindParam(":tourImgg3", $tourImgg3);
                $insert->bindParam(":tourImgg4", $tourImgg4);

                $insert->execute();
                echo "verified";
            } catch (PDOException $e) {
                echo "notverified: " . $e->getMessage();
            }
        } else {
            echo "imgDontUpfate";
        }
    
    }else{
        echo "tournameempty";
    }
    } else{
        echo "tourimgeempty";
    }
}
?>
