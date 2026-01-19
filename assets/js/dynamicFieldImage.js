$(document).ready(function() {
    const cardTemplate = `
        <div class="image-card">
            <div class="preview-container">
                <i class="bi bi-image preview-placeholder"></i>
                <img src="" class="preview-box">
            </div>
            <div class="mb-2">
                <select name="img_types[]" class="form-select form-select-sm" required>
                    <option value="" selected disabled>Category...</option>
                    <option value="site_progress">Site Progress</option>
                    <option value="before_photo">Before Photo</option>
                    <option value="after_photo">After Photo</option>
                    <option value="inspection">Inspection</option>
                </select>
            </div>
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-6">
                    <input type="file" name="img_files[]" class="form-control form-control-sm img-input" accept="image/*" required>
                </div>
                <div class="col-12 col-md-6">
                    <input type="url" name="img_urls[]" class="form-control form-control-sm img-url-input" placeholder="or paste image URL">
                </div>
            </div>
            <small class="text-muted">Upload a file or provide a URL.</small>
            <button class="btn btn-danger btn-sm remove-img-btn remove-btn" type="button"><i class="bi bi-x-lg"></i></button>
        </div>`;

    function isValidUrl(value) {
        try { return Boolean(new URL(value)); } catch (e) { return false; }
    }

    function updatePreview(card, src) {
        const preview = card.find('.preview-box');
        const placeholder = card.find('.preview-placeholder');
        if (src) {
            preview.attr('src', src).show();
            placeholder.hide();
        } else {
            preview.attr('src', '').hide();
            placeholder.show();
        }
    }

    function syncRequirement(card) {
        const fileInput = card.find('.img-input');
        const urlInput = card.find('.img-url-input');
        const hasFile = fileInput[0] && fileInput[0].files && fileInput[0].files.length > 0;
        const hasUrl = urlInput.val().trim().length > 0;
        fileInput.prop('required', !hasFile && !hasUrl);
    }

    // Add Image Card
    $("#addImage").click(function() {
        $('#imageWrapper').append(cardTemplate);
    });

    // Remove logic
    $(document).on('click', '.remove-btn', function() {
        $(this).closest('.dynamic-row, .image-card').fadeOut(200, function() { $(this).remove(); });
    });

    // Image file preview + requirement sync
    $(document).on('change', '.img-input', function() {
        const card = $(this).closest('.image-card');
        const input = this;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { updatePreview(card, e.target.result); };
            reader.readAsDataURL(input.files[0]);
        } else if (!card.find('.img-url-input').val().trim()) {
            updatePreview(card, '');
        }
        syncRequirement(card);
    });

    // URL preview + requirement sync
    $(document).on('input', '.img-url-input', function() {
        const card = $(this).closest('.image-card');
        const url = $(this).val().trim();
        if (url && isValidUrl(url)) {
            updatePreview(card, url);
        } else {
            const fileInput = card.find('.img-input')[0];
            const hasFile = fileInput && fileInput.files && fileInput.files.length;
            if (!hasFile) {
                updatePreview(card, '');
            }
        }
        syncRequirement(card);
    });
});