
document.getElementById('rrr').addEventListener('click', function(event) {
    event.preventDefault();

    const username = document.getElementById('reset-username').value;
    const oldPassword = document.getElementById('old-password').value;
    const newPassword = document.getElementById('new-password').value;

    if (username.trim() && oldPassword.trim() && newPassword.trim()){
        fetch('resetPassword.php', { 
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ username, oldPassword, newPassword })
        })
        .then(response => response.json())
        .then(data => {
                alert(data.message);
                window.location.href = "index.html";
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    } else {
        alert('Please fill in all fields.');
    }

});