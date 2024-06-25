<?php
function filter($data){
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

$host = "localhost";
$user = "SAMIR";
$pass = "samir123";
$dbname = "booking";
$tbnameBook = "book";
$sql = "mysql:host=$host;dbname=$dbname";

try {
    $con = new PDO($sql, $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle search
    $search = isset($_POST["search"]) ? $_POST["search"] : '';
    $select = $con->prepare("SELECT * FROM $tbnameBook WHERE book_id LIKE :search OR client_id LIKE :search OR tour_id LIKE :search OR reserve_id LIKE :search");
    $select->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $select->execute();
    $fetchAll = $select->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle edit
        if (isset($_POST["edit"])) {
            try {
                $bookId = filter($_POST['book_id']);
                $clientId = filter($_POST['client_id']);
                $tourId = filter($_POST['tour_id']);
                $reserveId = filter($_POST['reserve_id']);

                $updateQuery = "UPDATE $tbnameBook SET 
                                client_id=:client_id, 
                                tour_id=:tour_id, 
                                reserve_id=:reserve_id
                                WHERE book_id=:book_id";
                $update = $con->prepare($updateQuery);
                $update->bindParam(":book_id", $bookId);
                $update->bindParam(":client_id", $clientId);
                $update->bindParam(":tour_id", $tourId);
                $update->bindParam(":reserve_id", $reserveId);

                $update->execute();

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        // Handle delete
        foreach ($fetchAll as $v) {
            if (isset($_POST["delete" . $v["book_id"]])) {
                try {
                    $delete = $con->prepare("DELETE FROM $tbnameBook WHERE book_id=:book_id");
                    $delete->bindParam(":book_id", $v["book_id"]);
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
    <title>Book Management</title>
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
            <th>book_id</th>
            <th>client_id</th>
            <th>tour_id</th>
            <th>reserve_id</th>
            <th>EDIT</th>
            <th>DELETE</th> 
        </tr>
        <?php if (!empty($fetchAll)) : ?>
            <?php foreach ($fetchAll as $v) : ?>
                <tr>
                    <form action="" method="post">
                        <td><input type="text" name="book_id" value="<?php echo htmlspecialchars($v['book_id']); ?>"></td>
                        <td><input type="text" name="client_id" value="<?php echo htmlspecialchars($v['client_id']); ?>"></td>
                        <td><input type="text" name="tour_id" value="<?php echo htmlspecialchars($v['tour_id']); ?>"></td>
                        <td><input type="text" name="reserve_id" value="<?php echo htmlspecialchars($v['reserve_id']); ?>"></td>
                        <td><input type="submit" name="edit" value="Edit"></td>
                        <td><input type="submit" name="delete<?php echo htmlspecialchars($v['book_id']); ?>" value="Delete"></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
<script src="CROAD_JS.js"></script>
<script>
    let book = document.getElementById("book");
    book.setAttribute("style", `
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
