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
