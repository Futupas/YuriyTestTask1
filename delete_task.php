<?php

if (isset($_POST['id'])) {
    $task_id_to_delete = $_POST['id'];

    $db_host = getenv('db_host');
    $db_name = getenv('db_name');
    $db_user = getenv('db_user');
    $db_pass = getenv('db_pass');
    $db_port = getenv('db_port');
    $dbconn = pg_connect(
        "host=$db_host
    dbname=$db_name 
    user=$db_user 
    password=$db_pass 
    port=$db_port");

        
    $result = pg_query("DELETE FROM \"tasks\" WHERE \"id\"=$task_id_to_delete RETURNING *");

    $num_rows = pg_num_rows($result);
    $affected_rows = pg_affected_rows($result);
    // $fetch_row = pg_fetch_object($result);

    pg_free_result($result);
    pg_close($dbconn);


    echo json_encode((object)array(
        'ok' => ($num_rows > 0)
    ));
}

?>