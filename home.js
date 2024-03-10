document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menuToggle');
    
    menuToggle.addEventListener('click', function () {
      this.classList.toggle('active');
    });
  });
  