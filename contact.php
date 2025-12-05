<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Use null coalescing operator ?? to avoid undefined index
    $full_name   = htmlspecialchars(trim($_POST['full_name'] ?? ''));
    $email       = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone       = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $service     = htmlspecialchars(trim($_POST['service_type'] ?? ''));
    $message     = htmlspecialchars(trim($_POST['message'] ?? ''));


    // PDO connection
    $host = "localhost";
    $dbname = "landing_page";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    // Prepared statement
    $sql = "INSERT INTO real_estate_leads (full_name, email, phone, service_type, message) 
            VALUES (:full_name, :email, :phone, :service_type, :message)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':service_type', $service);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo "Thank you! Your inquiry has been received.";
    } else {
        echo "Something went wrong. Please try again.";
    }
} else {
    // If accessed directly without POST
    echo "Please submit the form first.";
}
?>
