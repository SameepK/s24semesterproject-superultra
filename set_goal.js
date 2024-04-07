document.getElementById('saveGoalButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission
  
    const goal = document.getElementById('goalNameInput').value;
    const targetAmount = document.getElementById('targetAmountInput').value;
    const targetDate = document.getElementById('targetDateInput').value;
  
    if (goal.trim() !== '' && targetAmount.trim() !== '' && targetDate.trim() !== '') {
        fetch('set_goals.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ goal, targetAmount, targetDate }) 
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            window.location.href = "saved_goals.html"; // Redirect on success
        }) 
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please enter all the fields.');
    }
  });