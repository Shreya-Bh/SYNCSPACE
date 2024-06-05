document.addEventListener("DOMContentLoaded", function() {
    var sidebarLinks = document.querySelectorAll('.sidebar a');
    var contentContainers = document.querySelectorAll('.content-container');

    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var targetId = this.getAttribute('data-target');

            contentContainers.forEach(function(container) {
                container.classList.remove('active');
            });

            document.getElementById(targetId).classList.add('active');
        });
    });
});



//get_tasks.php

window.onload = function() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tasks-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "get_tasks.php", true);
    xhttp.send();
};
function fetchTasks() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tasks-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "get_tasks.php", true);
    xhttp.send();
}

function markAsComplete(taskId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert("Task marked as complete!");
            fetchTasks();
        }
    };
    xhttp.open("POST", "mark_as_complete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + taskId);
}

//fetch_tasks.php
document.addEventListener('DOMContentLoaded', function() {
    fetchTasks();
});

function fetchTasks() {
    fetch('fetch_tasks.php')
    .then(response => response.json())
    .then(data => {
        displayTasks(data.assigned_to_me, 'tasks-assigned-to-me');
        displayTasks(data.assigned_by_me, 'tasks-assigned-by-me');
    })
    .catch(error => console.error('Error fetching tasks:', error));
}

function displayTasks(tasks, containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';

    if (tasks.length > 0) {
        tasks.forEach(task => {
            const taskElement = document.createElement('div');
            taskElement.classList.add('task');
            taskElement.innerHTML = `
                <strong>Task ID:</strong> ${task.id}<br>
                <strong>Assigner:</strong> ${task.assigner_name}<br>
                <strong>Assignee:</strong> ${task.assignee_name}<br>
                <strong>Description:</strong> ${task.task_description}<br>
                <strong>Given At:</strong> ${task.task_given_at}<br>
                <strong>Completed At:</strong> ${task.task_completed_at ? task.task_completed_at : '<p>Not completed yet</p>'}
            `;
            console.log(`Task ID ${task.id}: task_completed_at = ${task.task_completed_at}`);
            container.appendChild(taskElement);
        });
    } else {
        container.innerHTML = '<p>No tasks available.</p>';
    }
}




//groupwork
document.addEventListener("DOMContentLoaded", function() {
    fetchTasksGroupWork(); 
});

function fetchTasksGroupWork() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tasks-containeri").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "get_taski.php", true);
    xhttp.send();
}

function markAsCompleteGroupWork(taskId) {
    console.log("Task ID:", taskId); 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText); 
            fetchTasksGroupWork(); 
        }
    };
    xhttp.open("POST", "mark_as_completei.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + taskId);
}





//Group History
document.addEventListener("DOMContentLoaded", function() {
    fetchTasksAssignedByMe();
    fetchTasksAssignedToMe();
});
 
function fetchTasksAssignedByMe() {
    $.ajax({
        url: "tasks_assigned_by_me.php",
        method: "GET",
        success: function(data) {
            $("#assignedByMe").html(data);
            checkTaskCompletionStatus();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching tasks assigned by me:", error);
        }
    });
}
 
function fetchTasksAssignedToMe() {
    $.ajax({
        url: "tasks_assigned_to_me.php",
        method: "GET",
        success: function(data) {
            $("#assignedToMe").html(data);
            checkTaskCompletionStatus();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching tasks assigned to me:", error);
        }
    });
}
 
function checkTaskCompletionStatus() {
    $(".task").each(function() {
        var allCompleted = true;
        $(this).find("p").each(function() {
            if ($(this).text().includes("Not completed")) {
                allCompleted = false;
                return false; 
            }
        });
        if (allCompleted) {
            $(this).css("border-color", "green");
        } else {
            $(this).css("border-color", "red");
        }
    });
}
