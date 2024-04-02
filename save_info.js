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
            alert(data.message); // Assuming the PHP script returns a JSON object with a message property
            window.location.href = `display_info.html?userId=${data.userId}`;
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
    window.location.href = "home.html"; 
    let Username = document.getElementById('usernameInput').value;
    let Email = document.getElementById('emailInput').value;
    let Password = document.getElementById('passwordInput').value;
    let Account_number = document.getElementById('accountNumberInput').value;
    let Name = document.getElementById('nameInput').value;

    fetch('save_account_info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ Username: Username, Email: Email, Password: Password, Account_number: Account_number, Name: Name }) // Adjusted to match column names
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save account information');
        }
        console.log('Account information saved successfully');
        // Update displayed data after saving
        displaySavedInfo(Username, Email, Password, Account_number, Name);
    })
    .catch(error => console.error('Error saving account information:', error));
}

function displaySavedInfo(Username, Email, Password, Account_number, Name) {
    document.getElementById('usernameInput').value = Username;
    document.getElementById('emailInput').value = Email;
    document.getElementById('passwordInput').value = Password;
    document.getElementById('accountNumberInput').value = Account_number;
    document.getElementById('nameInput').value = Name;
}