<div class="container">
          <div class="page-inner" style="">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div style="display: flex;align-items: center;">
                <h3 class="fw-bold mb-3"><i class="ri-dashboard-3-line" style="font-size: 30px;margin-top:  20px"></i>Dashboard</h3>
                
              </div>
              
            </div>
            <div class="row" style="" >
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
">
                    <div class="row align-items-center">
                      <div class="col-icon" >
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                         >
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0" >
                        <div class="numbers">
                          <p class="card-category">Students</p>
                          <?php
                            try {
                                $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                // Query to count the total number of learners
                                $sql = "SELECT COUNT(*) as total_learners FROM learner";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();

                                // Fetch the result
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $totalLearners = $result['total_learners'];
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                          <h4 class="card-title"><?php echo $totalLearners; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                          <i class="fas fa-user-check"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Teachers</p>
                          <?php 
                           

                          $sqlTeachers = "SELECT COUNT(*) as total_teachers FROM teacher";
                          $stmtTeachers = $conn->prepare($sqlTeachers);
                          $stmtTeachers->execute();
                          $resultTeachers = $stmtTeachers->fetch(PDO::FETCH_ASSOC);
                          $totalTeachers = $resultTeachers['total_teachers'];

                          ?>
                          <h4 class="card-title"><?php echo $totalTeachers; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Not Assign Students</p>
                          <?php 
                           

                          $sqlnotassign = "SELECT COUNT(*) as total_notassign FROM learner WHERE status = 'notassign'";

                          $stmtnotassign = $conn->prepare($sqlnotassign);
                          $stmtnotassign->execute();
                          $resultnotassign = $stmtnotassign->fetch(PDO::FETCH_ASSOC);
                          $totalnotassign = $resultnotassign['total_notassign'];

                          ?>
                          <h4 class="card-title"><?php echo $totalnotassign; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06);
">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Inactive Students</p>
                          <?php
                      $sqlInactive = "SELECT COUNT(*) as total_inactive FROM learner WHERE status = 'inactive'";

                      $stmtInactive = $conn->prepare($sqlInactive);
                      $stmtInactive->execute();
                      $resultInactive = $stmtInactive->fetch(PDO::FETCH_ASSOC);
                      $totalInactive = $resultInactive['total_inactive'];
                        ?>
                          <h4 class="card-title"><?php echo $totalInactive; ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
// Query to get distinct years from the enrollees_date column
$sqlYears = "SELECT DISTINCT YEAR(enrollees_date) as year FROM enrollees ORDER BY year ASC";
$stmtYears = $conn->prepare($sqlYears);
$stmtYears->execute();
$years = $stmtYears->fetchAll(PDO::FETCH_ASSOC);

// Initialize arrays to hold years and counts for each year
$yearList = [];
$counts = [];

// Loop through each year retrieved from the database
foreach ($years as $yearData) {
    $year = $yearData['year'];
    $yearList[] = $year; // Store the year in $yearList array

    // Prepare the SQL query to count learners for the specific year
    $sqlCount = "SELECT COUNT(*) as total_enrollees FROM enrollees WHERE YEAR(enrollees_date) = :year";
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->execute(['year' => $year]);

    // Fetch the count result for that year
    $resultCount = $stmtCount->fetch(PDO::FETCH_ASSOC);
    $counts[] = $resultCount['total_enrollees']; // Store the count in $counts array
}

// Display the arrays to show they are real arrays


// Example display of years and counts
  
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
    <div class="weird-dashboard-wrapper">
        <div class="weird-chart-container">
            <canvas id="enrollmentChart" class="weird-chart"></canvas>
        </div>
    </div>

   <script>
    document.addEventListener("DOMContentLoaded", function() {
        var months = <?php echo json_encode($yearList); ?>;
        var counts = <?php echo json_encode($counts); ?>;

        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        const enrollmentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Number of Enrollees',
                    data: counts,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333',
                            font: {
                                size: 14,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#333',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#333',
                            font: {
                                size: 12,
                            }
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333',
                            font: {
                                size: 12,
                            }
                        },
                        grid: {
                            color: '#eaeaea'
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>


              
            
          
             