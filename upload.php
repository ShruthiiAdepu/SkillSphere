<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);

    // Allow all file types
    $file_tmp = $_FILES["fileInput"]["tmp_name"];
    $file_name = $_FILES["fileInput"]["name"];
    $file_data = file_get_contents($file_tmp); // Get file as binary data

    // Move the file to the uploads directory
    if (move_uploaded_file($file_tmp, $target_file)) {
        $caption = $conn->real_escape_string($_POST["caption"]);
        $link = $conn->real_escape_string($_POST["link"]);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO uploads (image_path, caption, link) VALUES (?, ?, ?)");
        $stmt->bind_param("bss", $file_data, $caption, $link);
        $stmt->send_long_data(0, $file_data);

        if ($stmt->execute()) {
            header("Location: profile.php"); // Redirect to profile page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Unable to move the uploaded file.";
    }
}

$conn->close();
?>
