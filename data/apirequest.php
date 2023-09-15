
<?php

    function numberninjas() {
        $url = 'https://marcconrad.com/uob/smile/api.php?out=json';
        $data = file_get_contents($url);
        return json_decode($data, true);
      }     
?> 