<?php

include("../includes/header.php");
include("../includes/sidebar.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="addcon">
        <div style="display: flex; align-items: center;">
            <a href="instructor.php"><i class="ri-arrow-left-line" style="font-size: 30px;margin-right: 20px;color: black;"></i></a>
            <h1 style="font-weight: 800;"><i class="ri-user-add-fill"></i> Add Teacher</h1>
        </div>
        <hr>
        <div class="form-container">
            <form action="process_teacher.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_specialization">Subject Specialization:</label>
                        <input type="text" id="subject_specialization" name="subject_specialization">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" min="18" max="100">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_number">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number">
                    </div>
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" id="street" name="street">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="barangay">Barangay:</label>
                        <input type="text" id="barangay" name="barangay">
                    </div>
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="province">Province:</label>
                        <input type="text" id="province" name="province">
                    </div>
                    <div class="form-group">
                        <label for="zid_code">ZID Code:</label>
                        <input type="text" id="zid_code" name="zid_code">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Middle Name:</label>
                        <input type="text" id="middle_name" name="middle_name" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="reset" class="reset-btn">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<style>
    .addcon {
        width: 90%;
        margin: 100px auto;
        padding: 20px;
    }

    .form-container {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-group {
        width: 48%;
    }

    .form-group label {
        display: block;
        font-weight: bold;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-group {
            width: 100%;
        }

        .form-actions {
            display: flex;
            flex-direction: column;
        }

        .form-actions button {
            margin-top: 10px;
        }
    }
</style>

<?php
include("../includes/footer.php");
?>
