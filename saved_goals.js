document.addEventListener('DOMContentLoaded', function() {
    fetchGoal();
});

function fetchGoal() {
    fetch('saved_goals.php', {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            const goalList = document.getElementById('goalCont'); // Corrected ID
            goalList.innerHTML = ''; // Clear previous content

            // Reverse the order of goals and slice to get the latest three goals
            const reversedGoals = data.goals.reverse();

            // Limit to the first three goals
            reversedGoals.slice(0, 3).forEach(goal => {
                // Create elements for each goal and append them to the container
                const goalElement = document.createElement('div');
                goalElement.className = 'goal';
                goalElement.innerHTML = `
                   <h2>${goal.GoalName}</h2>
                   <p>Target Amount: ${goal.TargetAmount}</p>
                   <p>Target Date: ${goal.Date}</p>
                `;
                goalList.appendChild(goalElement);
            });
        } else {
            console.error('Failed to fetch goals:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
