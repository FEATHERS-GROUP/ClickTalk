
<?php

    session_start();
    require 'includes/dbh.inc.php';

    define('TITLE',"Permissions | clicktalk");

    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }

    include 'includes/HTML-head.php';

?>

        <link rel="stylesheet" type="text/css" href="css/list-page.css">
    </head>

    <body style="background: #f1f1f1">

        <?php include 'includes/navbar.php'; ?>

        <main role="main" class="container">

      <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm">
          <img class="mr-3" src="img/200.png" alt="" width="48" height="48">
        <div class="lh-100">
          <h1 class="mb-0 text-white lh-100">Permissions</h1>
          <small>The clicktalk Hub</small>
        </div>
      </div>

      <div class="row mb-2">

                <?php
                    $sql = "select * from ideas, users
                            where ideas.idea_by = users.idUsers";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $userid);
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
                                        <h3 class="mb-0">
                                          <a class="text-dark" href="idea-page.php?id='.$row['idea_id'].'">'.substr($row['idea_title'],0,10).'...</a>
                                        </h3>
                                        <div class="mb-1 text-muted">'.date("F jS, Y", strtotime($row['idea_date'])).'</div>
                                        <p class="card-text mb-auto">'.substr($row['idea_content'],0,70).'...</p>
                                        <a href="idea-page.php?id='.$row['idea_id'].'">Continue reading</a>
                                      </div>
                                      <img class="card-img-right flex-auto d-none d-lg-block idealist-cover"
                                            src="uploads/'.$row['idea_img'].'" alt="Card image cap">
                                    </div>
                                  </div>';
                        }
                    }
                ?>


      </div>

    </main>

        <?php include 'includes/footer.php'; ?>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    </body>
</html>
