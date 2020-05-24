<?php

    session_start();
    include_once 'includes/dbh.inc.php';
    define('TITLE',"Dashboard| Clicktalk");

    $companyName = "Clicktalk";

    function strip_bad_chars( $input ){
        $output = preg_replace( "/[^a-zA-Z0-9_-]/", "", $input);
        return $output;
    }

    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }

    include 'includes/HTML-head.php';
?>
        <link href="css/list-page.css" rel="stylesheet">
        <link href="css/loader.css" rel="stylesheet">
    </head>

    <body onload="pageLoad()">

        <div id="loader-wrapper">
        <img src='img/500.png' id='loader-logo'>
            <div class="loader">
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__bar"></div>
                <div class="loader__ball"></div>
            </div>
        </div>

        <div id="content" style="display: none">

            <?php include 'includes/navbar.php'; ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3" >

                        <?php include 'includes/profile-card.php'; ?>

                    </div>

                    <div class="col-sm-7" >

                        <div class="text-center p-3">
                            <h2 class='text-muted'>DASHBOARD</h2>
                            <br>
                        </div>


                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="idea-tab" data-toggle="tab" href="#idea" role="tab"
                                 aria-controls="idea" aria-selected="true">Announcements</a>
                            </li>
                        </ul>

                        <br>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="idea" role="idea" aria-labelledby="idea-tab">

                                <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
                                  <div class="lh-100">
                                    <h1 class="mb-0 text-white lh-100">Latest Announcements</h1>
                                  </div>
                                </div>

                                <div class="row mb-2">

                                    <?php
                                        $sql = "select * from ideas, users
                                                where ideas.idea_by = users.idUsers
                                                order by idea_id desc, idea_votes asc
                                                LIMIT 6";
                                        $stmt = mysqli_stmt_init($conn);

                                        if (!mysqli_stmt_prepare($stmt, $sql))
                                        {
                                            die('SQL error');
                                        }
                                        else
                                        {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);


                                            while ($row = mysqli_fetch_assoc($result))
                                            {
                                                echo '<div class="col-md-6">
                                                        <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                                                          <div class="card-body d-flex flex-column align-items-start">
                                                            <strong class="d-inline-block mb-2 text-primary">
                                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i> '.$row['idea_votes'].'
                                                            </strong>
                                                            <h6 class="mb-0">
                                                              <a class="text-dark" href="idea-page.php?id='.$row['idea_id'].'">'.substr($row['idea_title'],0,10).'...</a>
                                                            </h6>
                                                            <small class="mb-1 text-muted">'.date("F jS, Y", strtotime($row['idea_date'])).'</small>
                                                            <small class="card-text mb-auto">'.substr($row['idea_content'],0,40).'...</small>
                                                            <a href="idea-page.php?id='.$row['idea_id'].'">Continue reading</a>
                                                          </div>
                                                          <a href="idea-page.php?id='.$row['idea_id'].'">
                                                          <img class="card-img-right flex-auto d-none d-lg-block ideaindex-cover"
                                                                src="uploads/'.$row['idea_img'].'" alt="Card image cap">
                                                                    </a>
                                                        </div>
                                                      </div>';
                                            }
                                        }
                                    ?>


                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-2">

                        <div class="text-center p-3 mt-5">
                            <a href="team.php" target="_blank">
                                <i class="creater-icon fa fa-table fa-5x" aria-hidden="true"></i>
                            </a>
                        </div>

                        <a href="forum.php" class="btn btn-primary btn-lg btn-block">Admin</a>
                        <a href="hub.php" class="btn btn-danger btn-lg btn-block">The Box</a>
                        <a href="forum.php" class="btn btn-secondary btn-lg btn-block">Composer</a>

                    </div>
                </div>
            </div>
        </div>



<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js" ></script>

        <script>
            var myVar;

            function pageLoad() {
              myVar = setTimeout(showPage, 4000);
            }

            function showPage() {
              document.getElementById("loader-wrapper").style.display = "none";
              document.getElementById("content").style.display = "block";
            }
        </script>

    </body>
</html>
