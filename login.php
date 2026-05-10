<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_registration";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Debugging: Display fetched email (optional)
        echo "Email fetched: " . $row['email'] . "<br>";

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['user'] = $email;
            header("Location: Search.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>
