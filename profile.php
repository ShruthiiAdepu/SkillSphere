<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM uploads ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <header>
            <div class="edit">
                <a href="main1.html"><img src="back.png" alt="Back"></a>
            </div>
            <div class="menu">
                <a href="create.html"><img src="pencil.svg" alt="Menu"></a>
            </div>
        </header>

        <div class="profile-info">
            <img src="profile.svg" alt="Profile Picture" class="profile-pic">
            <h1>art berry</h1>
            <h2>@art_berry123</h2>
            <p class="bio">
                Welcome!
            </p>
        </div>

        <div class="posts">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="post">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row["image_path"]) . '" alt="Post Image">';
                    echo '<p class="post-caption">' . htmlspecialchars($row["caption"]) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>No posts available.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>