import axios from "axios";
import './bootstrap';


(() => {
    if (window.location.pathname === '/') {
        const loginForm = document.getElementById("logsForm");

        if (loginForm !== null) {
            loginForm.addEventListener('submit', async function (events) {
                events.preventDefault();

                const form = new FormData(events.target);
                try {
                    const { status } = await axios.post("/login", {
                        _token: document.querySelector(`meta[name="csrf-token"]`).getAttribute('content'),
                        email: form.get('email'),
                        password: form.get('password')
                    });

                    if (status < 300) {
                        window.location.reload();
                    }
                } catch (error) {
                    const emailField = document.getElementById('email');
                    const passwordField = document.getElementById('password');
                    const passwordHint = document.getElementById('passwordHint');
                    const emailHint = document.getElementById('emailHint');

                    if (!emailField.classList.contains('input-error') && !passwordField.classList.contains('input-error')) {
                        emailField.classList.toggle('input-error');
                        passwordField.classList.toggle('input-error');

                        passwordHint.innerText = `Cek Kembali Kata Sandi Anda!`;
                        emailHint.innerText = `Cek Kembali Email / Surel Anda!`;
                    }
                }
            });
        }
    }
})();

