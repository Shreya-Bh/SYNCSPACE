document.addEventListener('DOMContentLoaded', () => {
    const yearSelect = document.getElementById('year');
    const monthSelect = document.getElementById('month');
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1; 

    
    for (let year = 2023; year <= currentYear; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    yearSelect.addEventListener('change', updateMonthOptions);
    updateMonthOptions();

    function updateMonthOptions() {
        const selectedYear = parseInt(yearSelect.value, 10);
        monthSelect.innerHTML = '';

        
        const maxMonth = (selectedYear === currentYear) ? currentMonth - 1 : 12;
        for (let month = 1; month <= maxMonth; month++) {
            const option = document.createElement('option');
            option.value = month;
            option.textContent = new Date(0, month - 1).toLocaleString('en', { month: 'long' });
            monthSelect.appendChild(option);
        }

        monthSelect.value = Math.min(currentMonth - 1, maxMonth);
    }
});

function requestOtp() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'requestOtp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('otpForm').style.display = 'none';
                document.getElementById('verifyOtpForm').style.display = 'block';
                
            } else {
                
            }
        }
    };
    xhr.send();
}

function verifyOtp() {
    const otp = document.getElementById('otp').value;
    fetch('verifyOtp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ otp: otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('verifyOtpForm').style.display = 'none';
            document.getElementById('reportForm').style.display = 'block';
        } else {
            alert('Invalid OTP: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error verifying OTP:', error);
        alert('An error occurred while verifying the OTP.');
    });
}

function downloadReport() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    window.location.href = `downloadReport.php?year=${year}&month=${month}`;
}
