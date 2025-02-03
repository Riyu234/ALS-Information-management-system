<?php 
session_start();
if(isset($_SESSION['login'])){
	header("location:admin/index.php");
	exit();
} else if(isset($_SESSION['studentlogin'])){
	header("location:student/studenthomepage.php");
	exit();
} else if(isset($_SESSION['teacherlogin'])){
	header("location:teacher/teacherhomepage.php");
	exit();
}

$connect = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");


if(isset($_POST['btn'])){
	$userinput = $_POST['user'];
	$passinput = sha1($_POST['pass']);

	

	if(empty($userinput)){
		echo "<script>alert('Please Enter Username')</script>";
	} elseif(empty($passinput)){
		echo "<script>alert('Please Enter Password')</script>";
	} else {
		$sql = $connect->prepare("SELECT * FROM user WHERE username=:userinput");
		$sql->bindParam(":userinput", $userinput);
		$sql->execute();

		if($sql->rowCount() > 0){
			$row = $sql->fetch(PDO::FETCH_ASSOC);
			$password = $row['password'];
			if($password == $passinput){
				$role = $row['role'];
				$_SESSION['role'] = $role;
				if($role == "admin"){
					$_SESSION['userid'] = $row['user_id'];
					$admin_id = $row['admin_id'];
					$sql2 = $connect->prepare("SELECT * FROM admin where admin_id=:ids");
					$sql2->bindParam(":ids", $admin_id);
					$sql2->execute();
					$row1 = $sql2->fetch(PDO::FETCH_ASSOC);
					$_SESSION['user'] = $row1['firstname'];
					$_SESSION['lname'] = $row1['lastname'];


					echo "<script>
					alert('Login Successfully');
					setTimeout(function() {
						window.location.href = 'admin/index.php';
						}, 500);
					</script>";
					exit();
				} elseif($role == "student"){
					$_SESSION['userid'] = $row['user_id'];
					$student_id = $row['student_id'];
					$sql2 = $connect->prepare("SELECT * FROM learner where learner_id=:ids");
					$sql2->bindParam(":ids", $student_id);
					$sql2->execute();
					$row1 = $sql2->fetch(PDO::FETCH_ASSOC);
					$_SESSION['user'] = $row1['firstname'];
					$_SESSION['lname'] = $row1['lastname'];

					echo "<script>
					alert('Login Successfully');
					setTimeout(function() {
						window.location.href = 'student/studenthomepage.php';
						}, 500);
					</script>";
					exit();
				} elseif($role == "teacher"){
					$_SESSION['userid'] = $row['user_id'];
					$teacher_id = $row['teacher_id'];
					$sql2 = $connect->prepare("SELECT * FROM teacher where teacher_id=:ids");
					$sql2->bindParam(":ids", $teacher_id);
					$sql2->execute();
					$row1 = $sql2->fetch(PDO::FETCH_ASSOC);
					$_SESSION['user'] = $row1['first_name'];
					$_SESSION['lname'] = $row1['last_name'];
					

					echo "<script>
					alert('Login Successfully');
					setTimeout(function() {
						window.location.href = 'teacher/teacherhomepage.php';
						}, 500);
					</script>";
					exit();
				}
			} else{
				echo "<script>alert('Incorrect Password')</script>";
			}

		} else{
			echo "<script>alert('Username Not Found')</script>";
		}

	}
	
	
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
<body>
	<div style="display: flex;width: 100%; height: 100vh;" >
			<div style="background-color: green;width: 34%; " class="lside">
				<h2 style="color: white;margin-top: auto;">ALTERNATIVE LEARNING SYSTEM(ALS) BINALBAGAN</h2>
				<p>Welcome to our school Portal</p>
				<p style="margin-top: auto;margin-bottom: 20px;color: white;font-size: 15px">Copy right @2024 Allrights reserved!</p>
			</div>

			<div style="width: 68%;color: black;display: flex;align-items: center;justify-content: center; flex-direction: column;gap:10px" class="formlog">
				<img src="assets/img/orig-logo.png" style="height: 180px">
				<h1>ALS Binalbagan Login</h1>
				<p style="color: gray" >Welcome,Please Login your account</p>
				<form style="display:flex;flex-direction: column;gap:20px;margin-top: 20px" method="post">	
			
				<input type="text" name="user" placeholder="Username">
				<input type="password" name="pass" placeholder="Password">
				<button class="ey" style="float: right;" name="btn"><i class="ri-contract-right-line"></i> Sign Up</button>
				</form>
			</div>
	</div>
</body>
</html>

<style type="text/css">

	
    .formlog input {
        font-size: 18px;
        padding-left: 10px;
        width: 380px;
        height: 40px;
        margin-top: 10px;
        border: none;
        background-color: lightgray;
    }

    * {
        margin: 0;
        font-family: "Roboto", sans-serif;
    }

    .loging {
        display: flex;
        justify-content: space-between;
        width: 100%;
        height: 100vh;
    }

    .lside {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 100, 0.5)),
            url(assets/img/Capture.png);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    .lside h2 {
        font-size: 25px;
        margin-left: 20px;
    }

    .lside p {
        margin-left: 20px;
        font-size: 20px;
        color: gray;
        margin-top: 10px;
    }

    input {
        width: 100px;
    }

    .logincon {
        width: 70%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logincontainer {
        display: flex;
        justify-content: center;
        flex-direction: column;
    }

    .logincontainer input {
        height: 40px;
        background-color: pearl;
        border: none;
        border-radius: 10px;
        padding-left: 10px;
        width: 370px;
        font-size: 18px;
        background-color: lightgray;
    }

    .logincontainer p {
        margin-top: 20px;
        font-size: 20px;
        margin-bottom: 10px;
    }

    .logincon {
        display: flex;
        flex-direction: column;
        box-shadow: 1px 1px 1px 1px;
    }

    .logincon img {
        height: 130px;
    }

    button {
        height: 40px;
        background-color: #87a2b5;
        width: 100px;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0069d9;
    }

    .logincontainer input:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5), 0 0 10px rgba(0, 123, 255, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .lside {
            width: 50%;
            height: 50vh;
            align-items: center;
            justify-content: center;
            text-align: center;
            display: none;

        }

        .lside h2 {
            font-size: 20px;
            margin-left: 0;
        }

        .lside p {
            margin-left: 0;
            font-size: 16px;
        }

        .formlog {
            width: 500px;
            padding: 20px;
            background-color: pink;
        }

        .formlog input {
            width: 100%;
            background-color: green;
            max-width: 320px;
        }

        button {
            width: 100%;
        }

        img {
            height: 120px;
        }
    }

    @media (max-width: 540px) {

    	.lside{
    		display: none;
    	}
        .lside h2 {
            font-size: 18px;
        }

        .lside p {
            font-size: 14px;
        }

        .formlog input {
            font-size: 16px;
        }

        button {
            font-size: 14px;
        }

        img {
            height: 100px;
        }
    }
</style>

</style>