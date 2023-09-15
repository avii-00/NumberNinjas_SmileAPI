document.addEventListener("DOMContentLoaded", function () {
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

    var currentLevel = parseInt(localStorage.getItem('currentLevel')) || 1; // recover current level from localStorage or set it to 1 if not found
    document.getElementById("level").textContent = "LEVEL " + currentLevel; // update displayed level

    document.getElementById("lives").textContent = "Lives: " + lives; // update lives display

    buttons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // prevent form submission behavior

            if (this.value == solution) {
                alert("Congratulations, Your Answer Is Correct!");
                // Update score if last answer was incorrect
                currentScore += 10;
                localStorage.setItem(loggedInUserName, currentScore); // Store updated score in localStorage of logged in user
                score.textContent = currentScore; // update score display

                // Check if user has reached a new level
                if (currentScore % 50 == 0 && currentScore != 300) {
                    currentLevel++; // Increment the user's level 
                    localStorage.setItem('currentLevel', currentLevel); // Store current level in localStorage
                    alert("Congratulations! You reached Level " + currentLevel);

                    // Update the displayed level
                    document.getElementById("level").textContent = "LEVEL " + currentLevel;
                }

                isAnswerCorrect = true; // mark last answer as correct

                if (currentScore == 300) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var response = this.responseText;
                            if (response == "update") {
                                window.location.href = "menu.php";
                            }
                            else if (response == "insert") {
                                window.location.href = "menu.php";
                            }
                        }
                    };

                    xmlhttp.open("POST", "scorephp.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("currentScore=" + currentScore);

                    resetScoreAndLives();
                    window.location.href = "/presentation/html/won.html"; // redirect to won.html if currentScore is 300
                }
                else if (currentScore != 300) {
                    window.location.href = "numberninjas.php";
                }

                localStorage.setItem('currentLevel', currentLevel);

            }
            else {
                alert("Oops! Answer Is Incorrect.");
                if (!isAnswerCorrect) { // Decrease lives if last answer was incorrect
                    lives--; // decrease lives by 1

                    if (lives == 0) { // check whether player has no lives left
                        alert("Oops! Game Over!");

                        // Send AJAX request to PHP file
                        var xmlhttp = new XMLHttpRequest(); // Creates new XMLHttpRequest, used to send HTTP requests to the server
                        xmlhttp.onreadystatechange = function () // Sets a callback function to handle the response, when state XMLHttpRequest object changes
                        // Callback function will execute when readyState property of XMLHttpRequest object changes
                        {
                            if (this.readyState == 4 && this.status == 200) // If readyState=4 that means request is complete, if status=200 that means request is successfull
                            {
                                var response = this.responseText; // ResponseText property of XMLHttpRequest object is assigned to variable response
                                if (response == "update") {
                                    window.location.href = "/application/menu.php";
                                }
                                else if (response == "insert") {
                                    window.location.href = "/application/menu.php";
                                }
                            }
                        };

                        xmlhttp.open("POST", "/application/scorephp.php", true); // Opens a new HTTP POST request
                        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // Sets HTTP header for the request
                        xmlhttp.send("currentScore=" + currentScore); // Sends HTTP request with data "currentScore" and its value
                        xmlhttp.send("currentScore=" + currentScore);

                        // Executes immediately after HTTP request is sent
                        resetScoreAndLives();
                        window.location.href = "/application/menu.php";
                    }
                    else {
                        document.getElementById("lives").textContent = "Lives: " + lives; // update lives display
                        localStorage.setItem('currentLives', lives); // store the current number of lives in localStorage
                    }
                }

                isAnswerCorrect = false; // mark the last answer incorrect
            }
        });
    });


    function resetScoreAndLives() {
        currentScore = 0;
        localStorage.removeItem(loggedInUserName); // remove score of logged in user from localStorage
        lives = initialLives; // reset lives 
        localStorage.setItem('currentLives', lives); // store current number of lives in localStorage
        localStorage.removeItem('currentLevel'); // remove current level from localStorage
        document.getElementById("lives").textContent = "Lives: " + lives; // update lives
    }

    exitButton.addEventListener("click", function (event) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                if (response == "update") {
                    window.location.href = "menu.php";
                }
                else if (response == "insert") {
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
    document.querySelector("#logoutButton").addEventListener("click", function (event) {
        event.preventDefault(); //prevent default behavior of button click
        resetScoreAndLives();
        window.location.href = "menu.php"; // redirect to menu page
    });

});