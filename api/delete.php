<?php

$data = json_decode(file_get_contents("php://input"), true);

$tasks = json_decode(file_get_contents("../tasks.json"), true);

$tasks = array_filter($tasks, function($task) use ($data){
    return $task["id"] != $data["id"];
});

file_put_contents("../tasks.json", json_encode(array_values($tasks), JSON_PRETTY_PRINT));