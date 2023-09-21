<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>



<body>
    <main class="col-lg-7 col-md-8 col-11 main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">
        <h3 class="mb-4">Add Students</h3>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="my-ajax-nonce" value="<?php echo wp_create_nonce('my_ajax_nonce'); ?>" />

            <div class="col mt-3">
                <label class="form-label">Study Level</label>
                <select id="studyLevel" class="form-control border bg-white p-2" aria-label="Study level select">
                    <option selected value="1">A </option>
                    <option value="2">B</option>
                </select>
            </div>

            <div class="col mt-3">
                <label class="form-label"> Select Template File</label>
                <select id="studyLevel" class="form-control border bg-white p-2" aria-label="Template File select">
                    <option value="Defult">Defult</option>
                    <option value="Unrwa">Unrwa</option>
                </select>
            </div>

            <div class="mt-3 col-6">
                <label for="file">Add students using File</label>
                <input class="form-control border p-2" type="file" name="file" accept=".xlsx, .xls" required>
            </div>


            <div class="d-flex flex-row  align-items-center gap-3 mt-4">
                <button class="btn btn-white shadow-none border m-0" id="submit" type="button" name="import_data">
                    Import data
                    <i class="fa-solid fa-file-import fa-xl ms-2"></i>
                </button>

                <div class="d-flex flex-row align-items-center gap-2">
                    or you can just <a class="text-primary fw-bolder" id="download" type="button" name="import_data">download</a> the Excel file template
                </div>
            </div>
            <button class="btn btn-primary mt-6 w-25 p-3">Save </button>
        </form>


        <script>
            var nonce = jQuery("#my-ajax-nonce").val();
            var button = jQuery("#submit");
            var download = jQuery("#download");
            download.click(function() {
                var formData = new FormData();
                formData.append("action", "FQM_download_default_template");
                jQuery.ajax({
                    type: "POST",
                    url: my_ajax_object.ajaxurl,
                    data: formData,
                    processData: false, // Important: prevent jQuery from processing the data
                    contentType: false, // Important: prevent jQuery from setting contentType
                    success: function(response) {
                        console.log(response);
                    },
                });
            });
            button.click(function() {
                var formData = new FormData();
                formData.append("action", "FQM_importStudentDataFromExcel");
                formData.append("nonce", nonce);
                formData.append("file", jQuery('input[type="file"]')[0].files[0]);
                formData.append("year", jQuery('input[name="year"]').val());
                formData.append("level", jQuery('input[name="level"]').val());
                formData.append("type", jQuery('select[name="type"]').val());
                jQuery.ajax({
                    type: "POST",
                    url: my_ajax_object.ajaxurl,
                    data: formData,
                    processData: false, // Important: prevent jQuery from processing the data
                    contentType: false, // Important: prevent jQuery from setting contentType
                    success: function(response) {
                        console.log(response);
                    },
                });
            });
        </script>

    </main>
</body>