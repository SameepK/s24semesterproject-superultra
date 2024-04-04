document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    
    menuToggle.addEventListener('click', function () {
      this.classList.toggle('active');
    });
  });
  function showBankDetails(bankName, amount) {
    // Example: Updating the page or showing a modal with the bank details
    alert(`Bank: ${bankName}\nAmount: ${amount}`);
    }

  
  document.addEventListener('DOMContentLoaded', function() {
    fetch('getLatestCategories.php')
        .then(response => response.json())
        .then(data => {
            if(data.success && data.categories) {
                const categories = data.categories;
                // Assuming you have three elements for the categories
                if(categories[0]) {
                    document.querySelector('#bud1 h2').textContent = categories[0].CategoryName;
                    document.querySelector('#bud1 p').textContent = categories[0].CaDescription;
                }
                if(categories[1]) {
                    document.querySelector('#bud2 h2').textContent = categories[1].CategoryName;
                    document.querySelector('#bud2 p').textContent = categories[1].CaDescription;
                }
                if(categories[2]) {
                    document.querySelector('#bud3 h2').textContent = categories[2].CategoryName; // Make sure you have bud3 in your HTML
                    document.querySelector('#bud3 p').textContent = categories[2].CaDescription;
                }
            } else {
                console.error('Failed to load categories');
            }
        })
        .catch(error => console.error('Error:', error));
});
