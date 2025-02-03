<?php 




include("../includes/header.php");
include("teachersidebar.php");
include("teacher_navbar.php");
include("teacherdashboard.php");
if(!isset($_SESSION['userid'])){
  header("location:../login.php");
  exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Bar Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .weird-dashboard-wrapper {
            font-family: Arial, sans-serif;
            
            display: flex;
            justify-content: flex-start;
            align-items: center;
            
            margin: 0;
            padding: 0;
        }

        .weird-chart-container {
            width: 80%;
            max-width: 700px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);

        }

        .weird-chart {
            
            height: auto;
        }
    </style>
</head>
<body>
    
</body>
</html>


              
            
          
              
              </div>
            </div>
          </div>
        </div>


<?php

include("../includes/footer.php");

 ?>