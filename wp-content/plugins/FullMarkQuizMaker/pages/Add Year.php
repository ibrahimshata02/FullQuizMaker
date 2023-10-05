<?php
global $wpdb;
$table_name = $wpdb->prefix . 'FQM_level';
$table_year = $wpdb->prefix . 'FQM_year';
$current_year_value = get_option('FQM_current_year');
$levels = $wpdb->get_results("SELECT Level FROM $table_name WHERE year_id = (SELECT year_id FROM $table_year WHERE year_title='$current_year');");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<body>
    <main class="col-lg-7 col-md-8 col-11 main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">
        <h3 class="mb-4"> <?php _e('Initial data', 'Full-Mark-Quiz-Maker'); ?></h3>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="my-ajax-nonce" value="<?php echo wp_create_nonce('my_ajax_nonce'); ?>" />

            <div class="col mt-3">
                <label class="form-label"><?php _e('Current study year', 'Full-Mark-Quiz-Maker'); ?></label>
                <select id="study_year_input" class="form-control border bg-white p-2" aria-label="study year select">
                    <option selected disabled value=""><?php _e('Select study year', 'Full-Mark-Quiz-Maker'); ?></option>
                    <?php
                    // Define a range of years, such as from 2000 to the current year
                    $currentYear = date("Y");
                    $startYear = 2022;

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
                <label class="form-label"><?php _e('Add study Levels for this year', 'Full-Mark-Quiz-Maker'); ?></label>
                <input id="study_level_input" type="text" class="form-control border p-2" placeholder="Add study levels fot the current year | press enter to add" />
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-2">
                <?php _e('Example:', 'Full-Mark-Quiz-Maker'); ?> <div id="study_level_card" class="position-relative bg-dark rounded-3 p-1 px-3 border">
                    <p class="m-0 text-white" style="font-size: 12px;"><?php _e('Level 1', 'Full-Mark-Quiz-Maker'); ?></p>
                </div>

                <div id="study_levels_container" style="width: fit-content;" class="d-flex align-items-center flex-wrap gap-2">

                </div>
            </div>

            <button id="save_btn" class="btn btn-primary mt-4 w-25 p-3"><?php _e('Save', 'Full-Mark-Quiz-Maker'); ?> </button>
        </form>


        <script>
            const study_level_input = document.getElementById("study_level_input");
            const study_levels_container = document.getElementById("study_levels_container");
            let finalObj = {}

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
            const file_input = document.getElementById("file_input");

            form.addEventListener("submit", (e) => {
                e.preventDefault(); // Prevent the default form submission behavior

                // Validate the inputs
                validateInput(study_year_input, study_year_input.nextElementSibling, "Please select the study year", study_year_input.value !== "");
                validateInput(study_level_input, study_level_input.nextElementSibling, "Please add at least two study levels", study_levels_container.children.length >= 2);


                // Check if all inputs are valid
                const allInputsAreValid = validateInput(study_year_input, study_year_input.nextElementSibling, "Please select the study year", study_year_input.value !== "") &&
                    validateInput(study_level_input, study_level_input.nextElementSibling, "Please add at least two study levels", study_levels_container.children.length >= 2);

                // If not all inputs are valid, stop the function
                if (!allInputsAreValid) return;

                if (allInputsAreValid) {
                    // Send the AJAX request
                    var formData = new FormData();
                    const studyLevels = [];
                    for (let i = 0; i < study_levels_container.children.length; i++) {
                        studyLevels.push(study_levels_container.children[i].children[1].textContent);
                    }

                    finalObj = {
                        studyYear: study_year_input.value,
                        studyLevels: studyLevels
                    }

                    console.log("Final objects", finalObj);
                    jQuery.ajax({
                        type: "POST",
                        url: my_ajax_object.ajaxurl,
                        data: {
                            action: "FQM_Add_Year_And_Levels",
                            nonce: nonce,
                            data: JSON.stringify(finalObj),
                        },
                        success: function(response) {
                            console.log(response.data);
                            if (response.data === "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Study year saved successfully',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong, please try again',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
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
        </script>

    </main>
</body>