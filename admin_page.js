
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');
const addDepartmentForm = document.getElementById('addDepartmentForm');
const addManagerForm = document.getElementById('addManagerForm');

document.getElementById('add-department').addEventListener('click', function(event) {
   event.stopPropagation();  
   addDepartmentForm.classList.add('active');
   addManagerForm.classList.remove('active');  
});

document.getElementById('add-manager').addEventListener('click', function(event) {
   event.stopPropagation();  
   
   
   fetch('fetch_users.php')
      .then(response => response.json())
      .then(users => {
         const selectUserDropdown = document.getElementById('selectUserDropdown');
         selectUserDropdown.innerHTML = '';
         users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name + ' (' + user.email + ')';
            selectUserDropdown.appendChild(option);
         });
      });

   
   addManagerForm.classList.add('active');
   addDepartmentForm.classList.remove('active');  
});


function closeForms() {
   addDepartmentForm.classList.remove('active');
   addManagerForm.classList.remove('active');
}


document.addEventListener('click', function(event) {
   if (!addDepartmentForm.contains(event.target) && !addManagerForm.contains(event.target)) {
      closeForms();
   }
});


addDepartmentForm.addEventListener('click', function(event) {
   event.stopPropagation();
});

addManagerForm.addEventListener('click', function(event) {
   event.stopPropagation();
});
