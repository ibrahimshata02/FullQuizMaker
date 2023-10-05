<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<body>
    <main class="col-lg-7 col-md-8 col-11 main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">
        <!-- Start-- Add new teacher  -->
        <h2><?php _e('Add new teacher', 'Full-Mark-Quiz-Maker'); ?></h2>
        <div class="d-flex flex-column gap-2 mt-3">
            <div>
                <label>Enter teacher ID</label>
                <input id="teacher_id" type="text" class="form-control border p-2 " placeholder="<?php _e('Enter the teacher ID', 'Full-Mark-Quiz-Maker'); ?>" />
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div>
                <label>Enter teacher name</label>
                <input id="teacher_name" type="text" class="form-control border p-2" placeholder="<?php _e('Enter the teacher Name', 'Full-Mark-Quiz-Maker'); ?>" />
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div>
                <label>Enter teacher email</label>
                <input id="teacher_email" type="text" class="form-control border p-2" placeholder="<?php _e('Enter the teacher Email', 'Full-Mark-Quiz-Maker'); ?>" />
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>

            <div>
                <label>Enter teacher level</label>
                <select id="teacher_level" class="form-control border bg-white p-2" aria-label="study year select">
                    <option selected disabled value=""><?php _e('Select study year', 'Full-Mark-Quiz-Maker'); ?></option>
                    <option value="1"><?php _e('first', 'Full-Mark-Quiz-Maker'); ?></option>
                    <option value="2"><?php _e('second', 'Full-Mark-Quiz-Maker'); ?></option>

                </select>
                <span class="error_message fw-bold text-danger d-none"></span>
            </div>
            <div class="d-flex flex-row align-items-center gap-1">
                <?php _e('Or you can add multiple teachers by', 'Full-Mark-Quiz-Maker'); ?> <a id="import_data" class="text-dark fw-bolder" type="button" data-bs-toggle="modal" data-bs-target="#upload-file-modal"><?php _e('Importing', 'Full-Mark-Quiz-Maker'); ?></a> <?php _e('an Excel file.', 'Full-Mark-Quiz-Maker'); ?>
            </div>
        </div>
        <button id="save_btn_1" class="btn btn-primary mt-4 w-25 p-3"><?php _e('Save', 'Full-Mark-Quiz-Maker'); ?> </button>
        <!-- End-- Add new teacher  -->

        <div class="modal fade " id="upload-file-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">

                    <h4><?php _e('Upload Excel file', 'Full-Mark-Quiz-Maker'); ?></h4>

                    <div class="d-flex flex-column gap-3 mt-3">
                        <div>
                            <input id="formFile" class="form-control p-2" type="file" accept=".xls, .xlsx">
                            <span class="error_message fw-bold text-danger d-none"></span>
                        </div>

                        <div class="row row row-cols-1 row-cols-lg-2 g-3">
                            <div class="col">
                                <label class="form-label"><?php _e('ID column', 'Full-Mark-Quiz-Maker'); ?></label>
                                <input id="id_col" type="text" class="form-control border p-2" placeholder="<?php _e('ID column', 'Full-Mark-Quiz-Maker'); ?>" />
                                <span class="error_message fw-bold text-danger d-none"></span>
                            </div>

                            <div class="col">
                                <label class="form-label"><?php _e('Name column', 'Full-Mark-Quiz-Maker'); ?></label>
                                <input id="name_col" type="text" class="form-control border p-2" placeholder="<?php _e('Name column', 'Full-Mark-Quiz-Maker'); ?>" />
                                <span class="error_message fw-bold text-danger d-none"></span>

                            </div>

                            <div class="col">
                                <label class="form-label"><?php _e('Email column', 'Full-Mark-Quiz-Maker'); ?></label>
                                <input id="email_col" type="text" class="form-control border p-2" placeholder="<?php _e('Email column', 'Full-Mark-Quiz-Maker'); ?>" />
                                <span class="error_message fw-bold text-danger d-none"></span>

                            </div>

                            <div class="col">
                                <label class="form-label"><?php _e('Level column', 'Full-Mark-Quiz-Maker'); ?></label>
                                <input id="level_col" type="text" class="form-control border p-2" placeholder="<?php _e('Level column', 'Full-Mark-Quiz-Maker'); ?>" />
                                <span class="error_message fw-bold text-danger d-none"></span>

                            </div>
                        </div>

                        <div style="font-size: 11px;" class="d-flex flex-column">
                            <b><?php _e('Notice: add the column values according to your Excel file data.', 'Full-Mark-Quiz-Maker'); ?> </b>
                            <b><?php _e('For example: If the Name in your Excel file is in the A column, then write A in the Name column input', 'Full-Mark-Quiz-Maker'); ?> </b>
                        </div>
                    </div>

                    <button id="upload_btn" type="button" class="btn btn-primary w-100 mt-4">Upload <i class="fas fa-file-excel fa-lg ms-1 text-white"></i> </button>
                </div>
            </div>
        </div>
        <script>
            const save_btn_1 = document.getElementById("save_btn_1");

            save_btn_1.addEventListener("click", (e) => {
                e.preventDefault();
                const teacher_id = document.getElementById("teacher_id");
                const teacher_name = document.getElementById("teacher_name");
                const teacher_email = document.getElementById("teacher_email");
                const teacher_level = document.getElementById("teacher_level");


                validateInput(teacher_id, teacher_id.nextElementSibling, "Please enter the teacher ID", teacher_id.value !== "");
                validateInput(teacher_name, teacher_name.nextElementSibling, "Please enter the teacher name", teacher_name.value !== "");
                validateInput(teacher_email, teacher_email.nextElementSibling, "Please enter the teacher email", teacher_email.value !== "");
                validateInput(teacher_level, teacher_level.nextElementSibling, "Please enter the teacher level", teacher_level.value !== "");

                const allInputsAreValid = validateInput(teacher_id, teacher_id.nextElementSibling, "Please enter the teacher ID", teacher_id.value !== "") &&
                    validateInput(teacher_name, teacher_name.nextElementSibling, "Please enter the teacher name", teacher_name.value !== "") &&
                    validateInput(teacher_email, teacher_email.nextElementSibling, "Please enter the teacher email", teacher_email.value !== "") &&
                    validateInput(teacher_level, teacher_level.nextElementSibling, "Please enter the teacher level", teacher_level.value !== "");

                if (!allInputsAreValid) return;

                if (allInputsAreValid) {
                    const teacherObj = {
                        teacherId: teacher_id.value,
                        teacherName: teacher_name.value,
                        teacherEmail: teacher_email.value,
                        teacherLevel: teacher_level.value
                    }
                    console.log("Teacher objects", teacherObj);
                }
            })

            const uploadButton = document.getElementById("upload_btn");
            const fileInput = document.getElementById("formFile");
            const id_col = document.getElementById("id_col");
            const name_col = document.getElementById("name_col");
            const email_col = document.getElementById("email_col");
            const level_col = document.getElementById("level_col");

            uploadButton.addEventListener("click", (e) => {
                e.preventDefault();
                let fileExtension;

                if (fileInput.files[0]) {
                    fileExtension = fileInput.split('.').pop().toLowerCase();
                }

                validateInput(fileInput, fileInput.nextElementSibling, "Please upload an Excel file", fileInput.value !== "");
                validateInput(id_col, id_col.nextElementSibling, "Please enter the ID column", id_col.value !== "");
                validateInput(name_col, name_col.nextElementSibling, "Please enter the Name column", name_col.value !== "");
                validateInput(email_col, email_col.nextElementSibling, "Please enter the Email column", email_col.value !== "");
                validateInput(level_col, level_col.nextElementSibling, "Please enter the Level column", level_col.value !== "");

                const allInputsAreValid = validateInput(fileInput, fileInput.nextElementSibling, "Please upload an Excel file", (fileInput.value !== "" && (fileExtension === 'xlsx' || fileExtension === 'xls'))) && validateInput(id_col, id_col.nextElementSibling, "Please enter the ID column", id_col.value !== "") &&
                    validateInput(name_col, name_col.nextElementSibling, "Please enter the Name column", name_col.value !== "") &&
                    validateInput(email_col, email_col.nextElementSibling, "Please enter the Email column", email_col.value !== "") &&
                    validateInput(level_col, level_col.nextElementSibling, "Please enter the Level column", level_col.value !== "");

                if (!allInputsAreValid) return;

                if (allInputsAreValid) {
                    const excel_obj = {
                        file: fileInput.files[0],
                        teacherIdCol: id_col.value,
                        teacherNameCol: name_col.value,
                        teacherEmailCol: email_col.value,
                        teacherLevelCol: level_col.value
                    }
                    console.log("Excel object", excel_obj);
                }

            })
        </script>
    </main>
</body>