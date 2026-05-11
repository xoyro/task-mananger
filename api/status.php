<?php

$data = json_decode(file_get_contents("php://input"), true);

$tasks = json_decode(file_get_contents("../tasks.json"), true);

foreach($tasks as &$task){

    if($task["id"] == $data["id"]){

        if($task["status"] == "pending"){
            $task["status"] = "done";
        }else{
            $task["status"] = "pending";
        }
    }
}

file_put_contents("../tasks.json", json_encode($tasks, JSON_PRETTY_PRINT));