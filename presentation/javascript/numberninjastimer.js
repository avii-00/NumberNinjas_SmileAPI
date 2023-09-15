var timeRemaining = 30; // Set Timer to 30 seconds
        var timerInterval;
        var lives = parseInt(localStorage.getItem('currentLives')) || 4; // Lives are initialized

        function startTimer() {
            timerInterval = setInterval(function() 
            {
                timeRemaining--; //reduce the time

                // Update timer display
                var minutes = Math.floor(timeRemaining / 60);
                var seconds = timeRemaining % 60;
                var timerDisplay = document.getElementById("timer");
                // Display the remaining time in the format "Time Remaining: MM:SS"
                timerDisplay.textContent = "Time Remaining: " + minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");

                // Display message if time is over
                if (timeRemaining == 0) 
                {
                    clearInterval(timerInterval);
                    lives--; // decrease lives

                    if (lives == 0) { // check whther player has no lives left
                        alert("Oops! Game Over!");
                        resetScoreAndLives();
                        window.location.href = "menu.php";
                    } 
                    else 
                    {
                        alert("Oops! Time's up.");
                        document.getElementById("lives").textContent = "Lives: " + lives; // update lives display
                        localStorage.setItem('currentLives', lives); // store the current number of lives in localStorage

                        setTimeout(function() 
                        {
                            document.getElementById("lives").textContent = "Lives: " + lives; // update lives display again to ensure it doesn't change when the next question loads
                            document.getElementById("numberForm").submit(); // Submit the form to load the next question
                        }, 1000);
                    }
                }
            }, 1000);
        }


        $(document).ready(function() 
        {
            startTimer();
            loadstation();
        });