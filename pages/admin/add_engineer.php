

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QTrace Contractor Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">QTrace Contractor Registration</h4>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-flex justify-content-between">
                                Areas of Expertise
                                <button type="button" id="addExpertise" class="btn btn-sm btn-outline-success">+ Add More</button>
                            </label>
                            <div id="expertiseContainer">
                                <div class="input-group mb-2">
                                    <input type="text" name="expertise[]" class="form-control" placeholder="e.g. Electrical" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Dynamic Field Logic
    $(document).ready(function() {
        $("#addExpertise").click(function() {
            var html = '<div class="input-group mb-2">' +
                       '<input type="text" name="expertise[]" class="form-control" placeholder="Expertise">' +
                       '<button class="btn btn-outline-danger removeBtn" type="button">×</button>' +
                       '</div>';
            $('#expertiseContainer').append(html);
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.input-group').remove();
        });
    });
</script>

</body>
</html>