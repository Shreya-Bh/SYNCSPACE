document.addEventListener('DOMContentLoaded', () => {
    fetchDepartmentAttendance();

    document.getElementById('downloadReportBtn').addEventListener('click', () => {
        downloadReport();
    });
});

function fetchDepartmentAttendance() {
    fetch('getDepartmentAttendance.php')
        .then(response => response.json())
        .then(data => {
            const reportDiv = document.getElementById('departmentAttendanceReport');
            reportDiv.innerHTML = ''; 
            for (const deptId in data) {
                const dept = data[deptId];
                let deptHtml = `
                    <div class="department">
                        <h2>${dept.name} (${Object.keys(dept.users).length} Employees)</h2>
                        <p><strong>Yearly:</strong> ${dept.yearly.present} days present, ${dept.yearly.absent} days absent</p>
                `;

                for (let month = 1; month <= 12; month++) {
                    const monthName = new Date(0, month - 1).toLocaleString('default', { month: 'long' });
                    const firstUserEmail = Object.keys(dept.users)[0];
                    const monthData = firstUserEmail && dept.users[firstUserEmail].monthly[month] || { status: 'Not recorded yet' };
                    
                    if (monthData.status !== 'Not recorded yet') {
                        deptHtml += `<h3>${monthName}</h3>`;
                        deptHtml += `
                            <table>
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        for (const email in dept.users) {
                            const user = dept.users[email];
                            deptHtml += `
                                <tr>
                                    <td>${user.name}</td>
                                    <td>${user.monthly[month].present}</td>
                                    <td>${user.monthly[month].absent}</td>
                                </tr>
                            `;
                        }

                        deptHtml += `</tbody></table>`;
                    }
                }

                deptHtml += '</div>';
                reportDiv.innerHTML += deptHtml;
            }
        })
        .catch(error => console.error('Error fetching department attendance:', error));
}

function downloadReport() {
    const { jsPDF } = window.jspdf;
    const reportDiv = document.getElementById('departmentAttendanceReport');
    const pdf = new jsPDF('p', 'mm', 'a4');

    const departments = document.querySelectorAll('.department');

    let pageHeight = pdf.internal.pageSize.height;
    let y = 10;

    departments.forEach((department, index) => {
        html2canvas(department).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 210; 
            const imgHeight = canvas.height * imgWidth / canvas.width;

            if (y + imgHeight > pageHeight - 10) { 
                pdf.addPage();
                y = 10; 
            }

            pdf.addImage(imgData, 'PNG', 10, y, imgWidth, imgHeight);
            y += imgHeight + 10; 

            if (index < departments.length - 1) { 
                pdf.addPage();
                y = 10;
            }

            if (index === departments.length - 1) { 
                pdf.save('attendance-report.pdf');
            }
        });
    });
}
