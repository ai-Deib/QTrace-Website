const input = document.getElementById('imageInput');
const preview = document.getElementById('preview-img');
const placeholder = document.getElementById('placeholder');
const error = document.getElementById('error-msg');
const btnRemove = document.getElementById('btnRemove');

input.addEventListener('change', function() {
    const file = this.files[0];
    error.textContent = "";

    if (file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            error.textContent = "Error: Only JPG, JPEG, and PNG files are allowed.";
            this.value = "";
            resetPreview();
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            btnRemove.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

btnRemove.addEventListener('click', function() {
    input.value = "";
    resetPreview();
});

function resetPreview() {
    preview.src = "";
    preview.style.display = 'none';
    placeholder.style.display = 'block';
    btnRemove.style.display = 'none';
}
