document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="signup.php"]');
    const passwordField = document.querySelector('input[name="password"]');
    const confirmPasswordField = document.querySelector('input[name="confirm_password"]');
    const passwordRequirementsText = document.createElement('div');

    passwordRequirementsText.style.marginTop = '10px';
    form.insertBefore(passwordRequirementsText, form.children[4]); // Adjust the index as needed to place the message correctly

    function updatePasswordMessage() {
        const value = passwordField.value;
        const requirementsMet = value.length >= 8 &&
                                /[A-Z]/.test(value) &&
                                /\d/.test(value) &&
                                /[!@#$%^&*()]/.test(value);

        if (requirementsMet) {
            passwordRequirementsText.textContent = "Password meets all requirements.";
            passwordRequirementsText.style.color = 'green';
        } else {
            passwordRequirementsText.textContent = "Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.";
            passwordRequirementsText.style.color = 'red';
        }
    }

    passwordField.addEventListener('input', updatePasswordMessage);
    confirmPasswordField.addEventListener('input', updatePasswordMessage);

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(form);

        fetch('signup.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.html'; // Redirect user after successful registration
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
});
