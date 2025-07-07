// Script JS concernant les pages d'authentifications

// Encapsulation pour éviter la pollution globale
(function() {
    const FORM_LOGIN = document.querySelector('.form--login');
    const FORM_INPUT = document.querySelectorAll('.form-input');
    const INPUT_FIRSTNAME = document.querySelector('.input--firstname');
    const INPUT_LASTNAME = document.querySelector('.input--lastname');
    const INPUT_USERNAME = document.querySelector('.input--username');
    const INPUT_EMAIL = document.querySelector('.input--email');
    const INPUT_PASSWORD = document.querySelector('.input--password');
    const INPUT_CONFIRM_PASSWORD = document.querySelector('.input--confirm-password');
    const P_DANGER = document.querySelectorAll('.p-danger');
    const BTN_HIDE_SHOW_PASSWORD = document.querySelector('.btn-hide-show--password i');
    const BTN_HIDE_SHOW_CONFIRM_PASSWORD = document.querySelector('.btn-hide-show--confirm-password i');
    const BTN_LOGIN = document.querySelector('.btn--login')

    // Afficher l'icon œil si l'itulisateur clique sur l'input mot de passe
    if (INPUT_PASSWORD && BTN_HIDE_SHOW_PASSWORD) {
        INPUT_PASSWORD.addEventListener('focus', showEyePassword)
        function showEyePassword() {
            BTN_HIDE_SHOW_PASSWORD.style.display = "block"
        }
    }

    // Gestion des erreurs
    /*INPUT_PASSWORD.addEventListener('input', function() {
        if (INPUT_PASSWORD.value.length >= 1 && INPUT_PASSWORD.value.length < 8) {
            INPUT_PASSWORD.classList.add('focus--error')
            P_DANGER[1].textContent = "Doit contenir au-moins 8 caractères"
            P_DANGER[1].style.display = "block"
        } else {
            INPUT_PASSWORD.classList.remove('focus--error')
            P_DANGER[1].textContent = ""
            P_DANGER[1].style.display = "none"
        }
    })

    FORM_INPUT.forEach((input, i) => {

        FORM_LOGIN.addEventListener('submit', formlogin) 
        function formlogin(event){
            if (input.value == "") {
                event.preventDefault()
                input.classList.add('placeholder')
                input.placeholder = `${input.dataset.name} est réquis.`
            }
        }
        input.addEventListener('focus', function() {
            input.classList.remove('placeholder')
            input.placeholder = `${input.dataset.name}`
        })
    })*/

    // Affiche/Masque le mot de passe
    if (BTN_HIDE_SHOW_PASSWORD) {
        BTN_HIDE_SHOW_PASSWORD.addEventListener('click', showHidePassword)
        function showHidePassword() {
            if (BTN_HIDE_SHOW_PASSWORD.classList.contains('ri-eye-off-fill')) {
                BTN_HIDE_SHOW_PASSWORD.classList.replace('ri-eye-off-fill', 'ri-eye-fill')
                INPUT_PASSWORD.type = "text"
            } else {
                BTN_HIDE_SHOW_PASSWORD.classList.replace('ri-eye-fill', 'ri-eye-off-fill')
                INPUT_PASSWORD.type = "password"
            }
        }
    }

    
    if (BTN_HIDE_SHOW_PASSWORD) {
        // Masque l'icon œil si l'utilisateur clique en dehors
        window.addEventListener('click', hideEyePassword)
        function hideEyePassword(event) {
            if (
                !event.target.matches('.input--password') 
                && !event.target.matches('.btn-hide-show--password i')
                && !event.target.matches('.btn-hide-show--password')
            ) {
                BTN_HIDE_SHOW_PASSWORD.style.display = "none"
            }
        }
    }

    // Afficher l'icon œil si l'itulisateur clique sur l'input confirm mot de passe
    if (INPUT_CONFIRM_PASSWORD && BTN_HIDE_SHOW_CONFIRM_PASSWORD) {
        INPUT_CONFIRM_PASSWORD.addEventListener('focus', showEyeConfirmPassword)
        function showEyeConfirmPassword() {
            BTN_HIDE_SHOW_CONFIRM_PASSWORD.style.display = "block"
        }
    }

    // Masque l'icon œil si l'utilisateur clique en dehors
    if (BTN_HIDE_SHOW_CONFIRM_PASSWORD) {
        window.addEventListener('click', hideEyeConfirmPassword)
        function hideEyeConfirmPassword(event) {
            if (
                !event.target.matches('.input--confirm-password') 
                && !event.target.matches('.btn-hide-show--confirm-password i')
                && !event.target.matches('.btn-hide-show--confirm-password')
            ) {
                BTN_HIDE_SHOW_CONFIRM_PASSWORD.style.display = "none"
            }
        }
    }
    


    // Affiche/Masque le confirm mot de passe
    if (BTN_HIDE_SHOW_CONFIRM_PASSWORD) {
        BTN_HIDE_SHOW_CONFIRM_PASSWORD.addEventListener('click', showHideConfirmPassword)
        function showHideConfirmPassword() {
            if (BTN_HIDE_SHOW_CONFIRM_PASSWORD.classList.contains('ri-eye-off-fill')) {
                BTN_HIDE_SHOW_CONFIRM_PASSWORD.classList.replace('ri-eye-off-fill', 'ri-eye-fill')
                INPUT_CONFIRM_PASSWORD.type = "text"
            } else {
                BTN_HIDE_SHOW_CONFIRM_PASSWORD.classList.replace('ri-eye-fill', 'ri-eye-off-fill')
                INPUT_CONFIRM_PASSWORD.type = "password"
            }
        }
    }
})()

