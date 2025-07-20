document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const LoginLink = document.querySelector('.SignInlink');
    const RegisterLink = document.querySelector('.Signuplink');

    // Ensure that the elements exist before adding event listeners
    if (RegisterLink) {
        RegisterLink.addEventListener('click', (event) => {
            event.preventDefault();  // Prevent default link behavior
            container.classList.add('active');
        });
    }

    if (LoginLink) {
        LoginLink.addEventListener('click', (event) => {
            event.preventDefault();  // Prevent default link behavior
            container.classList.remove('active');
        });
    }
});
