<?php
// PHP code to handle form submission and database interactions
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "project"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['linkInput'])) {
    $link = $_POST['linkInput'];

    // Perform any validation or pre-processing of the link here if needed

    // Check if the URL exists in the database
    $sql = "SELECT * FROM urls WHERE URL = '$link'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // URL exists in the database, fetch and display analysis info
        $row = $result->fetch_assoc();
        $analysis = $row['analysis'];
        $phishingStatus = $analysis === "SUSPICIOUS" ? "red" : "green";

        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
        echo "<div style='text-align: center; padding: 40px; border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9;'>";
        echo "<p>Your Input URL:</p>";
        
        // Check if the URL is clean, and set the color accordingly
        if ($phishingStatus === "green") {
            echo "<p style='font-size: 18px; margin: 0;'><a href='$link' style='color: blue; text-decoration: none;' target='_blank'>$link</a></p>";
        } else {
            echo "<p style='font-size: 18px; margin: 0;'><a href='$link' style='color: black; text-decoration: none;' target='_blank'>$link</a></p>";
        }
        //echo "<p>[Now you can open the URL by clicking on the link above]</p>";
        echo "<p>URL Analysis:</p>";
        echo "<pre style='color: $phishingStatus; font-size: 24px;'>$analysis</pre>";
        echo "</div>";
        echo "</div>";

        exit();
    } else {
        // URL not present in the database, suggest the user to copy the URL
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
        echo "<div style='text-align: center; padding: 40px; border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9;'>";
        echo "<p>Your Input URL:</p>";
        echo "<p style='font-size: 18px; margin: 0;'>$link</p>";
        echo "<p>URL Analysis:</p>";
        echo "<pre style='color: black; font-size: 24px;'>Error: The URL could not be analyzed. Please copy the URL for further analysis.</pre>";
        echo "</div>";
        echo "</div>";

        exit();
    }

    $conn->close();
}
?>
