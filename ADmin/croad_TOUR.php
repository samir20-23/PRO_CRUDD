<?php
include "all.php";
try {
    $search = "";
    if (isset($_POST["search"])) {
        $search = $_POST['search'];
    }
    $con = new PDO($sql, $user, $pass);
    $select = $con->prepare("SELECT * FROM $tbnameTour WHERE tour_id LIKE :search OR tour_name LIKE :search OR tour_description LIKE :search OR tour_adddescription LIKE :search");
    $select->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $select->execute();
    $fetchAll = $select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["edit"])) { 
        try {
            $con = new PDO($sql, $user, $pass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $tourId = filter($_POST["tourId"]);
            $tourName = filter($_POST["tourName"]);
            $tourPrice = filter($_POST["tourPrice"]);
            $tourDescription = filter($_POST["tourDescription"]);
            $tourAdddescription = filter($_POST["tourAdddescription"]);

        
            $updateQuery = "UPDATE $tbnameTour SET tour_name=:tourName, tour_price=:tourPrice, tour_description=:tourDescription, tour_adddescription=:tourAdddescription";

            $updateQuery .= " WHERE tour_id=:tourId";
            
            $update = $con->prepare($updateQuery);
            $update->bindParam(":tourId", $tourId);
            $update->bindParam(":tourName", $tourName);
            $update->bindParam(":tourPrice", $tourPrice);
            $update->bindParam(":tourDescription", $tourDescription);
            $update->bindParam(":tourAdddescription", $tourAdddescription);
            
   

            $update->execute();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    foreach ($fetchAll as $v) {
        if (isset($_POST["delete" . $v["tour_id"]])) {
            try {
                $con = new PDO($sql, $user, $pass);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $delete = $con->prepare("DELETE FROM $tbnameTour WHERE tour_id=:tourId");
                $delete->bindParam(":tourId", $v["tour_id"]);
                $delete->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CROUAD.css">
    <title>Document</title>

</head>
<body>
<div  id="hidden" >
      <h2>Logo</h2>
      <h1>Dashboard</h1>
      <ul  id="Ul" >
        <li><a href="#TOUR" id="tour">TOUR</a></li>
        <li ><a href="#CLIENT" id="client" >CLIENT</a></li>
        <li ><a href="#VIEW" id="view" >VIEW</a></li>
        <li ><a href="#RESERVE" id="reserve" >RESERVE</a></li>
        <li ><a href="#BOOK" id="book" >BOOK</a></li>

      </ul><br>     
    </div>
  
    <form action="" method="POST">
        <input type="text" name="search">
        <input type="submit" name="submit" value="Search">
    </form>
    <div id="allcrodtableselecte">
        <table>
            <tr>
                <th id="widthCroad" >tour_id</th>
                <th id=''           >tour_name</th>
                <th id="widthCroad">tour_price</th>
                <th id=""          >tour_description</th>
                <th id=""          >tour_adddescription</th>
                <th id="widthCroadImgs">tour_img</th>
                <th id="widthCroadImgs">tour_img2</th>
                <th id="widthCroadImgs">tour_img3</th>
                <th id="widthCroadImgs">tour_img4</th>
                <th id="widthCroad">EDIT</th>
                <th id="widthCroad">DELETE</th>
                <th id="widthCroad"><a href="TOUR_ADD/add.html">ADD</a></th>
            </tr>
            <?php if (!empty($fetchAll)) : ?>
                <?php foreach ($fetchAll as $v) : ?>
                    <tr>
                        <form action="" method="post">
                            <td><input type="text" name="tourId" value="<?php echo $v['tour_id']; ?>"></td>
                            <td><input type="text" id="tourName" name="tourName" value="<?php echo $v['tour_name']; ?>"></td>
                           
         <td><input type="text" id="tourPrice" name="tourPrice" value="<?php echo $v['tour_price']; ?>"></td>
                            <td><input type="text" id="tourDescription" name="tourDescription" value="<?php echo $v['tour_description']; ?>"></td>
                            <td><input type="text" id="tourAdddescription" name="tourAdddescription" value="<?php echo $v['tour_adddescription']; ?>"></td>
                            <td><img src="TOUR_ADD/tour_images/<?php echo ($v['tour_img']); ?>" alt="Tour Image" id="tourimg" name="tourimg"></td>
                            <td><img src="TOUR_ADD/tour_images/<?php echo ($v['tour_img2']); ?>" alt="Tour Image" id="tourImg2" name="tourImg2"></td>
                            <td><img src="TOUR_ADD/tour_images/<?php echo ($v['tour_img3']); ?>" alt="Tour Image" id="tourImg3" name="tourImg3"></td>
                            <td><img src="TOUR_ADD/tour_images/<?php echo ($v['tour_img4']); ?>" alt="Tour Image" id="tourImg4" name="tourImg4"></td>
                            <td><input type="submit" name="edit" id="edit" value="Edit"></td>
                            <td><input type="submit" name="delete<?php echo $v['tour_id']; ?>" id="delete" value="Delete"></td>
                        </form>
                    </tr>   
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    <script src="CROAD_JS.js"></script>
    <script>
    let tour = document.getElementById("tour");
            tour.setAttribute("style", `
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
