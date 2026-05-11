<!DOCTYPE html>
<html lang="ru">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>📋 Task Board</h1>

<form id="taskForm">
    <input type="text" id="title" placeholder="Add a new task..." required>

    <select id="status">
        <option value="pending">📝 To Do</option>
        <option value="done">✅ Done</option>
    </select>

    <button type="submit">+ Add Task</button>
</form>

<div id="tasks" class="tasks-grid"></div>

</div>

<script>

async function loadTasks(){
    let response = await fetch('api/get.php');
    let tasks = await response.json();

    let pendingTasks = tasks.filter(t => t.status === 'pending');
    let doneTasks = tasks.filter(t => t.status === 'done');

    let html = `
        <div class="column">
            <div class="column-header">
                📝 To Do
                <span class="column-count">${pendingTasks.length}</span>
            </div>
            <div class="cards">
                ${pendingTasks.map(task => `
                    <div class="task pending">
                        <h3>${task.title}</h3>
                        <span class="status-badge pending">Pending</span>
                        <div class="actions">
                            <button onclick="changeStatus(${task.id})">Move to Done</button>
                            <button onclick="deleteTask(${task.id})">Delete</button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>

        <div class="column">
            <div class="column-header">
                ✅ Done
                <span class="column-count">${doneTasks.length}</span>
            </div>
            <div class="cards">
                ${doneTasks.map(task => `
                    <div class="task done">
                        <h3>${task.title}</h3>
                        <span class="status-badge done">Completed</span>
                        <div class="actions">
                            <button onclick="changeStatus(${task.id})">Move to To Do</button>
                            <button onclick="deleteTask(${task.id})">Delete</button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `;

    document.getElementById('tasks').innerHTML = html;
}

document.getElementById('taskForm').addEventListener('submit', async(e)=>{

    e.preventDefault();

    let title = document.getElementById('title').value;
    let status = document.getElementById('status').value;

    await fetch('api/create.php',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({
            title,
            status
        })
    });

    loadTasks();

    document.getElementById('taskForm').reset();
});

async function deleteTask(id){

    await fetch('api/delete.php',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({id})
    });

    loadTasks();
}

async function changeStatus(id){

    await fetch('api/status.php',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body:JSON.stringify({id})
    });

    loadTasks();
}

loadTasks();

</script>
</body>
</html>