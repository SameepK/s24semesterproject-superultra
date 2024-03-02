document.addEventListener("DOMContentLoaded", function() {
            // Fetch account details
            fetchAccountDetails();

            // Add event listener to the back button
            let btnBack = document.querySelector('button')
                btnBack.addEventListener('click', () => {
                    window.history.back();
                });
        });
        function fetchAccountDetails() {
            // Simulate data
            const data = {
                username: "JohnDoe",
                email: "john.doe@example.com",
                name: "John Doe",
                "account number": "1234567890"
            };

            // Populate account details
            document.getElementById('username').innerText = data.username;
            document.getElementById('email').innerText = data.email;
            document.getElementById('name').innerText = data.name;
            document.getElementById('number').innerText = data['account number'];
        }