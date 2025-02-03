<?php
session_start();
include("../includes/header.php");
include("teachersidebar.php");
include("../includes/navbar.php");

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
if (isset($_GET['id'])) {
        $id = $_GET['id'];

    $sql = $conn->prepare("SELECT * FROM learner where learner_id=:id");
    $sql->bindParam(":id", $id);
    $sql->execute();

    $student = $sql->fetch(PDO::FETCH_ASSOC);

    $student_name = $student['firstname'];
    $student_lname = $student['lastname'];


    }
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
    rel="stylesheet"
/>
</head>
<body style="background-color: #fff">
	<div class="addcon">
		<div style="display: flex; align-items: center;"><a href="../admin/profileviewing.php?id=<?php echo $_GET['id']?>"><i class="ri-arrow-left-line" style="font-size: 20px;margin-right: 20px;"></i></a><h1 style="font-weight: 800;">Add Teacher</h1></div>
		
		<hr>
		<div class="form-container">
      
        <form action="addmod_process.php" method="POST">
            <div class="form-group">
                <p>First Name:</p>
               <h3><?php echo $student_name; ?></h3>
            </div>
                
            <div class="form-group">
                <p>Last Name:</p>
               <h3><?php echo $student_lname; ?></h3>
            </div>

            <input type="hidden" value="<?php echo $id;?>" name="id">

            <div class="form-group">
                <p>Select Module:</p>
                <select name="module_selected">
                    <?php 

                    $query2 = $conn->prepare("SELECT * FROM module");

                    
                    $query2->execute();

                    while($module = $query2->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <option value="<?php echo $module['module_id'] ?>"><?php echo htmlspecialchars($module['module_name']); ?></option>

                <?php } ?>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">Submit</button>
                
            </div>
        </form>
    </div>
	</div>
</body>
</html>

<style type="text/css">
	.addcon{
		width: 90%;
		margin: 100px auto;
		padding: 20px;
	}
	.form-container {
            
            
            width: 50%;
            background: #fff;
            border-radius: 8px;
        }

        .form-container h2 {
            
            font-size: 1.5em;
        }

        .form-group {
            
        }

        .form-group label {
            display: block;
            font-weight: bold;
            
        }

        /* Adjust input field sizes based on type */
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="number"] {
            width: 70%; /* Wide enough for text, email, and numbers */
        }

        .form-group select {
            width: 50%; /* Adjusted for dropdown selection */
        }

        .form-group input[type="number"] {
            width: 30%; /* Shorter width for age */
        }

        .form-group input[type="text"][name="contact_number"] {
            width: 50%; /* Moderate width for contact number */
        }

        .form-group input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-actions {
            margin-top: 20px;
        }

        .form-actions button {
            padding: 6px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .form-actions .submit-btn {
            background-color: darkblue;
            color: white;
        }

        .form-actions .reset-btn {
            background-color: gray;
            color: white;
            margin-left: 10px;
        }
</style>

<?php 

include("../includes/footer.php");

?>