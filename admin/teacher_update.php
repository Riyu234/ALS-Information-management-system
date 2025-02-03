<?php

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example: Retrieve data from POST
        $teacher_id = $_POST['id'];
        $teacher_name = $_POST['first_name'];
        $teacher_lastname = $_POST['last_name'];
        $teacher_middlename = $_POST['middle_name'];
        $gender = $_POST['gender'];
        $contact_number = $_POST['contact_number'];
        $mailing_address = $_POST['mailing_address'];
        $age = $_POST['age'];
        $subject_specialization = $_POST['subject_specialization'];

        // Update query with bindParam
        $query = $conn->prepare("UPDATE teacher 
                                 SET first_name=:firstname, 
                                     last_name=:lastname, 
                                     middle_name=:middlename, 
                                     gender=:gender, 
                                     contact_number=:contact_number, 
                                     email=:mailing_address, 
                                     age=:age, 
                                     subject_specialization=:subject_specialization 
                                 WHERE teacher_id=:id");

        // Binding parameters
        $query->bindParam(':firstname', $teacher_name);
        $query->bindParam(':lastname', $teacher_lastname);
        $query->bindParam(':middlename', $teacher_middlename);
        $query->bindParam(':gender', $gender);
        $query->bindParam(':contact_number', $contact_number);
        $query->bindParam(':mailing_address', $mailing_address);
        $query->bindParam(':age', $age);
        $query->bindParam(':subject_specialization', $subject_specialization);
        $query->bindParam(':id', $teacher_id);

        // Execute the query
        $query->execute();

        // Redirect after updating and include the teacher's ID in the URL
        header("Location: teacherview.php?id=" . $teacher_id);
        exit(); // Always call exit after header to stop further execution

}
?>
