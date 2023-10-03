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

            <div class="d-flex flex-column gap-3 mt-4">
                <div>
                    <label class="form-label">Student name</label>
                    <input type="text" class="form-control border p-2" placeholder="Enter student name" />
                </div>

                <div>
                    <label class="form-label">Student email</label>
                    <input type="email" class="form-control border p-2" placeholder="Enter student email " />
                </div>

                <div>
                    <label class="form-label">Study Level</label>
                    <select id="level" class="form-control border bg-white p-2" aria-label="Study level select">
                        <option selected value="1">First </option>
                        <option value="2">Second</option>
                        <option value="3">Third</option>
                    </select>
                    <span class="error_message fw-bold text-danger d-none"></span>
                </div>

                <div>
                    <label class="form-label">Study Class</label>
                    <select id="class" class="form-control border bg-white p-2" aria-label="Study level select">
                        <option selected value="a">A </option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                    </select>
                    <span class="error_message fw-bold text-danger d-none"></span>
                </div>
            </div>

            <button id="save_button" type="button" data-bs-dismiss="modal" class="btn btn-primary col-lg-4 col-md-5 col-8 mt-4 p-3">ADD student <i class="fas fa-add fa-md ms-1 text-white"></i> </button>

            <div class="d-flex flex-row align-items-center gap-1">
                To add multiple students, you can <a id="import_data" class="text-dark fw-bolder" type="button" data-bs-toggle="modal" data-bs-target="#upload-file-modal">Import</a> an Excel file.
            </div>
        </form>

        <div class="modal fade " id="upload-file-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">

                    <h4>Upload Excel file</h4>

                    <div class="d-flex flex-column gap-3 mt-3">
                        <input class="form-control p-2" type="file" id="formFile" accept=".xls, .xlsx">

                        <div class="row row row-cols-1 row-cols-lg-2 g-2">

                            <div class="col">
                                <label class="form-label">ID column</label>
                                <input type="text" class="form-control border p-2" placeholder="ID column" />
                            </div>

                            <div class="col">
                                <label class="form-label">Name column</label>
                                <input type="text" class="form-control border p-2" placeholder="Name column" />
                            </div>
                        </div>

                        <div class="row row row-cols-1 row-cols-lg-2 g-2">
                            <div class="col">
                                <label class="form-label">Level column</label>
                                <input type="text" class="form-control border p-2" placeholder="Level column" />
                            </div>

                            <div class="col">
                                <label class="form-label">Class ID column</label>
                                <input type="text" class="form-control border p-2" placeholder="Class ID column" />
                            </div>
                        </div>

                        <div style="font-size: 11px;" class="d-flex flex-column">
                            <b>Notice: add the column values according to your Excel file data. </b>
                            <b>For example: If the ID in your Excel file is in the A column, then write A in the ID column input </b>
                        </div>
                    </div>

                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary w-100 mt-4">Upload <i class="fas fa-file-excel fa-lg ms-1 text-white"></i> </button>
                </div>
            </div>
        </div>

        <script>
            const nonce = document.querySelector("#my-ajax-nonce").value;
            const form = document.querySelector("form");
            const save_button = document.getElementById("save_button");
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