//main setting page operation
document.getElementById('DebtPayoffPlan').addEventListener('click', function(event) {
    window.location.href = "DebtPayoffPlan.html"; 
});

document.getElementById('FinancialGoal').addEventListener('click', function(event) {
    window.location.href = "financialGoal.html"; 
});

document.getElementById('CategoriesIncludeTransactions').addEventListener('click', function(event) {
    window.location.href = "CategoriesIncludeTransactions.html"; 
});

document.getElementById('ExportTransactionHistory').addEventListener('click', function(event) {
    window.location.href = "ExportTransactionHistory.html"; 
});

document.getElementById('Security').addEventListener('click', function(event) {
    window.location.href = "security.html"; 
});

// 

//bottom click operation
document.getElementById('addNewGoal').addEventListener('click', function(event) {
    window.location.href = "addGoal.html"; 
});




document.getElementById('goal-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const goalsName = document.getElementById('goalsName').value;
    const totalAmount = document.getElementById('totalAmount').value;
    const currentBudget = document.getElementById('currentBudget').value;

    if (goalsName.trim() !== '' && totalAmount.trim() !== '' && currentBudget.trim() !== '') {
        fetch('updateBudge.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ goalsName, totalAmount, currentBudget }) 
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            window.location.href = "financialGoal.html"; // Redirect on success
        }) 
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please enter all the fields.');
    }
});


