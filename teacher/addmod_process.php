<?php
$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $module_selected = $_POST['module_selected'];
    $status = "progress";

    $sql3 = $conn->prepare("INSERT INTO module_assigned (module_id, learner_id, status) VALUES (:module_id, :learner_id, :status)");
    $sql3->bindParam(':module_id', $module_selected);
    $sql3->bindParam(':learner_id', $id);
    $sql3->bindParam(':status', $status);

    $sql3->execute();

    // Redirect to a page, for example "module_details.php" with the learner ID passed as a URL parameter
    header("Location: ../admin/profileviewing.php?id=" . $id);
    exit(); // Ensure no further code is executed after the redirect
}
?>
