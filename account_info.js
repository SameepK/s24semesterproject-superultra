document.addEventListener("DOMContentLoaded", function() {
            fetchAccountDetails();
            let btnBack = document.querySelector('button')
                btnBack.addEventListener('click', () => {
                    window.history.back();
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
                    document.getElementById('username').innerText = data.username;
                    document.getElementById('email').innerText = data.email;
                    document.getElementById('name').innerText = data.name;
                    document.getElementById('number').innerText = data['account number'];
                })
                .catch(error => console.error('Error fetching user details:', error));
        }