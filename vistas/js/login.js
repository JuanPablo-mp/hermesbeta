function togglePassword() {
    const passwordField = document.querySelector('input[name="ingPassword"]');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField) {
       if (passwordField.type === 'password') {
            passwordField.type = 'text'
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash')
        }
    }
}