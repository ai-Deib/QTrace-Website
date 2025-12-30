$(document).ready(function() {
        $("#addSkill").click(function() {
            let field = `
                <div class="input-group mb-2 animate-fadeIn">
                    <input type="text" name="expertise[]" class="form-control" placeholder="Enter skill">
                    <button class="btn btn-danger bg-color-secondary remove-row" type="button">Remove</button>
                </div>`;
            $('#skillWrapper').append(field);
        });

        $(document).on('click', '.remove-row', function() {
            $(this).parent().remove();
        });
    });