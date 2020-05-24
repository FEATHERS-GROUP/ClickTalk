<?php

    session_start();
    define('TITLE',"Create idea | clicktalk");

    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit();
    }

    include 'includes/HTML-head.php';
?>
        <link rel="stylesheet" type="text/css" href="css/comp-creation.css">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>


    <div class="bg-contact2" style="background-image: url('img/black-bg.jpg');">
		<div class="container-contact2">



			<div class="wrap-contact2">
                            <form class="contact2-form" action="includes/create-idea.inc.php" method='post'
                                  enctype="multipart/form-data">

                                        <label class="btn btn-primary position-absolute mt-2 ml-2">
                                            Change Cover Image <input type="file" id="imgInp" name='dp' hidden>
                                        </label>
                                        <img class="cover-img " id="blah"  src="#">

                                        <br><br><br>
					<span class="contact2-form-title">
						Create a idea
					</span>

                                        <span class="text-center">
                                        <?php
                                            if(isset($_GET['error']))
                                            {
                                                if($_GET['error'] == 'emptyfields')
                                                {
                                                    echo '<h5 class="text-danger">*Fill In All The Fields</h5>';
                                                }
                                                else if ($_GET['error'] == 'catnametaken')
                                                {
                                                    echo '<h5 class="text-danger">*A category with the given name already exists</h5>';
                                                }
                                                else if ($_GET['error'] == 'sqlerror')
                                                {
                                                    echo '<h5 class="text-danger">*Website Error: Contact admin to have the issue fixed</h5>';
                                                }
                                            }
                                            else if (isset($_GET['catcreation']) == 'success')
                                            {
                                                echo '<h5 class="text-success">*Category successfully created</h5>';
                                            }
                                        ?>
                                        </span>

					<div class="wrap-input2 validate-input" data-validate="Name is required">
						<input class="input2" type="text" id="title" name="btitle">
						<span class="focus-input2" data-placeholder="idea Title"></span>
					</div>

					<div class="wrap-input2 validate-input" data-validate = "Description is required">
                                            <textarea class="input2" id="content" name="bcontent"rows="20"></textarea>
						<span class="focus-input2" data-placeholder="idea Content"></span>
					</div>

					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn">
							<div class="contact2-form-bgbtn"></div>
                                                        <button class="contact2-form-btn" type="submit" name="create-idea-submit">
								Create idea
                                                        </button>

						</div>
					</div>
                                    <div class="text-center">
                                        <br><br><a class="btn btn-light btn-lg btn-block" href="ideas.php">
                                            View All ideas</a>
                                    </div>
				</form>
			</div>
		</div>
	</div>





	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
        <script src="js/creation-main.js"></script>


                            <script>
                                var dp = 'img/idea-cover.png';

                                $('#blah').attr('src', dp);

                                function readURL(input) {

                                    if (input.files && input.files[0]) {
                                      var reader = new FileReader();

                                      reader.onload = function(e) {
                                        $('#blah').attr('src', e.target.result);

                                      }

                                      reader.readAsDataURL(input.files[0]);
                                    }
                                  }

                                  $("#imgInp").change(function() {
                                    readURL(this);
                                  });


                            </script>

    </body>
</html>
