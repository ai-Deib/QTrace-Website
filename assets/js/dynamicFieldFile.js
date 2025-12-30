$(document).ready(function() {
    // Add new document row
    $("#addDocument").click(function() {
        let field = `
            <div class=" mb-2 document-row row g-3">
                <div class="col-md-3">
                    <input type="text" name="document_names[]" class="form-control " placeholder="e.g., Contract Agreement" required>
                </div>
                <div class="col-md-9 ">
                <div class="input-group">
                    <input type="file" name="document_files[]" class="form-control" accept="application/pdf" required>
                    <button class="btn btn-danger bg-color-secondary remove-row" type="button">Remove</button>
                    </div>
                </div>
            </div>`;
        $('#documentWrapper').append(field);
    });

    // Remove document row
    $(document).on('click', '.remove-doc', function() {
        $(this).closest('.document-row').remove();
    });
});