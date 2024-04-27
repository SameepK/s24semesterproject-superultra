const budgetOptions = [
  { name: "50/30/20 Rule", description: "Allocate 50% of your income to needs, 30% to wants, and 20% to savings and debt repayment." },
  { name: "Envelope System", description: "Allocate specific amounts of cash to different categories (envelopes) each month to control spending." },
  { name: "Zero-Based Budgeting", description: "Assign every dollar of your income a purpose, ensuring that income minus expenses equals zero." },
  { name: "Percentage-Based Budgeting", description: "Allocate fixed percentages of your income to different expense categories." }
];

const budgetGuidelinesContainer = document.getElementById('budgetGuidelines');
const resultContainer = document.getElementById('resultContainer');
let selectedOption = null;

function displayBudgetOptions() {
  budgetGuidelinesContainer.innerHTML = ''; // Clear previous options

  budgetOptions.forEach(option => {
    const optionElement = document.createElement('div');
    optionElement.classList.add('budgetOption');
    optionElement.innerHTML = `
      <h3>${option.name}</h3>
      <p>${option.description}</p>
    `;
    optionElement.addEventListener('click', () => {
      selectOption(option, optionElement);
    });
    budgetGuidelinesContainer.appendChild(optionElement);
  });
}

function selectOption(option, optionElement) {
  const previousOption = document.querySelector('.budgetOption.selected');
  if (previousOption) {
    previousOption.classList.remove('selected');
  }

  optionElement.classList.add('selected');
  selectedOption = option;
  displayBudgetForm();
}

function displayBudgetForm() {
  const formContainer = document.getElementById('formContainer');
  formContainer.innerHTML = `
    <h2>Enter Your Monthly Income</h2>
    <input type="number" id="incomeInput" placeholder="Enter your monthly income">
    <button onclick="calculateAllocations()">Calculate Allocations</button>
  `;
}

function calculateAllocations() {
  const income = parseFloat(document.getElementById('incomeInput').value);
  if (isNaN(income) || income <= 0) {
    alert('Please enter a valid monthly income.');
    return;
  }

  let needs, wants, savingsAndDebt;

  switch (selectedOption.name) {
    case "50/30/20 Rule":
      needs = income * 0.5;
      wants = income * 0.3;
      savingsAndDebt = income * 0.2;
      break;
    case "Envelope System":
      needs = income / 3;
      wants = income / 3;
      savingsAndDebt = income / 3;
      break;
    case "Zero-Based Budgeting":
      resultContainer.innerHTML = `
        <p>Assign every dollar of your income a purpose, ensuring that income minus expenses equals zero.</p>
        <p>For example:</p>
        <ul>
          <li>Income: $${income.toFixed(2)}</li>
          <li>Needs: $${(income * 0.5).toFixed(2)}</li>
          <li>Wants: $${(income * 0.3).toFixed(2)}</li>
          <li>Savings and Debt Repayment: $${(income * 0.2).toFixed(2)}</li>
        </ul>
      `;
      return;
    case "Percentage-Based Budgeting":
      resultContainer.innerHTML = `
        <p>Allocate fixed percentages of your income to different expense categories:</p>
        <ul>
          <li>Needs: ${income * 0.5}</li>
          <li>Wants: ${income * 0.3}</li>
          <li>Savings and Debt Repayment: ${income * 0.2}</li>
        </ul>
      `;
      return;
    default:
      alert('Invalid budget guideline selected.');
      return;
  }

  resultContainer.innerHTML = `
    <ul>
      <li>Needs: $${needs.toFixed(2)}</li>
      <li>Wants: $${wants.toFixed(2)}</li>
      <li>Savings and Debt Repayment: $${savingsAndDebt.toFixed(2)}</li>
    </ul>
  `;
}

displayBudgetOptions();