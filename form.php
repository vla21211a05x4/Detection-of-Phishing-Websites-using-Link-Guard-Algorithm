<?php 
$host = 'localhost'; //servername
$user = 'root'; //username
$pass = ''; //password
$dbname = 'project'; //database
 
$conn = mysqli_connect($host, $user, $pass, $dbname); 

if (!$conn){ 
    die('Could not connect: ' . mysqli_connect_error()); 
}
echo 'connected';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $text = $_POST['text'];

    // Use prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, text) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $text);

    if ($stmt->execute()) {
        header("Location: form.html"); // Redirect to form.html after successful submission
        exit();
    } else { 
        echo "Could not insert values in table: " . $conn->error; 
    } 

    $stmt->close();
}

mysqli_close($conn); 
?>
