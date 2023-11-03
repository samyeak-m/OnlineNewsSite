<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news-project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['search'])) {
    $searchTerm = '%' . $_GET['search'] . '%'; // Add % for wildcard matching

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM posts WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['title'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No results found.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
