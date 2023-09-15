
<?php require_once "../../application/ninjasdb.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../nodefiles/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/numberninjas.css">


    <title>Number Ninjas</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../javascript/numberninjastimer.js"></script>

</head>

<body>

    <audio id="bgmusic" autoplay loop volume="0.1">
        <source src="../../public/sounds/game-setting-fantasy-141319.mp3" type="audio/mpeg">
    </audio>


    <section class="screen text-center">
        <form action="" method="POST" id="numberForm">
            <div class="row outerscreen">
                <div class="row base">
                    <div class="col-md-6 col-lg-6 inner-area">
                        <div class="p-3">
                            <div class="levelscreen">
                                <div class="question">


                                    <?php
                                    // Calling Number Ninjas function
                                    $response = numberninjas();

                                    // Get question and solution values through API response
                                    $question = $response['question'];
                                    $solution = $response['solution'];

                                    ?>

                                    <img src="<?php echo $question; ?>" className="img-thumbnail" alt="question" />


                                    <?php
                                    if (isset($_POST['buttonValue'])) 
                                    {
                                        $buttonValue = $_POST['buttonValue'];

                                        if ($buttonValue == $solution) 
                                        {
                                            // Calling Number Ninjas function again in order to get new question and solution
                                            $response = numberninjas();
                                            $question = $response['question'];
                                            $solution = $response['solution'];

                                            echo '<script>alert("Done");</script>';
                                        } 
                                        else 
                                        {
                                            echo '<script>alert("Wrong");</script>';
                                            die();
                                        }
                                    }
                                    ?>

                                </div>

                                <br><br><br>

                                <div class="btn-answers">
                                    <div class="row">

                                        <?php for ($i = 0; $i <= 9; $i++) { ?>
                                            <div class="col-md-2 col-lg-2 mx-1">
                                                <div class="p-2">
                                                    <button class="btn" name="buttonValue" value="<?php echo $i; ?>"><?php echo $i; ?></button>
                                                </div>
                                            </div>
                                        <?php
                                        } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-lg-3 welcome">
                        <div class="p-3 detail-area">
                            <span id="username">
                                <?php echo "Welcome, " . $loggedInUserName . "!"; ?> </span>
                            <h1>Number Ninjas</h1>
                            <br><br><br>

                            <h1 id="level">LEVEL 1</h1>
                            <br>

                            <div id="main-area">
                                <p>Score: <span id="score">0</span></p>
                                <p><span id="timer">Time Remaining: 00:00</span></p>
                                <p><span id="lives">Lives: 4</span></p>
                            </div>

                            <br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div>

            <form method="post">
                <button type="submit" name="logout" id="exit-btn">Exit</button>
            </form>

        </div>
    </section>

    <script>
        document.getElementById("exit-btn").addEventListener("click", function() 
        {
            window.location.href = "menu.php";
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() 
        {
            var solution = '<?php echo $solution; ?>';
            var buttons = document.querySelectorAll("#numberForm button");
            var form = document.querySelector("#numberForm");
            var score = document.querySelector("#score");
            var exitButton = document.getElementById("exit-btn");

            // recover current logged in username and store in a variable
            var loggedInUserName = '<?php echo $loggedInUserName; ?>';

            // recover score for logged in user. Set it to 0 if not found
            var currentScore = parseInt(localStorage.getItem(loggedInUserName)) || 0;
            score.textContent = currentScore;

            var initialLives = 4; // Initial number of lives which is displayed at the first
            var lives = parseInt(localStorage.getItem('currentLives')) || initialLives; // Current lives
            var isAnswerCorrect = false; // Track whether last answer was correct or not

            var currentLevel = parseInt(localStorage.getItem('currentLevel')) || 1; // recover current level from localStorage or if not found set to 1
            document.getElementById("level").textContent = "LEVEL " + currentLevel; // update displayed level

            document.getElementById("lives").textContent = "Lives: " + lives; // update lives display

            function resetScoreAndLives() 
            {
                currentScore = 0;
                localStorage.removeItem(loggedInUserName); // remove score of logged in user from localStorage
                lives = initialLives; // reset lives 
                localStorage.setItem('currentLives', lives); // store current number of lives in localStorage
                localStorage.removeItem('currentLevel'); // remove current level from localStorage
                document.getElementById("lives").textContent = "Lives: " + lives; // update lives
                currentLevel=1;
                
            }

            buttons.forEach(function(button) 
            {
                button.addEventListener("click", function(event) 
                {
                    event.preventDefault(); // prevent form submission behavior

                    if (this.value == solution) 
                    {
                        alert("Congratulations, Your Answer Is Correct!");
                        // Update score if last answer was incorrect

                        currentScore += 10;
                        localStorage.setItem(loggedInUserName, currentScore); // Store updated score in localStorage of logged in user
                        score.textContent = currentScore; // update score display

                        // Check if user has reached a new level
                        if (currentScore % 50 == 0 && currentScore != 300) 
                        {
                            currentLevel++; // Increment level 
                            localStorage.setItem('currentLevel', currentLevel); // Store current level in localStorage
                            alert("Congratulations! You reached Level " + currentLevel);

                            // Update the displayed level
                            document.getElementById("level").textContent = "LEVEL " + currentLevel;
                        }

                        isAnswerCorrect = true; // mark last answer as correct

                        if (currentScore == 300) 
                        {
                            // Send AJAX request to PHP file
                            var xmlhttp = new XMLHttpRequest(); // Creates new XMLHttpRequest, used to send HTTP requests to the server
                            // Sets a callback function to handle the response, when state XMLHttpRequest object changes
                            xmlhttp.onreadystatechange = function() 
                            // Callback function will execute when readyState property of XMLHttpRequest object changes
                            {
                                // If readyState=4 that means request is complete, if status=200 that means request is successfull
                                if (this.readyState == 4 && this.status == 200) 
                                {
                                    // ResponseText property of XMLHttpRequest object is assigned to variable response
                                    var response = this.responseText; 
                                    if (response == "update") 
                                    {
                                        window.location.href = "menu.php";
                                    } 
                                    else if (response == "insert") 
                                    {
                                        window.location.href = "menu.php";
                                    }
                                }
                            };

                            xmlhttp.open("POST", "scorephp.php", true); // Opens a new HTTP POST request
                            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Sets HTTP header for the request
                            xmlhttp.send("currentScore=" + currentScore); // Sends HTTP request with data "currentScore" and its value

                            resetScoreAndLives();
                            window.location.href = "won.html"; // redirect to won page if currentScore is 300
                        } 
                        else 
                        {
                            window.location.href = "numberninjas.php";
                        }

                        localStorage.setItem('currentLevel', currentLevel);

                    } 
                    else 
                    {
                        alert("Oops! Answer Is Incorrect.");
                        if (!isAnswerCorrect)  // Decrease lives if last answer is incorrect
                        { 
                            lives--; // decrease lives by 1

                            if (lives == 0) { // check whether player has no lives left
                                alert("Oops! Game Over!");

                                // Send AJAX request to PHP file
                                var xmlhttp = new XMLHttpRequest(); 
                                xmlhttp.onreadystatechange = function() 
                                
                                {
                                    if (this.readyState == 4 && this.status == 200) 
                                    {
                                        var response = this.responseText; 
                                        if (response == "update") 
                                        {
                                            window.location.href = "menu.php";
                                        } 
                                        else if (response == "insert") 
                                        {
                                            window.location.href = "menu.php";
                                        }
                                    }
                                };

                                xmlhttp.open("POST", "scorephp.php", true); 
                                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
                                xmlhttp.send("currentScore=" + currentScore); 
                                 

                                // Executes immediately after HTTP request is sent
                                resetScoreAndLives();
                                window.location.href = "menu.php";
                            } 
                            else 
                            {
                                document.getElementById("lives").textContent = "Lives: " + lives; // update lives and display
                                localStorage.setItem('currentLives', lives); // Store current number of lives in localStorage
                            }
                        }

                        isAnswerCorrect = false; // mark the last answer incorrect
                    }
                });
            });


            

            exitButton.addEventListener("click", function(event) 
            {
                var xmlhttp = new XMLHttpRequest(); 
                xmlhttp.onreadystatechange = function() 
                 
                {
                    if (this.readyState == 4 && this.status == 200) 
                    {
                        var response = this.responseText; 
                        if (response == "update") 
                        {
                            window.location.href = "menu.php";
                        } 
                        else if (response == "insert") 
                        {
                            window.location.href = "menu.php";
                        }
                    }
                };

                xmlhttp.open("POST", "scorephp.php", true); 
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
                xmlhttp.send("currentScore=" + currentScore); 

                resetScoreAndLives();
                window.location.href = "menu.php";
            });

            //clear existing score and redirect to login page when exits
            document.querySelector("#logoutButton").addEventListener("click", function(event) 
            {
                event.preventDefault(); //prevent default behavior of button click
                resetScoreAndLives();
                window.location.href = "menu.php"; // redirect to menu page
            });

        });
    </script>


</body>

<!-- Include jQuery CDN link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" crossorigin="anonymous"></script>

</html>