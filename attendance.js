function requestOTP() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_otp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('otpRequestForm').style.display = 'none';
                document.getElementById('verifyOTPForm').style.display = 'block';
                document.getElementById('message').textContent = 'OTP sent to your email.';
            } else {
                document.getElementById('message').textContent = 'Error sending OTP.';
            }
        }
    };
    xhr.send();
}

function verifyOTP() {
    var otp = document.getElementById('otp').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'verify_otp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            var response = xhr.responseText;
            document.getElementById('message').textContent = response;
            
            if (response.includes("Attendance marked successfully. Redirecting...")) {
                
                setTimeout(function() {
                    window.location.href = 'dashboard.html';
                }, 1000);
            }
        }
    };
    xhr.send('otp=' + encodeURIComponent(otp));
}

