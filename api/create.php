<?php

$data = json_decode(file_get_contents("php://input"), true);

$tasks = json_decode(file_get_contents("../tasks.json"), true);

$newTask = [
    "id" => time(),
    "title" => $data["title"],
    "status" => $data["status"]
];

$tasks[] = $newTask;

file_put_contents("../tasks.json", json_encode($tasks, JSON_PRETTY_PRINT));