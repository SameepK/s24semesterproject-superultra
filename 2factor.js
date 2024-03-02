document.addEventListener('DOMContentLoaded', function() {
    // Request to send the 2FA code
    document.getElementById('send2FA').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'twofactor.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // Handle the response here
            alert(this.responseText); // For example, "2FA code sent to your email."
        };
        xhr.send();
    });

    // Handle the 2FA code verification
    document.getElementById('2fa-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var code = document.getElementById('2FA').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'verify2factor.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // Handle the response here
            // You might want to check for specific responses to update the UI accordingly
            alert(this.responseText); // For example, "Verification successful." or "Verification failed."
            
            // If verification is successful, you might want to redirect the user or update the UI
            if(this.responseText.includes("Verification successful")) {
                window.location.href = 'home.html'; // Redirect to a dashboard or relevant page
            }
        };
        xhr.send('2FA=' + encodeURIComponent(code));
    });
});
