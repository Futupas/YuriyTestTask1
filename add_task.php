<?php


// validation
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['endingDate']) || !isset($_POST['taskName']) || !isset($_POST['taskDescription'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Fill all fields')));
    die();
}
if ($_POST['name'] == '' || is_null($_POST['name'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Name mustn\' be empty')));
    die();
}
if (strlen($_POST['name'] > 128)) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Name is to big')));
    die();
}
if ($_POST['email'] == '' || is_null($_POST['email'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Email mustn\' be empty')));
    die();
}
if (strlen($_POST['email'] > 128)) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Email is to big')));
    die();
}
$email_splitted = explode('@', $_POST['email']);
if (count($email_splitted) != 2) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Email is not correct')));
    die();
}
if (strpos($email_splitted[1], '.') === false) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Email is not correct')));
    die();
}
if ($_POST['endingDate'] == '' || is_null($_POST['endingDate'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Ending date mustn\' be empty')));
    die();
}
$date_unix = 0;
try{
    $date = new DateTime($_POST['endingDate'], new DateTimeZone('Europe/Kiev'));
    $date_unix = $date->getTimestamp();
} catch (Exception $ex) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Ending date is not correct')));
    die();
}

if ($_POST['taskName'] == '' || is_null($_POST['taskName'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Task name mustn\' be empty')));
    die();
}
if ($_POST['taskDescription'] == '' || is_null($_POST['taskDescription'])) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Task description mustn\' be empty')));
    die();
}
if (strlen($_POST['taskDescription'] > 1000)) {
    echo json_encode((object)(array('ok' => false, 'message' => 'Task description mustn\' be bigger than 1000 chars')));
    die();
}

// /validation

$name = $_POST['name'];
$email = $_POST['email'];
// $date_unix;
$task_name = $_POST['taskName'];
$task_description = $_POST['taskDescription'];





//



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
        // or die('Не удалось соединиться: ' . pg_last_error());

    
$result = pg_query("INSERT INTO \"tasks\" (\"name\", \"email\", \"ending_unix_date\", \"task_name\", \"task_description\") VALUES ('$name', '$email', $date_unix, '$task_name', '$task_description') RETURNING *");
// or die('Ошибка запроса: ' . pg_last_error());

$num_rows = pg_num_rows($result);
$affected_rows = pg_affected_rows($result);
$fetch_row = pg_fetch_object($result);

pg_free_result($result);
pg_close($dbconn);


echo json_encode((object)array(
    'ok' => true,
    'added_task' => $fetch_row
));



// echo json_encode((object)(array('ok' => true, 'message' => "name: $name, email: $email, date: $date_unix, taskName: $task_name, description: $task_description")));

?>