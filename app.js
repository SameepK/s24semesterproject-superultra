const form = document.getElementById('login-form');

document.getElementById('loginButton').addEventListener('click', function(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() !== '' && password.trim() !== '') {

        window.location.href = "next_page.html"; 
    } else {
        alert('Please enter both username and password.'); 
        event.preventDefault();
    }
});
document.getElementById('CreateAccount').addEventListener('click', function(event) {
    window.location.href = "create_account.html"; 

});
document.getElementById('loginButton').addEventListener('click', function(event) {
    event.preventDefault(); // Always prevent default form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.trim() !== '' && password.trim() !== '') {
        fetch('send_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, password }) 
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            // Redirect after the alert from PHP is shown
            window.location.href = "next_page.html";  
        }) 
        .catch(error => console.error(error));
    } else {
        alert('Please enter both username and password.'); 
    }
});

form.addEventListener('submit', function(event) {
    event.preventDefault(); 

});

