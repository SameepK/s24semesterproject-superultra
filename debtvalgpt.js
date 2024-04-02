document.addEventListener('DOMContentLoaded', function() {
    const addDebtForm = document.getElementById('addDebtForm');
    const debtsTableBody = document.querySelector('.debt-list table tbody');
    
    function updateDebtSummary(debts) {
        const totalDebt = debts.reduce((total, debt) => total + parseFloat(debt.balance), 0);
        const totalInterestRate = debts.reduce((total, debt) => total + parseFloat(debt.interestRate), 0);
        const averageInterestRate = debts.length > 0 ? totalInterestRate / debts.length : 0;
        const totalMonthlyPayment = debts.reduce((total, debt) => total + parseFloat(debt.minimumPayment), 0);
    
        document.querySelector('.debt-summary').innerHTML = `
        <p>Total Debt: $${totalDebt.toFixed(2)}</p>
        <p>Average Interest Rate: ${averageInterestRate.toFixed(2)}%</p>
        <p>Total Monthly Payment: $${totalMonthlyPayment.toFixed(2)}</p>
        `;
    }
    
    function renderDebts(debts) {
        debtsTableBody.innerHTML = debts.map((debt) => `
            <tr>
                <td>${debt.creditor}</td>
                <td>$${parseFloat(debt.balance).toFixed(2)}</td>
                <td>${parseFloat(debt.interestRate).toFixed(2)}%</td>
                <td>$${parseFloat(debt.minimumPayment).toFixed(2)}</td>
                <td><button onclick="deleteDebt(${debt.id})">Delete</button></td>
            </tr>
        `).join('');
        updateDebtSummary(debts);
    }

    function fetchAndRenderDebts() {
        fetch('addDebt.php')
        .then(response => response.json())
        .then(debts => {
            renderDebts(debts);
            updateDebtSummary(debts);
        })
        .catch(error => console.error('Error fetching debts:', error));
    }

    window.deleteDebt = function(debtId) {
        fetch(`addDebt.php?deleteId=${debtId}`, {
            method: 'POST',
        })
        .then(response => response.text())
        .then(() => {
            fetchAndRenderDebts();
        })
        .catch(error => console.error('Error:', error));
    };

    addDebtForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('addDebt.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(() => {
            fetchAndRenderDebts();
        })
        .catch(error => console.error('Error:', error));

        this.reset();
    });

    fetchAndRenderDebts();
});
