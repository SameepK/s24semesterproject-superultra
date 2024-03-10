document.getElementById('SignUp').addEventListener('click', function(event) {
    event.preventDefault();
    const username = document.getElementById('signup-username').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm-password').value;

    if (username.trim() && email.trim() && password.trim() && confirmPassword.trim()) {
        
        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }
        
        fetch('signup.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ username, email, password, confirmPassword })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            window.location.href = "index.html"; // Redirect to login page or wherever you'd like
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    } else {
        alert('Please fill in all fields.');
    }
});



document.getElementById('CreateA').addEventListener('click', function(event) {
    event.preventDefault();
    window.location.href = 'SignUpPage.html'; 
});
