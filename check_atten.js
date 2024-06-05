document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();

    document.getElementById('showAttendanceBtn').addEventListener('click', () => {
        const email = document.getElementById('userSelect').value;
        fetchAttendance(email);
    });
});

function fetchUsers() {
    fetch('getUsers.php')
        .then(response => response.json())
        .then(data => {
            const userSelect = document.getElementById('userSelect');
            data.forEach(user => {
                const option = document.createElement('option');
                option.value = user.email;
                option.textContent = `${user.name} (${user.email})`;
                userSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching users:', error));
}

function fetchAttendance(email) {
    fetch(`getAttendance.php?email=${encodeURIComponent(email)}`)
        .then(response => response.json())
        .then(data => {
            const reportDiv = document.getElementById('attendanceReport');
            reportDiv.innerHTML = `<h2>Attendance Report for ${data.name}</h2>`;
            reportDiv.innerHTML += `<p><strong>Yearly:</strong> ${data.yearly.present} days present, ${data.yearly.absent} days absent</p>`;
            
            Object.keys(data.monthly).forEach(month => {
                const monthData = data.monthly[month];
                reportDiv.innerHTML += `<h3>${month} (${monthData.status})</h3>`;
                if (monthData.status === 'Recorded') {
                    reportDiv.innerHTML += `<p><strong>Present:</strong> ${monthData.present} days</p>`;
                    reportDiv.innerHTML += `<p><strong>Absent:</strong> ${monthData.absent} days</p>`;
                } else {
                    reportDiv.innerHTML += '<p>Attendance not recorded yet.</p>';
                }
            });

            reportDiv.innerHTML += '<h3>Overall Absent Dates:</h3>';
            data.absentDates.forEach(date => {
                reportDiv.innerHTML += `<p>${date}</p>`;
            });

            reportDiv.innerHTML += `<h3>Total Days Present: ${data.yearly.present}</h3>`;
            reportDiv.innerHTML += `<h3>Total Days Absent: ${data.yearly.absent}</h3>`;
        })
        .catch(error => console.error('Error fetching attendance:', error));
}
