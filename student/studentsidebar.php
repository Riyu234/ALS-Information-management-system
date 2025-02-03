 <!-- Sidebar --><?php   ?>
      <div class="sidebar" data-background-color="" style="background-color:#fff; ">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="" style="border-bottom: solid 1px lightgray; background-color:#fff">
            <a href="index.php" class="logo">
              <img
                src="../assets/img/kaiadmin/als-logo.png"
                alt="navbar brand"
                class="navbar-brand"
                height="60"
              /> <h4 style="color:#343a40; margin-top: 15px">LEARNER</h4>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              
              
               <li class="nav-item">
                <a href="#">
                  <i style="font-size: 30px"  class="fas fa-home"></i>
                  <p>DASHBOARD</p>
                  <span class="badge badge-secondary">1</span>
                </a>
              </li>
              
            
              <li class="nav-item">
                <a href="enrollmentform.php">
                  <i style="font-size: 30px"  class="ri-pass-pending-fill"></i>
                  <p>ENROLLMENT FORM</p>
                 
                </a>
              </li>
       
              <li style="font-size: 30px"  class="nav-item">
                <a href="attendance.php">
                 <i style="font-size: 30px"  class="ri-list-view"></i>
                  <p>ATTENDANCE</p>
                 
                </a>
              </li>

              <li class="nav-item">
                <a href="modules.php">
                 <i style="font-size: 30px" class="ri-git-repository-fill"></i>
                  <p>MODULE</p>
                 
                </a>
              </li>

              <li class="nav-item">
                <a href="notif.php">
                 <i style="font-size: 30px" class="ri-git-repository-fill"></i>
                  <p>NOTIFICATIONS</p>
               
                    <?php 
                      $unread = "unread";
                      
                      $conn = new PDO("mysql:dbname=system_als_data;host=localhost", "root", "");
                      $sqls = $conn->prepare("SELECT student_id FROM user WHERE user_id = :ids");
                      $sqls->bindParam(":ids", $_SESSION['userid']);
                      $sqls->execute();

                      $learner = $sqls->fetch(PDO::FETCH_ASSOC);

                      $learner_id = $learner['student_id'];

                      $stmtss = $conn->prepare("SELECT COUNT(*) AS total FROM learner_message_status WHERE learner_id = :learner_id AND read_status = :unread");
                      $stmtss->bindParam(':learner_id', $learner_id);
                      $stmtss->bindParam(':unread', $unread); // Corrected parameter name to match query
                      $stmtss->execute();
                      
                      // Fetch the result
                      $row = $stmtss->fetch(PDO::FETCH_ASSOC);
                      $messages = $row['total'];
                  ?>

                  <?php if ($messages > 0): ?>
                      <span class="badge badge-secondary"><?php echo $messages; ?></span>
                  <?php endif; ?>


                 
                </a>
              </li>

              
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>


      <style type="text/css">
        
        

      </style>