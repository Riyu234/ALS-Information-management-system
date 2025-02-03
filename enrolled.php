<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALS Enrollment Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
 </head>

 <body>
    <div class="intro"><h1>ALS Enrollment Form</h1></div>
    <div class="container">
        <form action="#" method="POST">
    <!-- Page 1 -->
    <fieldset class="active">
        <legend>1. Learner's Personal Information</legend>
        
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        
        <label for="middlename">Middle Name:</label>
        <input type="text" id="middlename" name="middlename" required>
        
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" required>
    </fieldset>

    <!-- Page 2 -->
    <fieldset>
        <legend>2. Learner's Personal Information</legend>
        
        <label>Belong In Indigenous People:</label><br>
        <label for="indigenous_yes">
            <input type="radio" id="indigenous_yes" name="indigenous_people" value="yes" required>
            Yes
        </label>
        <label for="indigenous_no">
            <input type="radio" id="indigenous_no" name="indigenous_people" value="no" required>
            No
        </label><br>

        <label>Member of 4ps:</label><br>
        <label for="4ps_yes">
            <input type="radio" id="4ps_yes" name="member_of_4ps" value="yes" required>
            Yes
        </label>
        <label for="4ps_no">
            <input type="radio" id="4ps_no" name="member_of_4ps" value="no" required>
            No
        </label><br>

        <label for="civil_status">Civil Status:</label>
        <select id="civil_status" name="civil_status" required>
            <option value="Single">Single</option>
            <option value="Separated">Separated</option>
            <option value="Married">Married</option>
            <option value="Solo Parent">Solo Parent</option>
            <option value="Widowed">Widowed</option>
        </select><br>

        <label for="religion">Religion:</label>
        <input type="text" id="religion" name="religion" required><br>

        <label for="mothertongue">Mother Tongue:</label>
        <input type="text" id="mothertongue" name="mothertongue" required>
    </fieldset>

    <!-- Page 3: Address Information -->
    <fieldset>
        <legend>3. Learner's Address Information</legend>
        
        <label for="street">Street:</label>
        <input type="text" id="street" name="street" required>
        
        <label for="barangay">Barangay:</label>
        <input type="text" id="barangay" name="barangay" required>
        
        <label for="municipality">Municipality:</label>
        <input type="text" id="municipality" name="municipality" required>
        
        <label for="province">Province:</label>
        <input type="text" id="province" name="province" required>

        <label for="zipcode">Zip Code:</label>
        <input type="text" id="zipcode" name="zipcode" required>
    </fieldset>

    <!-- Page 4: Parent Information -->
    <fieldset>
        <legend>4. Learner's Parent Information</legend>
        
        <label for="father">Father's Full Name:</label>
        <input type="text" id="father" name="father" required placeholder="Lname, Fname, Mname">

        <label for="foccupation">Father's Occupation:</label>
        <input type="text" id="foccupation" name="foccupation" required>

        <label for="mother">Mother's Full Name:</label>
        <input type="text" id="mother" name="mother" required placeholder="Lname, Fname, Mname">

        <label for="moccupation">Mother's Occupation:</label>
        <input type="text" id="moccupation" name="moccupation" required>
        
        <label for="guardian">Legal Guardian's Full Name:</label>
        <input type="text" id="guardian" name="guardian" required placeholder="Lname, Fname, Mname">
    </fieldset>

    <!-- Page 5: PWD Information and Grade Level -->
    <fieldset>
        <legend>5. Learner's PWD Information and Grade Level</legend>
        
        <label for="pwd">Is the Learner PWD?</label><br>
        <label for="pyes">
            <input type="radio" id="pyes" name="is_pwd" value="yes" required>
            Yes
        </label>
        <label for="pno">
            <input type="radio" id="pno" name="is_pwd" value="no" required>
            No
        </label><br>

        <label for="specifypwd">If Yes, Please Specify:</label>
        <input type="text" name="specifypwd"><br>

        <label for="grade_level">Last Grade Level Completed:</label>
        <select id="grade_level" name="grade_level" required>
            <option value="elementary">Elementary</option>
            <option value="grade_1">Grade 1</option>
            <option value="grade_2">Grade 2</option>
            <option value="grade_3">Grade 3</option>
            <option value="grade_4">Grade 4</option>
            <option value="grade_5">Grade 5</option>
            <option value="grade_6">Grade 6</option>
            <option value="grade_7">Grade 7</option>
            <option value="grade_8">Grade 8</option>
            <option value="grade_9">Grade 9</option>
            <option value="grade_10">Grade 10</option>
            <option value="grade_11">Grade 11</option>
        </select>
    </fieldset>

    


            <div class="button-container">
                <button type="button" class="nav-button" id="prevBtn">Previous</button>
                <button type="button" class="nav-button" id="nextBtn">Next</button>
                <input type="submit" value="Submit" id="submitBtn" style="display: none;" name="btn">
            </div>
        </form>
    </div>

    <?php 

    	echo

    ?>