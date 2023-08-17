<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database and query for the user
    $dbhost = 'localhost';
    $dbname = 'airline';
    $dbuser = 'root';
    $dbpass = '';
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $stmt = $conn->prepare("SELECT * FROM register WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // check if the password matches
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            header('Location: my-bookings.php');
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    } else {
        $error = 'Invalid email or password';
    }
    
}
?>

