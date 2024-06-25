<?php
include "all.php";

try {
    $con = new PDO($sql, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["edit"])) {
            try {
                $singUp = filter_input(INPUT_POST, 'singUp', FILTER_SANITIZE_STRING);
                $singIn = filter_input(INPUT_POST, 'singIn', FILTER_SANITIZE_STRING);
                $forgot = filter_input(INPUT_POST, 'forgot', FILTER_SANITIZE_EMAIL);
                $editpassword = filter_input(INPUT_POST, 'editpassword', FILTER_SANITIZE_STRING);
                $mailercode = filter_input(INPUT_POST, 'mailercode', FILTER_SANITIZE_STRING);

                $updateQuery = "UPDATE $tbnameView SET singUp=:singUp,singIn=:singIn, forgot=:forgot, editpassword=:editpassword, mailercode=:mailercode ";
                $update = $con->prepare($updateQuery);
                $update->bindParam(":singUp", $singUp);
                $update->bindParam(":singIn", $singIn);
                $update->bindParam(":forgot", $forgot);
                $update->bindParam(":editpassword", $editpassword);
                $update->bindParam(":mailercode", $mailercode);

                $update->execute();
                
             

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    // Fetch data for display
    $fetchQuery = "SELECT * FROM $tbnameView";
    $fetchAll = $con->query($fetchQuery)->fetchAll(PDO::FETCH_ASSOC);

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
        <li><a href="#TOUR" id="tour">TOUR</a></li>
        <li ><a href="#CLIENT" id="client" >CLIENT</a></li>
        <li ><a href="#VIEW" id="view" >VIEW</a></li>
        <li ><a href="#RESERVE" id="reserve" >RESERVE</a></li>
        <li ><a href="#BOOK" id="book" >BOOK</a></li>

      </ul><br>     
    </div>
  <!--  -->
    <div id="allcrodtableselecte">
        <table> 
            <tr>
                <th>singUp</th>
                <th>singIn</th>
                <th>forgot</th>
                <th>editpassword</th>
                <th>mailercode</th>
                <th>EDIT</th>
            </tr>
            <?php if (!empty($fetchAll)) {  ?>
                <?php foreach ($fetchAll as $v){

                    ?>
                    <tr>
                        <form action="" method="post">
                            <td><input type="text" name="singUp" value="<?php echo htmlspecialchars($v['singUp']); ?>"></td>
                            <td><input type="text" name="singIn" value="<?php echo htmlspecialchars($v['singIn']); ?>"></td>
                            <td><input type="text" name="forgot" value="<?php echo htmlspecialchars($v['forgot']); ?>"></td>
                            <td><input type="text" name="editpassword" value="<?php echo htmlspecialchars($v['editpassword']); ?>"></td>
                            <td><input type="text" name="mailercode" value="<?php echo htmlspecialchars($v['mailercode']); ?>"></td>
                            <td><input type="submit" name="edit" value="Edit"></td>
                        </form>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
   <script src="CROAD_JS.js"></script>
   <script>
    let view = document.getElementById("view");
            view.setAttribute("style", `
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
