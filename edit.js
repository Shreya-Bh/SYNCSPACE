function requestOtp() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'otp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('otpRequestForm').style.display = 'none';
                document.getElementById('verifyOTPForm').style.display = 'block';
                
            } else {
                
            }
        }
    };
    xhr.send();
}

function verifyOTP() {
    var otp = document.getElementById('otp').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'votp.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('verifyOTPForm').style.display = 'none';
                    document.getElementById('updateForm').style.display = 'block';
                } else {
                    document.getElementById('message').innerHTML = 'Failed to verify OTP.';
                }
            } else {
                document.getElementById('message').innerHTML = 'Error verifying OTP.';
            }
        }
    };
    xhr.send('otp=' + otp);
}


function updateInfo() {
    var name = document.getElementById('name').value;
    var number = document.getElementById('number').value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_info.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'enter.html'; 
                } else {
                    
                }
            } else {
                
            }
        }
    };
    xhr.send('name=' + name + '&number=' + number);
}
