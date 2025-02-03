<?php

$conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");

if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sqlls = $conn->prepare("SELECT * FROM learner where learner_id=:id");
        $sqlls->bindParam(":id", $id);
        $sqlls->execute();

        $rows = $sqlls->fetch(PDO::FETCH_ASSOC);

        $status = $rows['status'];
        $active = "active";
        $inactive = "inactive";

        if($status == "active"){
        	$sql2 = $conn->prepare("UPDATE learner set status= :newstats where learner_id=:ids");
        	$sql2->bindParam(":ids", $id);
        	$sql2->bindParam(":newstats", $inactive);
        	$sql2->execute();


        	header("Location: profileviewing.php?id=" . $id); // Appending the ID to the URL
    exit();

        } else{
        	$sql2 = $conn->prepare("UPDATE learner set status= :newstats where learner_id=:ids");
        	$sql2->bindParam(":ids", $id);
        	$sql2->bindParam(":newstats", $active);
        	$sql2->execute();

        	header("Location: profileviewing.php?id=" . $id); // Appending the ID to the URL
    exit();
        }
        







    }

 ?>