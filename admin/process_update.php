<?php
// Assuming you've already created a PDO connection here as $conn
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the form data
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    $zipcode = $_POST['zipcode'];
    $province = $_POST['province'];
    $civil_status = $_POST['civil_status'];

    // Update query for the learner
    $updateLearnerQuery = "
        UPDATE learner 
        SET 
            firstname = :firstname, 
            lastname = :lastname, 
            middlename = :middlename, 
            birth_date = :birthdate, 
            gender = :gender, 
            contact_number = :contact_number, 
            email = :email
        WHERE learner_id = :id
    ";
    $stmt = $conn->prepare($updateLearnerQuery);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':middlename', $middlename);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Update query for the learner's address
    $updateAddressQuery = "
        UPDATE learners_address
        SET 
            barangay = :barangay,
            municipality = :municipality,
            province = :province,
            zipcode = :zipcode
        WHERE learners_id = :id
    ";
    $stmt2 = $conn->prepare($updateAddressQuery);
    $stmt2->bindParam(':barangay', $barangay);
    $stmt2->bindParam(':municipality', $municipality);
    $stmt2->bindParam(':province', $province);
    $stmt2->bindParam(':zipcode', $zipcode);
    $stmt2->bindParam(':id', $id);
    $stmt2->execute();

    // Redirect after updating (optional)
    header("Location: profileviewing.php?id=" . $id); // Appending the ID to the URL
    exit();
}
?>
