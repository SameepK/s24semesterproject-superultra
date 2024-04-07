document.addEventListener('DOMContentLoaded', function() {
    const bankSelector = document.getElementById('bankSelector');
    const accountInfo = document.getElementById('accountInfo');
    const balanceDisplay = document.getElementById('balance');

    bankSelector.addEventListener('change', function() {
        if(bankSelector.value !== "") {
            // Generate a random balance between 1,000 and 10,000
            const randomBalance = Math.floor(Math.random() * (10000 - 1000 + 1)) + 1000;
            balanceDisplay.textContent = `$${randomBalance.toLocaleString()}`;

            accountInfo.style.display = "block"; // Display the account details and transaction history
        } else {
            accountInfo.style.display = "none"; // Hide the details if no bank is selected
        }
    });
});



