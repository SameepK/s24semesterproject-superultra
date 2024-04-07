document.getElementById('saveButton').addEventListener('click', function(event) {
    event.preventDefault();

    // Collect data from inputs
    const name = document.getElementById('nameInput').value;
    const accountNumber = document.getElementById('accountNumberInput').value;
    const username = document.getElementById('usernameInput').value;
    const password = document.getElementById('passwordInput').value;
    const email = document.getElementById('emailInput').value;

    // Check if all fields are filled
    if (name.trim() && accountNumber.trim() && username.trim() && password.trim() && email.trim()) {
        fetch('save_account_info.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ name, accountNumber, username, password, email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Display success message
                window.location.href = `display_info.html?userId=${data.userId}`;
            } else {
                if (data.message === 'Username is already taken') {
                    // Display the error message without redirecting
                    alert(data.message);
                } else {
                    // Other error occurred, redirect to error page or handle as needed
                    alert('An error occurred. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    } else {
        alert('Please fill in all fields.');
    }
});


function saveAccountInfo() {
    // Collect data from inputs
    const username = document.getElementById('usernameInput').value;

    // Check if username is empty
    if (!username.trim()) {
        alert('Please fill in the username field.');
        return;
    }

    fetch('save_account_info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Username: username }) // Send only the username for checking
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save account information');
        }
        return response.json(); // Parse response JSON
    })
    .then(data => {
        if (data.success) {
            alert(data.message); // Display success message
            window.location.href = `display_info.html?userId=${data.userId}`;
        } else {
            alert(data.message); // Display error message
        }
    })
    .catch(error => console.error('Error saving account information:', error));
}
