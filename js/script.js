const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

registerLink.addEventListener('click', () => {
    console.log('Register link clicked');
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', () => {
    console.log('Login link clicked');
    wrapper.classList.remove('active');
});

