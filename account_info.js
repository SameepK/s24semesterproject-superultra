document.addEventListener("DOMContentLoaded", function() {
    fetchAccountDetails();
    let btnBack = document.querySelector('#backButton');
    btnBack.addEventListener('click', () => {
        window.history.back();
    });

    let btnSave = document.querySelector('#saveButton');
    btnSave.addEventListener('click', () => {
        saveAccountInfo();
    });
});

function fetchAccountDetails() {
    fetch('fetch_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Display user data on the HTML elements
            document.getElementById('username').innerText = data.username;
            document.getElementById('email').innerText = data.email;
            document.getElementById('password').innerText = data.password;
            document.getElementById('accountNumberInput').value = data.accountNumber;
            document.getElementById('nameInput').value = data.name;
        })
        .catch(error => console.error('Error fetching user details:', error));
}

function saveAccountInfo() {
    let accountNumber = document.getElementById('accountNumberInput').value;
    let name = document.getElementById('nameInput').value;
    fetch('save_account_info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ accountNumber: accountNumber, name: name })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to save account information');
        }
        console.log('Account information saved successfully');
    })
    .catch(error => console.error('Error saving account information:', error));
}



// function fetchAccountDetails() {
//     fetch('fetch_data.php')
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.json();
//         })
//         .then(data => {
//             document.getElementById('username').innerText = data.username;
//             document.getElementById('email').innerText = data.email;
//             document.getElementById('name').innerText = data.name;
//             document.getElementById('password').innerText = data.password;
//         })
//         .catch(error => console.error('Error fetching user details:', error));
// }
