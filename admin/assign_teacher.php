<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the teacher_id from the form
    $teacher_id = $_POST['teacher_id'];
    
    // Check if at least one learner is selected
    if (isset($_POST['learner_id']) && !empty($teacher_id)) {
        // Get the selected learner IDs
        $learner_ids = $_POST['learner_id'];
        
        try {
            $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the query to insert into class_facilitator table
            $sqlInsert = "INSERT INTO class_facilitator (teacher_id, learner_id) VALUES (:teacher_id, :learner_id)";
            $stmtInsert = $conn->prepare($sqlInsert);
            
            // Begin transaction to ensure both insert and update are done together
            $conn->beginTransaction();

            // Loop through the selected learners and insert them into the database
            foreach ($learner_ids as $learner_id) {
                // Insert into class_facilitator
                $stmtInsert->execute([
                    ':teacher_id' => $teacher_id,
                    ':learner_id' => $learner_id
                ]);

                // Update learner status to 'active'
                $sqlUpdate = "UPDATE learner 
              SET status = 'active', teacher_id = :teacher_id
              WHERE learner_id = :learner_id";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':learner_id' => $learner_id,
                    ':teacher_id' => $teacher_id // Set the teacher_id for the learner
                ]);

            }

            // Commit the transaction
            $conn->commit();

            echo "Teacher assigned to the selected learners successfully and their status is updated to active.";
        } catch (PDOException $e) {
            // Rollback the transaction in case of error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please select a teacher and at least one learner.";
    }
}
?>
