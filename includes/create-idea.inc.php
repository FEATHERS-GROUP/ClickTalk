<?php

if (isset($_POST['create-idea-submit']))
{

    require 'dbh.inc.php';
    session_start();

    $title = $_POST['btitle'];
    $content  = $_POST['bcontent'];

    if (empty($title) || empty($content))
    {
        header("Location: ../create-idea.php?error=emptyfields");
        exit();
    }
    else
    {
        // checking if a user already exists with the given username
        $sql = "select idea_title from ideas where idea_title=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../create-idea.php?error=sqlerror1");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $title);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0)
            {
                header("Location: ../create-idea.php?error=titletaken");
                exit();
            }
            else
            {
                $id = $_SESSION['idea_id'];

                $FileNameNew = 'idea-cover.png';

                require 'upload.inc.php';

                $sql = "insert into ideas(idea_title, idea_by, idea_date, idea_content, idea_img) "
                        . "values (?,?,now(),?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../create-idea.php?error=sqlerror2");
                    exit();
                }
                else
                {


                    mysqli_stmt_bind_param($stmt, "ssss", $title, $_SESSION['userId'], $content, $FileNameNew);
                    //echo $title . ' ' . $_SESSION['userId'] . ' ' . $content;
                    //exit();
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    header("Location: ../create-idea.php");
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

else
{
    header("Location: ../create-idea.php");
    exit();
}
