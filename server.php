<?php
    // $body = $_POST['name'];
    // echo $body;

    $date = new DateTime('31.0h.2002', new DateTimeZone('Europe/Kiev'));
    echo 'America/New_York: '.$date->getTimestamp().'<br />'."\r\n";

?>
