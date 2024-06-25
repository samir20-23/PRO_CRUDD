<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../all.php";


    $clientFullname = filter($_POST["clientFullname"]);
    $clientEmail = filter($_POST["clientEmail"]);
    $clientTy = filter($_POST["clientTy"]);
    $clientPhone = filter($_POST["clientPhone"]);
    $clientAge = filter($_POST["clientAge"]);
    $clientPassword = filter($_POST["clientPassword"]);

    if(!empty($clientFullname)) {
        try {
            $con = new PDO($sql, $user, $pass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $query = "SELECT client_email FROM $tbnameClient WHERE client_email = :clientEmail";
            $select = $con->prepare($query);
            $select->bindParam(':clientEmail', $clientEmail, PDO::PARAM_STR);
            $select->execute();
            
            $fetch = $select->fetch(PDO::FETCH_ASSOC);
            
            if ($fetch && $fetch["client_email"] == $clientEmail) {
                echo "aredyemail";
            } else {
                
            $insert = $con->prepare("INSERT INTO $tbnameClient (client_fullname, client_email, client_ty, client_phone, client_age, client_password) VALUES (:clientFullname, :clientEmail, :clientTy, :clientPhone, :clientAge, :clientPassword)");
            $insert->bindParam(":clientFullname", $clientFullname);
            $insert->bindParam(":clientEmail", $clientEmail);
            $insert->bindParam(":clientTy", $clientTy);
            $insert->bindParam(":clientPhone", $clientPhone);
            $insert->bindParam(":clientAge", $clientAge);
            $insert->bindParam(":clientPassword", $clientPassword);

            $insert->execute();
             echo "verified";
             }
           
        } catch (PDOException $e) {
            echo "notverified: " . $e->getMessage();
        }
    } else {
        echo "clientFullnameempty";
    }
}
?>
