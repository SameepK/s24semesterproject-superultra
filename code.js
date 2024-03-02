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
    window.location.href = "financialGoal.html"; 
});

// 

//bottom click operation
document.getElementById('addNewGoal').addEventListener('click', function(event) {
    window.location.href = "addGoal.html"; 
});


//save bottom to update database and nevigate back to financia goal page
document.getElementById('save-goal').addEventListener('click', function(event) {
    event.preventDefault(); // Always prevent default form submission

    const goalsName = document.getElementById('GoldsName').value;
    const totalAmount = document.getElementById('TotalAmount').value;
    const currentBudget = document.getElementById('CurrentBudget').value;

    if (goalsName.trim() !== '' && totalAmount.trim() !== '' && currentBudget.trim() !== '') {
        fetch('updateBudget.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ goalsName, totalAmount, currentBudget}) 
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            window.location.href = "financialGoal.html"; 
        }) 
        .catch(error => console.error(error));
    } else {
        alert('Please enter'); 
    }
});





