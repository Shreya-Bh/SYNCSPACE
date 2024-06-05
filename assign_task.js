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



document.addEventListener("DOMContentLoaded", function() {
    
    function populateDropdowns(users) {

        var assigneeDropdown = document.getElementById('assignee');

        users.forEach(user => {
            var option = document.createElement('option');
            option.value = user.email;
            option.textContent = user.name;


            var cloneOption = option.cloneNode(true); 
            assigneeDropdown.appendChild(cloneOption);
        });
    }

    
    fetch('assign_task.php')
        .then(response => response.json())
        .then(data => populateDropdowns(data))
        .catch(error => console.error('Error fetching users:', error));
});


//group

window.onload = function() {
    fetch('fetch_assignees.php')
    .then(response => response.json())
    .then(data => {
        const assigneesDropdown = document.getElementById('assignees');
        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.email;
            option.text = user.name;
            assigneesDropdown.appendChild(option);
        });
    });
}


let addedAssignees = [];


function addAssignee() {
    const assigneesContainer = document.getElementById('assigneesContainer');
    const assigneesDropdown = document.createElement('select');
    assigneesDropdown.name = 'assignees[]';
    assigneesDropdown.required = true;

    fetch('fetch_assignees.php')
    .then(response => response.json())
    .then(data => {
        let addedAssignees = []; 

        
        const existingAssignees = assigneesContainer.querySelectorAll('select');
        existingAssignees.forEach(select => {
            addedAssignees.push(select.value); 
        });

        data.forEach(user => {
            
            if (!addedAssignees.includes(user.email)) {
                const option = document.createElement('option');
                option.value = user.email;
                option.text = user.name;
                assigneesDropdown.appendChild(option);
            }
        });

        
        if (assigneesDropdown.childElementCount > 0) {
            assigneesContainer.appendChild(assigneesDropdown);
            assigneesContainer.appendChild(document.createElement('br'));
        } else {
            alert('No new assignees to add.');
        }
    });
}


