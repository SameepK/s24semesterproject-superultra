document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('creditScoreForm');
    let creditScoreChart = initializeChart(); // Initialize the chart when the document is ready

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const creditScore = parseInt(document.getElementById('creditScore').value, 10);

        if (creditScore < 300 || creditScore > 850) {
            alert('Please enter a valid credit score between 300 and 850.');
            return;
        }

        // Directly update the chart and result message based on the credit score
        updateChart(creditScoreChart, creditScore);
        updateResultMessage(creditScore);
    });
});

function initializeChart() {
    const ctx = document.getElementById('creditScoreChart').getContext('2d');
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Credit Score'],
            datasets: [{
                label: 'Score',
                data: [], // Initialize without data
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 850
                }
            }
        }
    });
}

function updateChart(chart, score) {
    chart.data.datasets.forEach((dataset) => {
        dataset.data = [score]; // Update the data point with the new score
    });
    chart.update();
}

function updateResultMessage(score) {
    let message = 'Invalid score';
    if (score >= 300 && score < 580) {
        message = 'Poor Credit Score';
    } else if (score >= 580 && score < 670) {
        message = 'Fair Credit Score';
    } else if (score >= 670 && score < 740) {
        message = 'Good Credit Score';
    } else if (score >= 740 && score <= 850) {
        message = 'Excellent Credit Score';
    }
    document.getElementById('result').innerText = message;
}
