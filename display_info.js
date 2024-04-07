document.addEventListener('DOMContentLoaded', function() {
    // Extract user ID from query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('userId');

    // Check if userId is present
    if (userId) {
        fetchUserInfo(userId);
    } else {
        console.error('User ID not found in URL query parameters');
        alert('User information not found.');
    }
});

function fetchUserInfo(userId) {
    fetch(`fetch_info.php?userId=${userId}`) // Adjust the path as per your server setup
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const userDetails = data.userDetails;

            // Save user details to localStorage
            localStorage.setItem('userDetails', JSON.stringify(userDetails));

            // Display user details
            displayUserInfo(userDetails);
        } else {
            console.error('Failed to fetch user details:', data.message);
            alert('An error occurred while fetching details.');
        }
    })
    .catch(error => {
        console.error('Error fetching user details:', error);
        alert('An error occurred while fetching user details.');
    });
}

function displayUserInfo(userDetails) {
    const detailsContainer = document.getElementById('detailsContainer');

    // Create HTML for displaying user details
    const userDetailsHTML = `
        <p><strong>Name:</strong> ${userDetails.Name}</p>
        <p><strong>Username:</strong> ${userDetails.Username}</p>
        <p><strong>Account Number:</strong> ${userDetails.Accoun_number}</p>
        <p><strong>Password:</strong> ${'*'.repeat(userDetails.Password.length)}</p>
        <p><strong>Email:</strong> ${userDetails.Email}</p>
    `;
    detailsContainer.innerHTML = userDetailsHTML;
}

// Load user details from localStorage when the page loads
window.addEventListener('load', function() {
    const storedUserDetails = localStorage.getItem('userDetails');
    if (storedUserDetails) {
        const userDetails = JSON.parse(storedUserDetails);
        displayUserInfo(userDetails);
    }
});
