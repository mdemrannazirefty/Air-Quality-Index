document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const fullName = document.getElementById('regFullname').value.trim();
        const email = document.getElementById('regEmail').value.trim();
        const password = document.getElementById('regPassword').value.trim();
        const confirmPassword = document.getElementById('regcPassword').value.trim();
        const location = document.getElementById('Location').value.trim();
        const zip = document.getElementById('Zip').value.trim();
        const preferredCity = document.getElementById('LOPcity').value;
        const checkbox = document.getElementById('checkbox').checked;

        let isValid = true;

        if (!fullName) {
            alert('Please enter your full name.');
            isValid = false;
        }

        const passwordRegex = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
        if (!password) {
            alert('Please enter a password.');
            isValid = false;
        } else if (!passwordRegex.test(password)) {
            alert('Password must follow this format: YY-XXXXX-Z@student.aiub.edu');
            isValid = false;
        }

        if (!password) {
            alert('Please enter a password.');
            isValid = false;
        } else if (password.length < 8) {
            alert('Password must be at least 8 characters long.');
            isValid = false;
        }

        if (!confirmPassword) {
            alert('Please confirm your password.');
            isValid = false;
        } else if (password !== confirmPassword) {
            alert('Passwords do not match.');
            isValid = false;
        }
        if (!location) {
            alert('Please enter your location.');
            isValid = false;
        }
        if (!zip) {
            alert('Please enter your valid zip code.');
            isValid = false;
        } else if (zip.length < 4) {
            alert('Zip must be 4 characters long.');
            isValid = false;
        }
        if (!checkbox) {
            alert('Please agree to the Terms and Conditions.');
            isValid = false;
        }
        if (!isValid) {
            return;
        }
        console.log('Full Name:', fullName);
        console.log('Email:', email);
        console.log('Location:', location);
        console.log('Zip:', zip);
        console.log('Preferred City:', preferredCity);
        console.log('Terms Agreed:', checkbox);
        alert("Registration Successful!");
        form.reset();
    });
});
