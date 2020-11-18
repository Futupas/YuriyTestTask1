<?php



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
port=$db_port")
        or die('Не удалось соединиться: ' . pg_last_error());

    
$result = pg_query("SELECT * FROM \"tasks\"")
or die('Ошибка запроса: ' . pg_last_error());

$num_rows = pg_num_rows($result);
$affected_rows = pg_affected_rows($result);
$fetch_all = pg_fetch_all($result);

pg_free_result($result);
pg_close($dbconn);


echo json_encode((object)array(
    'ok' => true,
    'tasks' => $fetch_all
));



exit(0);


$tasks = array();

$tasks[] = (object)(array(
    'id' => 1,
    'name' => 'Dimas Dubas',
    'adding_unix_date' => 1605257507,
    'ending_unix_date' => 2605257508,
    'task_name' => 'task 1',
    'task_description' => 'html css javascript'
));
$tasks[] = (object)(array(
    'id' => 2,
    'name' => 'Roman Parkour',
    'adding_unix_date' => 1605257509,
    'ending_unix_date' => 1605157510,
    'task_name' => 'task 2',
    'task_description' => 'learn english in 2 days'
));
$tasks[] = (object)(array(
    'id' => 3,
    'name' => 'Dmytro Drabyna',
    'adding_unix_date' => 1605257511,
    'ending_unix_date' => 1605257512,
    'task_name' => 'task 3',
    'task_description' => 'make a presentation in 10 minutes'
));

echo json_encode($tasks);

?>