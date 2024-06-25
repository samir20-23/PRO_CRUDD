<?php
include "all.php";

try {
    $con = new PDO($sql, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle search
    $search = isset($_POST["search"]) ? $_POST["search"] : '';
    $select = $con->prepare("SELECT * FROM $tbnameClient WHERE client_id LIKE :search OR client_fullname LIKE :search OR client_email LIKE :search OR client_phone LIKE :search");
    $select->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $select->execute();
    $fetchAll = $select->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle edit
        if (isset($_POST["edit"])) { 
            try {
                $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_STRING);
                $clientFullname = filter_input(INPUT_POST, 'clientFullname', FILTER_SANITIZE_STRING);
                $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
                $clientTy = filter_input(INPUT_POST, 'clientTy', FILTER_SANITIZE_STRING);
                $clientPhone = filter_input(INPUT_POST, 'clientPhone', FILTER_SANITIZE_STRING);
                $clientAge = filter_input(INPUT_POST, 'clientAge', FILTER_SANITIZE_NUMBER_INT);
                $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

                $updateQuery = "UPDATE $tbnameClient SET client_fullname=:clientFullname, client_email=:clientEmail, client_ty=:clientTy, client_phone=:clientPhone, client_age=:clientAge, client_password=:clientPassword WHERE client_id=:clientId";
                $update = $con->prepare($updateQuery);
                $update->bindParam(":clientId", $clientId);
                $update->bindParam(":clientFullname", $clientFullname);
                $update->bindParam(":clientEmail", $clientEmail);
                $update->bindParam(":clientTy", $clientTy);
                $update->bindParam(":clientPhone", $clientPhone);
                $update->bindParam(":clientAge", $clientAge);
                $update->bindParam(":clientPassword", $clientPassword);

                $update->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        // Handle delete
        foreach ($fetchAll as $v) {
            if (isset($_POST["delete" . $v["client_id"]])) {
                try {
                    $delete = $con->prepare("DELETE FROM $tbnameClient WHERE client_id=:clientId");
                    $delete->bindParam(":clientId", $v["client_id"]);
                    $delete->execute();

                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CROUAD.css">
    <title>Client Management</title>
</head>
<body>

<!--  -->
<div  id="hidden" >
      <h2>Logo</h2>
      <h1>Dashboard</h1>
      <ul  id="Ul" >
        <li><a href="#section2" id="tour">TOUR</a></li>
        <li ><a href="#section3" id="client" >CLIENT</a></li>
        <li ><a href="#section3" id="view" >VIEW</a></li>
        <li ><a href="#RESERVE" id="reserve" >RESERVE</a></li>
        <li ><a href="#BOOK" id="book" >BOOK</a></li>
      </ul><br>     
    </div>
<!--  -->

    <form action="" method="POST">
        <input type="text" name="search">
        <input type="submit" name="submit" value="Search">
    </form>
    <div id="allcrodtableselecte">
        <table>
            <tr>
                <th id="widthCroad">client_id</th>
                <th                >client_fullname</th>
                <th                >client_email</th>
                <th id="widthCroad">client_ty</th>
                <th id="widthCroadPhone">client_phone</th>
                <th                >client_password</th>
                <th id="widthCroad">client_age</th>
                <th id="widthCroad">EDIT</th>
                <th id="widthCroad">DELETE</th>
                <th id="widthCroad"><a href="CLIENT_ADD/add.html" >ADD</a> </th>
            </tr>
            <?php if (!empty($fetchAll)) : ?>
                <?php foreach ($fetchAll as $v) : ?>
                    <tr>
                        <form action="" method="post">
                            <td><input type="text" name="clientId" value="<?php echo htmlspecialchars($v['client_id']); ?>"></td>
                            <td><input type="text" name="clientFullname" value="<?php echo htmlspecialchars($v['client_fullname']); ?>"></td>
                            <td><input type="text" name="clientEmail" value="<?php echo htmlspecialchars($v['client_email']); ?>"></td>
                            <td><input type="text" name="clientTy" value="<?php echo htmlspecialchars($v['client_ty']); ?>"></td>
                            <td><input type="text" name="clientPhone" value="<?php echo htmlspecialchars($v['client_phone']); ?>"></td>
                            <td><input type="text" name="clientPassword" value="<?php echo htmlspecialchars($v['client_password']); ?>"></td>
                            <td><input type="text" name="clientAge" value="<?php echo htmlspecialchars($v['client_age']); ?>"></td>
                            <td><input type="submit" name="edit" value="Edit"></td>
                            <td><input type="submit" name="delete<?php echo htmlspecialchars($v['client_id']); ?>" value="Delete"></td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
<script src="CROAD_JS.js"></script>
<script>
    let client = document.getElementById("client");
            client.setAttribute("style", `
                text-shadow: 0 0 2px #031ff4;
                border-bottom: 5px solid #ff601c;
                font-size: 26px;
                font-weight: bold;
                background-image: url('CLIENT_ADD/img/background.jpg');
                background-size: cover; /* or another appropriate value */
                background-clip: text;
                -webkit-background-clip: text;
                color: transparent;
            `);

</script>
</body>
</html>

