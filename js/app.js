const form = document.getElementById('newsletterForm');

form.addEventListener('submit', async(event) => {
    event.preventDefault();
    const email = { email: form.elements['email'].value };

    const response = await fetch('/app.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(email)
    });
    const json = await response.json();
    if (json.error === null) {
        const successMessage = document.getElementById('success');
        successMessage.innerHTML = 'Thank you. Your email has been successfully saved.';
        const elem = document.getElementById('newsletterForm');
        elem.style.display = 'none';
    } else {
        const errorMessage = document.getElementById('error');
        errorMessage.innerHTML = json.error;
    }
});