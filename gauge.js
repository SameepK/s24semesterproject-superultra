// Assuming this file is gauge.js

document.addEventListener('DOMContentLoaded', function() {
    generateGauge();
});

function generateGauge() {
    const gaugeContainer = document.getElementById('creditScoreGauge');
    const svgNS = "http://www.w3.org/2000/svg";
    
    // Create SVG element
    const svg = document.createElementNS(svgNS, "svg");
    svg.setAttribute('viewBox', '0 0 36 18');

    // Create arc for the gauge
    const arc = document.createElementNS(svgNS, "path");
    arc.setAttribute('d', describeArc(18, 18, 16, -90, 90));
    arc.setAttribute('fill', 'none');
    arc.setAttribute('stroke', '#ccc');
    arc.setAttribute('stroke-width', '1.5');
    
    // Append arc to SVG
    svg.appendChild(arc);

    // More SVG creation here... (for labels and colors)

    // Create needle group
    const needleGroup = document.createElementNS(svgNS, "g");
    needleGroup.setAttribute('class', 'needle-group');

    // Create needle
    const needle = document.createElementNS(svgNS, "line");
    needle.setAttribute('class', 'needle');
    needle.setAttribute('x1', '18');
    needle.setAttribute('y1', '2');
    needle.setAttribute('x2', '18');
    needle.setAttribute('y2', '16');
    needle.setAttribute('stroke', '#000');
    needle.setAttribute('stroke-width', '0.1');

    // Create needle center circle
    const needleCenter = document.createElementNS(svgNS, "circle");
    needleCenter.setAttribute('class', 'needle-center');
    needleCenter.setAttribute('cx', '18');
    needleCenter.setAttribute('cy', '18');
    needleCenter.setAttribute('r', '0.5');
    needleCenter.setAttribute('fill', '#000');

    // Append needle and center to group
    needleGroup.appendChild(needle);
    needleGroup.appendChild(needleCenter);

    // Append needle group to SVG
    svg.appendChild(needleGroup);

    // Append SVG to container
    gaugeContainer.appendChild(svg);

    // Create text element for score
    const scoreText = document.createElement('div');
    scoreText.className = 'score-text';
    scoreText.textContent = 'Score: 0';
    gaugeContainer.appendChild(scoreText);
}

function updateGauge() {
    const score = document.getElementById('creditScoreInput').value;
    const normalizedScore = Math.min(Math.max(score, 300), 850);
    const angle = mapRange(normalizedScore, 300, 850, -90, 90);
    
    // Update needle rotation
    const needle = document.querySelector('.needle');
    needle.setAttribute('transform', `rotate(${angle} 18 18)`);

    // Update score text
    const scoreText = document.querySelector('.score-text');
    scoreText.textContent = `Score: ${normalizedScore}`;
}

// Function to describe an SVG arc
function describeArc(x, y, radius, startAngle, endAngle) {
    // SVG path for arc... (code omitted for brevity)
}

// Map range of input to range of output
function mapRange(value, inMin, inMax, outMin, outMax) {
    return outMin + (outMax - outMin) * (value - inMin) / (inMax - inMin);
}
