<?php

$con = mysqli_connect("localhost", "root", "", "game");
$query = "SELECT * FROM score ORDER BY scores DESC LIMIT 5";
$result = mysqli_query($con, $query);

?>


<?php
while ($player = mysqli_fetch_array($result)) { ?>

    <table>

        <tr>
            <td>
                <span class="username"><?php echo $player['username']; ?></span>
                <span class="scores"><?php echo $player['scores']; ?></span>
            </td>
        </tr>
    </table>


<?php } ?>