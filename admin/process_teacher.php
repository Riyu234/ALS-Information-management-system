<?php
// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get teacher form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $email = $_POST['email'];
    $subject_specialization = $_POST['subject_specialization'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $contact_number = $_POST['contact_number'];
    
    // Get address data
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zid_code = $_POST['zid_code'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start transaction to ensure both inserts are done together
        $conn->beginTransaction();

        // Insert into the teacher table
        $sqlInsertTeacher = "INSERT INTO teacher (first_name, last_name, middle_name, email, subject_specialization, gender, age, contact_number) 
                             VALUES (:first_name, :last_name, :middle_name, :email, :subject_specialization, :gender, :age, :contact_number)";
        $stmtTeacher = $conn->prepare($sqlInsertTeacher);
        $stmtTeacher->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':middle_name' => $middle_name,
            ':email' => $email,
            ':subject_specialization' => $subject_specialization,
            ':gender' => $gender,
            ':age' => $age,
            ':contact_number' => $contact_number
        ]);

        // Get the last generated teacher_id
        $teacher_id = $conn->lastInsertId();

        // Insert into the teacher_address table
        $sqlInsertAddress = "INSERT INTO teacher_address (street, barangay, city, province, zid_code, teacher_id) 
                             VALUES (:street, :barangay, :city, :province, :zid_code, :teacher_id)";
        $stmtAddress = $conn->prepare($sqlInsertAddress);
        $stmtAddress->execute([
            ':street' => $street,
            ':barangay' => $barangay,
            ':city' => $city,
            ':province' => $province,
            ':zid_code' => $zid_code,
            ':teacher_id' => $teacher_id
        ]);

        // Commit the transaction
        $conn->commit();

        echo "Teacher added successfully with address details!";
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
