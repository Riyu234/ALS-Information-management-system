<?php


$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $learnerId = $_POST['learnerId'] ?? null;
    $firstName = $_POST['firstName'];
    $lastName = sha1($_POST['lastName']);
    $userType = $_POST['userType'];


    $account = 'yes';
    $student = 'student';
    $admin = 'admin';
    $teacher = 'teacher';

    
        // Insert into the appropriate table based on the user type
        // First, check if the username already exists
$stmtCheck = $conn->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
$stmtCheck->bindParam(':username', $firstName); // Assuming $firstName is the username
$stmtCheck->execute();
$userExists = $stmtCheck->fetchColumn();

if ($userExists > 0) {
    // Username already exists
    echo "<script>alert('Username already used.');</script>";
echo "<script>setTimeout(function(){ window.location.href = 'adduser.php?table=$userType'; }, 1000);</script>";
exit;

    
} else {
    if ($userType == 'student') {
        // Insert into the 'learner' table for students
        $stmt = $conn->prepare("INSERT INTO user (student_id, username, password, role) VALUES (:learner_id, :username, :password, :role)");
        $stmt->bindParam(':learner_id', $learnerId);

        $stmt4 = $conn->prepare("UPDATE learner SET account=:account WHERE learner_id =:ids");
        $stmt4->bindParam(':ids', $learnerId);
        $stmt4->bindParam(':account', $account);
        $stmt4->execute();
    } elseif ($userType == 'teacher') {
        // Insert into the 'teacher' table for teachers
        $stmt = $conn->prepare("INSERT INTO user (teacher_id, username, password, role) VALUES (:teacher_id, :username, :password, :role)");
        $stmt->bindParam(':teacher_id', $learnerId);

        $stmt3 = $conn->prepare("UPDATE teacher SET account=:account WHERE teacher_id =:ids");
        $stmt3->bindParam(':ids', $learnerId);
        $stmt3->bindParam(':account', $account);
        $stmt3->execute();

        // Assuming 'learner_id' can be used for 'teacher_id'
    }

    // Bind parameters for username, password, and role
    $stmt->bindParam(':role', $userType);
    $stmt->bindParam(':username', $firstName); // Username bound to $firstName
    $stmt->bindParam(':password', $lastName);  // Password bound to $lastName

    // Execute the query
    $stmt->execute();

    // Redirect back to the user management page after successful insertion
    header("Location: users.php?table=$userType");
    exit;
}}
 

?>

<?php include("../includes/footer.php"); ?>
