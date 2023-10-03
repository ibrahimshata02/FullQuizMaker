<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<body>
    <main class="col-lg-7 col-md-8 col-11 main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">
        <h3 class="mb-4">Initial data</h3>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="my-ajax-nonce" value="<?php echo wp_create_nonce('my_ajax_nonce'); ?>" />

            <div class="col mt-3">
                <label class="form-label">Current study year</label>
                <select id="study_year_input" class="form-control border bg-white p-2" aria-label="study year select">
                    <option selected disabled value="">Select study year</option>
                    <?php
                    // Define a range of years, such as from 2000 to the current year
                    $currentYear = date("Y");
                    $startYear = 2010;

                    // Loop to generate options for each year in the range
                    for ($year = $startYear; $year <= $currentYear; $year++) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <!-- Adding the study level card when the user press enter - must at least two levels -->
            <div class="col mt-3">
                <label class="form-label">Add study Levels for this year</label>
                <input id="study_level_input" type="text" class="form-control border p-2" placeholder="Add study levels fot the current year | press enter to add" />
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-2">
                Example: <div id="study_level_card" class="position-relative bg-dark rounded-3 p-1 px-3 border">
                    <p class="m-0 text-white" style="font-size: 12px;">Class A</p>
                </div>

                <div id="study_levels_container" style="width: fit-content;" class="d-flex align-items-center flex-wrap gap-2">

                </div>
            </div>

            <div class="col mt-3">
                <label class="form-label"> Select Template File</label>
                <select id="template_select" class="form-control border bg-white p-2" aria-label="Template File select">
                    <option selected disabled value="">Select Template File</option>
                    <option value="Default">Default</option>
                    <option value="Unrwa">Unrwa</option>
                </select>
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>


            <div class="d-flex flex-row flex-wrap align-items-center gap-2 mt-4">
                <button class="btn btn-dark shadow-none text-white border m-0" id="submit" type="button" name="import_data" data-bs-toggle="modal" data-bs-target="#add-teacher-modal">
                    Add teacher
                    <i class="fa-solid fa-add text-white fa-md ms-2"></i>
                </button>

                <div class="d-flex flex-row align-items-center gap-1">
                    or you can add multiple teachers by <a id="import_data" class="text-dark fw-bolder" type="button" data-bs-toggle="modal" data-bs-target="#upload-file-modal">Importing</a> an Excel file.
                </div>
            </div>
            <button id="save_btn" class="btn btn-primary mt-6 w-25 p-3">Save </button>
        </form>

        <!-- Modal -->
        <div class="modal fade " id="add-teacher-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <i class="fa-solid fa-book-bookmark text-center text-dark" style="font-size:35px"></i>
                    <h4 class="modal-title text-center mt-2" id="exampleModalLabel">Add new teacher</h4>

                    <input type="text" class="form-control border p-2 mt-4" placeholder="Enter the teacher email" />

                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary w-100 mt-2">ADD <i class="fas fa-add fa-md ms-1 text-white"></i> </button>
                </div>
            </div>
        </div>

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
            const study_level_input = document.getElementById("study_level_input");
            const study_levels_container = document.getElementById("study_levels_container");

            // Add the study level card when the user press enter
            study_level_input.addEventListener("keydown", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    if (study_level_input.value !== "") {
                        const study_level_card = document.createElement("div")
                        study_level_card.className = "position-relative bg-dark rounded-3 p-1 px-3 border";
                        study_level_card.innerHTML = ` <i class="fas fa-times text-danger bg-white position-absolute p-1 d-flex justify-content-center align-items-center rounded-3 cursor-pointer" style="left: -5px; top: -5px; font-size: 10px;"></i>
                         <p class="m-0 text-white" style="font-size: 13px;">${study_level_input.value}</p> `;;

                        study_levels_container.appendChild(study_level_card);
                        study_level_input.value = "";
                    }
                }
            });

            // Remove the study level card when the user click on the X icon
            study_levels_container.addEventListener("click", (e) => {
                if (e.target.classList.contains("fa-times")) {
                    e.target.parentElement.remove();
                }
            });

            const nonce = document.getElementById("my-ajax-nonce").value;
            const form = document.querySelector("form");
            const download_btn = document.getElementById("download");
            const save_btn = document.getElementById("save_btn");

            const study_year_input = document.getElementById("study_year_input");
            const template_select = document.getElementById("template_select");
            const file_input = document.getElementById("file_input");

            form.addEventListener("submit", (e) => {
                e.preventDefault(); // Prevent the default form submission behavior
                // Add your form validation logic here
            });


            download_btn.click(function() {
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

            function validateInput(inputElement, errorMessageElement, errorMessage, isValid) {
                let flag = true
                if (!isValid) {
                    errorMessageElement.style.cssText = "display: block !important; font-size: 11px !important";
                    errorMessageElement.textContent = errorMessage;
                    inputElement.style.cssText = "border: 1px solid red !important";
                    flag = false;
                } else {
                    errorMessageElement.style.cssText = "display: none !important";
                    inputElement.style.cssText = "border: 1px solid #ced4da !important";
                }
                return flag;
            }

            save_btn.addEventListener("click", (e) => {
                e.preventDefault();

                // Validate the inputs
                validateInput(study_year_input, study_year_input.nextElementSibling, "Please select the study year", study_year_input.value !== "");
                validateInput(study_level_input, study_level_input.nextElementSibling, "Please add at least two study levels", study_levels_container.children.length >= 2);
                validateInput(template_select, template_select.nextElementSibling, "Please select the template file", template_select.value !== "");


                // Check if all inputs are valid
                const allInputsAreValid = validateInput(study_year_input, study_year_input.nextElementSibling, "Please select the study year", study_year_input.value !== "") &&
                    validateInput(study_level_input, study_level_input.nextElementSibling, "Please add at least two study levels", study_levels_container.children.length >= 2) &&
                    validateInput(template_select, template_select.nextElementSibling, "Please select the template file", template_select.value !== "");


                // If not all inputs are valid, stop the function
                if (!allInputsAreValid) return;


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
            })
        </script>

    </main>
</body>