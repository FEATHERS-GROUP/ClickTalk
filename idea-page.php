<?php

    session_start();
    require 'includes/dbh.inc.php';

    define('TITLE',"idea | ClickTalk");

    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }

    if(isset($_GET['id']))
    {
        $ideaId = $_GET['id'];
    }
    else
    {
        header("Location: index.php");
        exit();
    }

    include 'includes/HTML-head.php';
?>
    </head>
    <body>

    <?php include 'includes/navbar.php'; ?>
      <div class="container">
        <div class="row">
          <div class="col-sm-3">

              <?php include 'includes/profile-card.php'; ?>

          </div>


          <div class="col-sm-9" id="user-section">

                <?php

                    $sql = "select * from ideas, users
                            where idea_id = ?
                            and ideas.idea_by = users.idUsers";

                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        die('SQL error');
                    }
                    else
                    {
                        mysqli_stmt_bind_param($stmt, "s", $ideaId);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        $row = mysqli_fetch_assoc($result);
                    }
                ?>

              <img class="idea-cover" src="uploads/<?php echo $row['idea_img']; ?>">

              <img class="idea-author" src="uploads/<?php echo $row['userImg']; ?>">

              <div class="px-5">

                  <br><br><br>
                  <h1><?php echo ucwords($row['idea_title']) ?></h1>
                  <br><br><br>

                  <p class="text-justify"><?php echo $row['idea_content'] ?></p>

                  <div class="idea-likes pr-1 pt-5">

                      <h3>
                            <a href="includes/idea-vote.inc.php?idea=<?php echo $row['idea_id']; ?>" >
                                <i class="fa fa-thumbs-up fa-2x" aria-hidden="true"></i>
                            </a>
                            <?php echo $row['idea_votes']; ?>
                      </h3>
                      <br>
                    <!--  <p class="text-muted">Author: <?php echo ucwords($row['uidUsers']); ?></p>-->
                  </div>

              </div>



          </div>

        </div>


      </div> <!-- /container -->


<?php include 'includes/HTML-footer.php'; ?>
