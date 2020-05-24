<?php

session_start();

if (isset($_GET['idea']) && isset($_SESSION['userId']))
{
        require 'dbh.inc.php';

        $idea = $_GET['idea'];

        $sql = "select * from ideavotes
                where voteidea = ?
                and voteBy = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../idea-page.php?id=".$idea."&error=sqlerror1");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ss", $idea, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0)
            {
                $sql = "delete from ideavotes
                        where voteidea = ?
                        and voteBy = ?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../idea-page.php?id=".$idea."&error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ss", $idea, $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../idea-page.php?id=".$idea);
                    exit();
                }
            }
            else
            {
                $sql = "insert into ideavotes (voteidea, voteBy, voteDate, vote)
                        values (?,?,now(),1)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("Location: ../idea-page.php?id=".$idea."&error=sqlerror");
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "ss", $idea, $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../idea-page.php?id=".$idea);
                    exit();
                }
            }
        }
}

else
{
    header("Location: ../idea-page.php?id=".$idea."&error");
    exit();
}
