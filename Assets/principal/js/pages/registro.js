document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const form = e.target;
    const passwordField = form.querySelector('input[name="password"]');
    const password = passwordField.value;

    // Hashear con SHA-256 antes de enviar
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    passwordField.value = hashHex; // reemplaza la contraseña con su hash

    form.submit(); // ahora sí envía el formulario
});
