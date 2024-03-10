
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    const quickMenu = document.getElementById('quickMenu');
  
    menuToggle.addEventListener('click', function () {
  
      if (quickMenu.style.display === 'block') {
        quickMenu.style.display = 'none';
      } else {
        quickMenu.style.display = 'block';
      }
    });
  });

  fetch('quick_menu.php')
  .then(response => response.json())
  .then(data => {
    if (data && data.username) {
      // Update the username element in the quick menu
      usernameElement.textContent = data.username;
    }
  })
  .catch(error => {
    console.error('Error fetching username:', error);
  });