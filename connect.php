
<?php
// Capture form data
$Uname = $_POST['Uname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];

// Check if any field is empty
if (!empty($Uname) && !empty($gender) && !empty($age) && !empty($email) && !empty($password) && !empty($phone)) {
    $host = "localhost";
    $dbUname = "root"; // Username for MySQL
    $dbpassword = ""; // Password for MySQL
    $dbname = "registration_form"; // Database name

    // Create connection
    $conn = new mysqli($host, $dbUname, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $SELECT = "SELECT email FROM record WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO record (name, gender, age, email, passwords, phone) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssisss", $Uname, $gender, $age, $email, $password, $phone);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>

