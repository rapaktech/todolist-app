<?php
    /* Modify $username, $password and $dbname variable to match your own */
    
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "ToDoList";
    $item = "";
    $updatedItem = "";
    $array = [];
    $conn = new mysqli ($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        $conn = new mysqli ($servername, $username, $password, $dbname);
    }

    $post = $conn->prepare("INSERT INTO Items (item) VALUES (?)");
    $post->bind_param("s", $item);

    $update = $conn->prepare("UPDATE Items SET item=? WHERE item=?");
    $update->bind_param("ss", $updatedItem, $item);

    $delete = $conn->prepare("DELETE FROM Items WHERE item=?");
    $delete->bind_param("s", $item);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: #FF0000;
        }

        .items {
            padding-top: 50px;
        }
    </style>
    <title>To-Do List App</title>
</head>
<body>
<?php
    // define variables and set to empty values
    $itemErr = "";
    $item ="";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) == true) {
        if (empty($_POST["item"])) {
            $itemErr = "Input field cannot be empty";
        } else {
            $item = test_input($_POST["item"]);
            $post->execute();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save']) == true) {
        if (empty($_POST["radio"])) {
            echo "Select one of the radio buttons to update";
        } else {
            if (empty($_POST["update"])) {
                echo "Update field cannot be empty. Please write something before you update";
            } else {
                $item = $_POST["radio"];
                $updatedItem = test_input($_POST["update"]);
                $update->execute();
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-btn']) == true) {
        if (empty($_POST["radio"])) {
            echo "Select one of the radio buttons to delete";
        } else {
            $item = $_POST["radio"];
            $delete->execute();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function readAllItems () {
        global $array, $conn;
        $sql = "SELECT id, item FROM Items";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $array[$row["id"] - 1] = $row["item"];
            }
            return true;
        } else {
            return false;
        }
    }

?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h4>Add New Item To List:<h4> <input type="text" name="item" value="">
        <span class="error">* <?php echo $itemErr;?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>


    <div class="items">
        <form id="radio-form" action="" method="post">
            <h4>To-Do List</h4>
            <?php 
                if (readAllItems()) {
                    foreach ($array as $key => $value) {
                        echo "<input type=\"radio\" name=\"radio\" id=\"key{$key}\" value=\"{$value}\"> {$value} <br><br>";
                    }
                } else {
                    echo "No items added yet";
                }
            ?>
                <input type="button" name="update-btn" id="update-btn" value="Update">
                <input type="submit" name="delete-btn" id="delete-btn" value="Delete">
        </form>
    </div>

<script src="script.js"></script>
</body>
</html>