document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reservationForm');
    const confirmationMessage = document.getElementById('confirmationMessage');

    // Validate phone number format
    function isValidPhone(phone) {
        // Format français: 06 12 34 56 78 or 06.12.34.56.78 or 0612345678
        const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
        return phoneRegex.test(phone);
    }

    // Validate date (must be today or in the future)
    function isValidDate(date) {
        const selectedDate = new Date(date);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return selectedDate >= today;
    }

    // Validate time (restaurant hours: 11:00 - 23:00)
    function isValidTime(time) {
        const [hours, minutes] = time.split(':').map(Number);
        return (hours >= 11 && hours < 23) || (hours === 23 && minutes === 0);
    }

    // Show error message
    function showError(input, message) {
        // Remove any existing error message
        const existingError = input.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Create and add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1';
        errorDiv.textContent = message;
        input.parentElement.appendChild(errorDiv);
        input.classList.add('border-red-500');
    }

    // Clear error message
    function clearError(input) {
        const errorDiv = input.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        input.classList.remove('border-red-500');
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Clear all previous error messages
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        document.querySelectorAll('input').forEach(input => input.classList.remove('border-red-500'));

        // Validate name
        const nom = form.nom.value.trim();
        if (nom.length < 2) {
            showError(form.nom, 'Veuillez entrer un nom valide (minimum 2 caractères)');
            isValid = false;
        }

        // Validate phone
        if (!isValidPhone(form.telephone.value.trim())) {
            showError(form.telephone, 'Veuillez entrer un numéro de téléphone valide');
            isValid = false;
        }

        // Validate number of people
        if (!form.personnes.value) {
            showError(form.personnes, 'Veuillez sélectionner le nombre de personnes');
            isValid = false;
        }

        // Validate date
        if (!isValidDate(form.date.value)) {
            showError(form.date, 'La date doit être aujourd\'hui ou dans le futur');
            isValid = false;
        }

        // Validate time
        if (!isValidTime(form.heure.value)) {
            showError(form.heure, 'L\'heure doit être entre 11h00 et 23h00');
            isValid = false;
        }

        if (isValid) {
            // Simulate form submission
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement en cours...';

            setTimeout(() => {
                // Show confirmation message
                confirmationMessage.classList.remove('hidden');
                confirmationMessage.scrollIntoView({ behavior: 'smooth' });

                // Reset form and button
                form.reset();
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-check mr-2"></i>Confirmer la Réservation';

                // Hide confirmation message after 5 seconds
                setTimeout(() => {
                    confirmationMessage.classList.add('hidden');
                }, 5000);
            }, 1500);
        }
    });

    // Clear error messages when input changes
    form.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', () => clearError(input));
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    form.date.min = today;

    // Initialize time input with default value
    if (!form.heure.value) {
        form.heure.value = '19:00';
    }
});