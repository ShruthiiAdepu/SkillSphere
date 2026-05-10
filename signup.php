<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $roll_no = $_POST['roll_no'];
    $college = $_POST['college'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, roll_no, college, password) 
            VALUES ('$email', '$roll_no', '$college', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: photo.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

