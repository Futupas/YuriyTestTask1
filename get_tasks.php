<?php

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