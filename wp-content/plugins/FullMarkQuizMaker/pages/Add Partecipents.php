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
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div class="col mt-3">
                <label class="form-label"> Select Template File</label>
                <select id="studyLevel" class="form-control border bg-white p-2" aria-label="Template File select">
                    <option value="Defult">Defult</option>
                    <option value="Unrwa">Unrwa</option>
                </select>
                <span class="error_message fw-bold text-danger d-none"></span>

            </div>

            <div class="mt-3 col-6">
                <label for="file">Add students using File</label>
                <input class="form-control border p-2" type="file" name="file" accept=".xlsx, .xls">
                <span class="error_message fw-bold text-danger d-none"></span>

            </div>


            <div class="d-flex flex-row  align-items-center gap-3 mt-4">
                <button class="btn btn-dark shadow-none border m-0" id="import_data" type="button" name="import_data">
                    Import data
                    <i class="fa-solid fa-file-import fa-lg ms-2 text-white"></i>
                </button>

                <div class="d-flex flex-row align-items-center gap-2">
                    or you can just <a class="text-primary fw-bolder" id="download" type="button" name="import_data">download</a> the Excel file template
                </div>
            </div>
            <button id="save_button" class="btn btn-primary mt-6 w-25 p-3">Save </button>
        </form>

        <script>
            const nonce = document.querySelector("#my-ajax-nonce").value;
            const form = document.querySelector("form");
            const save_button = document.getElementById("save_button");
            const download = document.getElementById("download");
            const import_data_button = document.getElementById("import_data");

            form.addEventListener("submit", (e) => {
                e.preventDefault(); // Prevent the default form submission behavior
                // Add your form validation logic here
            });

            save_button.addEventListener("click", (e) => {
                e.preventDefault();
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
            })



            save_button.click(function() {
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