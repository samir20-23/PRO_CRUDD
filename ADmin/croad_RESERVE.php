<?php
include "all.php";

try {
    $con = new PDO($sql, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle search
    $search = isset($_POST["search"]) ? $_POST["search"] : '';
    $select = $con->prepare("SELECT * FROM $tbnameReserve WHERE reserve_id LIKE :search OR reserve_name LIKE :search OR reserve_email LIKE :search OR reserve_tour LIKE :search");
    $select->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $select->execute();
    $fetchAll = $select->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle edit
        if (isset($_POST["edit"])) {
            try {
                $reserveId = filter($_POST['reserve_id']);
                $reserveName = filter($_POST['reserve_name']);
                $reserveEmail = filter($_POST['reserve_email']);
                $reserveTour = filter($_POST['reserve_tour']);
                $reserveAdults = filter($_POST['reserve_adults']);
                $reserveChild514 = filter($_POST['reserve_child5_14']);
                $reserveChild2 = filter($_POST['reserve_child2']);
                $reserveDepart = filter($_POST['reserve_depart']);
                $reserveReturn = filter($_POST['reserve_return']);
                $reserveMessage = filter($_POST['reserve_message']);

                $updateQuery = "UPDATE $tbnameReserve SET 
                                reserve_name=:reserve_name, 
                                reserve_email=:reserve_email, 
                                reserve_tour=:reserve_tour,
                                reserve_adults=:reserve_adults,
                                reserve_child5_14=:reserve_child5_14,
                                reserve_child2=:reserve_child2,
                                reserve_depart=:reserve_depart,
                                reserve_return=:reserve_return,
                                reserve_message=:reserve_message
                                WHERE reserve_id=:reserve_id";
                $update = $con->prepare($updateQuery);
                $update->bindParam(":reserve_id", $reserveId);
                $update->bindParam(":reserve_name", $reserveName);
                $update->bindParam(":reserve_email", $reserveEmail);
                $update->bindParam(":reserve_tour", $reserveTour);
                $update->bindParam(":reserve_adults", $reserveAdults);
                $update->bindParam(":reserve_child5_14", $reserveChild514);
                $update->bindParam(":reserve_child2", $reserveChild2);
                $update->bindParam(":reserve_depart", $reserveDepart);
                $update->bindParam(":reserve_return", $reserveReturn);
                $update->bindParam(":reserve_message", $reserveMessage);

                $update->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        // Handle delete
        foreach ($fetchAll as $v) {
            if (isset($_POST["delete" . $v["reserve_id"]])) {
                try {
                    $delete = $con->prepare("DELETE FROM $tbnameReserve WHERE reserve_id=:reserve_id");
                    $delete->bindParam(":reserve_id", $v["reserve_id"]);
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
    <title>reserve Management</title>
</head>
<body>

<!--  -->
<div id="hidden">
    <h2>Logo</h2>
    <h1>Dashboard</h1>
    <ul id="Ul">
        <li><a href="#section2" id="tour">TOUR</a></li>
        <li><a href="#section3" id="client">CLIENT</a></li>
        <li><a href="#section3" id="view">VIEW</a></li>
        <li><a href="#RESERVE" id="reserve">RESERVE</a></li>
        <li><a href="#BOOK" id="book">BOOK</a></li>
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
            <th>reserve_id</th>
            <th>reserve_name</th>
            <th>reserve_email</th>
            <th>reserve_tour</th>
            <th>reserve_adults</th>
            <th>reserve_child5_14</th>
            <th>reserve_child2</th>
            <th>reserve_depart</th>
            <th>reserve_return</th>
            <th>reserve_message</th>
            <th>EDIT</th>
            <th>DELETE</th> 
        </tr>
        <?php if (!empty($fetchAll)) : ?>
            <?php foreach ($fetchAll as $v) : ?>
                <tr>
                    <form action="" method="post">
                        <td><input type="text" name="reserve_id" value="<?php echo htmlspecialchars($v['reserve_id']); ?>"></td>
                        <td><input type="text" name="reserve_name" value="<?php echo htmlspecialchars($v['reserve_name']); ?>"></td>
                        <td><input type="text" name="reserve_email" value="<?php echo htmlspecialchars($v['reserve_email']); ?>"></td>
                        <td><input type="text" name="reserve_tour" value="<?php echo htmlspecialchars($v['reserve_tour']); ?>"></td>
                        <td><input type="text" name="reserve_adults" value="<?php echo htmlspecialchars($v['reserve_adults']); ?>"></td>
                        <td><input type="text" name="reserve_child5_14" value="<?php echo htmlspecialchars($v['reserve_child5_14']); ?>"></td>
                        <td><input type="text" name="reserve_child2" value="<?php echo htmlspecialchars($v['reserve_child2']); ?>"></td>
                        <td><input type="text" name="reserve_depart" value="<?php echo htmlspecialchars($v['reserve_depart']); ?>"></td>
                        <td><input type="text" name="reserve_return" value="<?php echo htmlspecialchars($v['reserve_return']); ?>"></td>
                        <td><input type="text" name="reserve_message" value="<?php echo htmlspecialchars($v['reserve_message']); ?>"></td>
                        <td><input type="submit" name="edit" value="Edit"></td>
                        <td><input type="submit" name="delete<?php echo htmlspecialchars($v['reserve_id']); ?>" value="Delete"></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
<script src="CROAD_JS.js"></script>
<script>
    let reserve = document.getElementById("reserve");
    reserve.setAttribute("style", `
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
