<div class="main-panel" style="">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="../assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
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
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="box-shadow: inset -1px -5px 5px rgba(0, 0, 0, 0.1);
"
           >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    
                  </a>
                  <ul
                    class="dropdown-menu messages-notif-box animated fadeIn"
                    aria-labelledby="messageDropdown"
                  >
                    <li>
                      <div
                        class="dropdown-title d-flex justify-content-between align-items-center"
                      >
                        Messages
                        <a href="#" class="small">Mark all as read</a>
                      </div>
                    </li>
                    <li>
                      <div class="message-notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="assets/img/jm_denis.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jimmy Denis</span>
                              <span class="block"> How are you ? </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="assets/img/chadengle.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Chad</span>
                              <span class="block"> Ok, Thanks ! </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="assets/img/mlane.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Jhon Doe</span>
                              <span class="block">
                                Ready for the meeting today...
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          <a href="#">
                            <div class="notif-img">
                              <img
                                src="assets/img/talha.jpg"
                                alt="Img Profile"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="subject">Talha</span>
                              <span class="block"> Hi, Apa Kabar ? </span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="javascript:void(0);"
                        >See all messages<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >

                  <?php 

                  $new = "new";
                  $conn = new PDO("mysql:dbname=als_database;host=localhost", "root", "");
                  $sql = "SELECT COUNT(*) AS total_rows FROM enrollees_info";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
      
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                  $sql1 = "SELECT * FROM enrollees_info where notify=:new";
                        $stmt1 = $conn->prepare($sql1);
                        $stmt1->bindParam(":new", $new);
                        $stmt1->execute();
                        $rows = $stmt1->rowCount();
      
                        $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);

                  
                  
                  
                  ?>
                    <i class="fa fa-bell"></i>
                    <?php if($rows > 0){
                      echo '<span class="notification">' . $rows . '</span>';

                    } ?>
                    
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have <?php 
                        
                        
                        
                         echo $rows;

                        
                         ?>  notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">

                        <?php 
                        
                        $sqll = $conn->prepare("SELECT * FROM enrollees_info where notify=:new");
                        $sqll->bindParam(":new", $new);

                        if($sqll->execute()){

                          while($students = $sqll->fetch(PDO::FETCH_ASSOC)){


                        

                        ?>
                          
                          <a href="enroll.php">
                            <div class="notif-icon notif-success">
                              <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                <?php echo $students['lastname']; echo $students['firstname']?>
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                          
                        <?php 
                        
                      }
                        }
                        ?>
                          
                        </div>
                      </div>
                    </li>
                    
                      <a class="see-all" href="enroll.php"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>
               
                
          

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <?php $firstletter = $_SESSION['user'];
                      $lnamefirstletter = $_SESSION['lname'];?>

                      <h2 style="background-color: blueviolet; display: flex; justify-content: center;align-items: center; border-radius: 20px; color: white"><?php echo $firstletter[0];echo $lnamefirstletter[0]; ?></h2>

                    </div>

                    <span class="profile-username">
                      <span style="font-size: 20px">Instructor</span><br>  
                      
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <i class="ri-user-fill" style="font-size: 40px"></i>
                          </div>
                          <div class="u-text">
                            <h4><?php echo $_SESSION['lname']; ?></h4>
                            <p class="text-muted"><?php echo $_SESSION['user']; ?></p>
                            
                          </div>
                        </div>
                         <hr> 
                      </li>
                      <li>
                        
                        <a class="dropdown-item" onclick="" href="../logout.php">Logout</a>
                        
                       
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
      </div>