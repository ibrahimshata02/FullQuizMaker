<?php
global $wpdb;
$table_name = $wpdb->prefix . 'polls_psx_polls';
$statuses = array('active', 'inactive'); // List of statuses to display
$polls = $wpdb->get_results("SELECT * FROM $table_name WHERE status IN ('" . implode("','", $statuses) . "')");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Survey</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<style>
    .gray-row:nth-child(even) {
        background-color: rgba(250, 250, 250, 0.9) !important;
    }

    thead {
        background-color: #EEE !important;
    }

    thead tr th {
        font-weight: 900;
        color: #111 !important;
    }
</style>


<body>
    <main class="position-relative container-fluid">
        <div class="col-lg-12 col-xxl-10 py-6">
            <div class="position-relative d-flex flex-column align-items-center justify-content-center p-5 bg-white border rounded-3 mb-6  col-12 mx-auto">
                <img class="rounded-circle border shadow-sm" src="https://source.unsplash.com/featured/300x201" width="130" height="130" alt="">
                <h3 class="m-0 mt-3">Yousef Abu Aisha</h3>
                <p style="font-size: 14px;" class="m-0">yousef.aboesha@hotmail.com</p>
                <h5 class="m-0 mt-2">Level 3</h5>
            </div>


            <div class="mb-6">
                <div class="w-100 pb-0 d-flex align-items-center justify-content-between mb-4">
                    <h4 class="fw-bolder m-0 p-0 ">Upcoming quizzes</h4>
                    <a href="<?php echo admin_url('admin.php?page=RecentQuizzes+page'); ?>" class="btn btn-dark m-0 p-3">Recent quizzes
                        <i style="cursor: pointer" class="fa-solid fa-share text-white ms-2"></i>
                    </a>
                </div>

                <div class="row row row-cols-1 row-cols-lg-2 g-2">
                    <!-- Quiz card -->
                    <div class="col">
                        <div class="bg-white d-flex flex-column border rounded-3 p-4 gap-1">
                            <h4>Math Quiz</h4>
                            <p class="m-0">A random question is not a question type as such, but is a way of inserting a randomly-chosen question from a specified category into a quiz.This means that different students are likely to get a different selection of questions, and when a quiz allows multiple attempts then each attempt is likely to contain a new selection of questions. </p>

                            <div style="font-size: 15px;" class="d-flex flex-column gap-1 mt-3 fw-bold text-dark">
                                <div class="d-flex align-items-center fw-bold gap-2 ">
                                    <span>Duration:</span>
                                    <span> 15 mins <i class="fa-regular fa-clock ms-2 fa-md text-unset"></i> </span>
                                </div>

                                <div class="d-flex align-items-center fw-bold gap-2 ">
                                    <span>Number of questions:</span>
                                    <span> 20 <i class="fa-regular fa-circle-question ms-2 fa-md"></i> </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 ">
                                    <span>Starts:</span>
                                    <span class="text-success"> <?php echo date("d,M Y - H:i:s") ?> </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 ">
                                    <span>Ends:</span>
                                    <span class="text-danger"> <?php echo date("d,M Y - H:i:s") ?> </span>
                                </div>
                            </div>

                            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>" class="btn btn-primary p-3 m-0 mt-4">Attempt Now
                                <i class="fa-solid fa-arrow-right text-white ms-2 fa-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quiz card -->
                    <div class="col">
                        <div class="bg-white d-flex flex-column border rounded-3 p-4 gap-1">
                            <h4>Science Quiz</h4>
                            <p class="m-0">A random question is not a question type as such, but is a way of inserting a randomly-chosen question from a specified category into a quiz.This means that different students are likely to get a different selection of questions, and when a quiz allows multiple attempts then each attempt is likely to contain a new selection of questions. </p>

                            <div style="font-size: 15px;" class="d-flex flex-column gap-1 mt-3 fw-bold text-dark">
                                <div class="d-flex align-items-center fw-bold gap-2 ">
                                    <span>Duration:</span>
                                    <span> 15 mins <i class="fa-regular fa-clock ms-2 fa-md text-unset"></i> </span>
                                </div>

                                <div class="d-flex align-items-center fw-bold gap-2 ">
                                    <span>Number of questions:</span>
                                    <span> 20 <i class="fa-regular fa-circle-question ms-2 fa-md"></i> </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 ">
                                    <span>Starts:</span>
                                    <span class="text-success"> <?php echo date("d,M Y - H:i:s") ?> </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 ">
                                    <span>Ends:</span>
                                    <span class="text-danger"> <?php echo date("d,M Y - H:i:s") ?> </span>
                                </div>
                            </div>

                            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>" class="btn btn-primary p-3 m-0 mt-4">Attempt Now
                                <i class="fa-solid fa-arrow-right text-white ms-2 fa-lg"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Copy shortcode -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var pollInputs = document.querySelectorAll(".pollInput");

            pollInputs.forEach(input => {
                input.addEventListener("click", function() {
                    input.select(); // Select the input content
                    document.execCommand("copy"); // Copy the selected content to clipboard

                    // Create a new toast element
                    var toast = document.createElement("div");
                    toast.style = "z-index:1000; right: 10px; bottom: 10px";
                    toast.className = "position-fixed p-2 px-4 bg-primary border rounded-2";
                    toast.innerHTML = `
                    <p class="m-0 fw-bold text-xs text-white">
                       Shortcode copied successfully!
                    </p>
                `;
                    // Append the toast to the document
                    document.body.appendChild(toast);

                    // Initialize the Bootstrap toast
                    var bootstrapToast = new bootstrap.Toast(toast, {
                        autohide: true, // Set to true to enable automatic hiding
                        delay: 2000,
                    });
                    bootstrapToast.show();
                });
            });
        });
    </script>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0">
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="p-2 m-0">
                        Are you sure you want to move this survey to trash?
                    </p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer d-flex justify-content-start">
                    <button id="confirm_delete" type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" id="moveButton">
                        Move
                        <i class="fas fa-trash text-xs text-white m-1"></i>
                    </button>
                    <button type="button" class="btn bg-transparent text-danger border-danger shadow-none border" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let rowsCount = document.querySelector("tr[data-count]").getAttribute("data-count")
            console.log(rowsCount);

            const archiveButtons = document.querySelectorAll(".archiveButton");
            let id;
            archiveButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    const row = event.target.closest("tr"); // Find the closest row element
                    const dataCardId = row.getAttribute("data-card-id");
                    id = dataCardId;
                });
            });

            const confirm_delete = document.getElementById("confirm_delete")
            // Delete button
            confirm_delete.addEventListener("click", () => {
                jQuery.ajax({
                    url: my_ajax_object.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'PSX_archive_poll',
                        poll_id: id
                    },
                    success: function() {
                        const archivedPollId = parseInt(
                            id); // Parse the poll_id from the response
                        const rowToRemove = document.querySelector(
                            `tr[data-card-id="${archivedPollId}"]`);

                        // Create a new toast element
                        var toast = document.createElement("div");
                        toast.style = "z-index:1000; right: 10px; bottom: 10px";
                        toast.className = "position-fixed p-2 px-4 bg-danger border rounded-2";
                        toast.innerHTML = `
                            <p class="m-0 fw-bold text-xs text-white">
                            Survey moved to trash successfully!
                            </p>
                        `;
                        // Append the toast to the document
                        document.body.appendChild(toast);

                        // Initialize the Bootstrap toast
                        var bootstrapToast = new bootstrap.Toast(toast, {
                            autohide: true, // Set to true to enable automatic hiding
                            delay: 2000,
                        });
                        bootstrapToast.show();

                        if (rowToRemove) {
                            rowsCount--;
                            if (rowsCount <= 0) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500)
                            }
                            rowToRemove.remove(); // Remove the row from the table
                            console.log("Minus count", rowsCount);
                        } else {
                            console.log(`Row with data-card-id ${archivedPollId} not found.`);
                        }
                    },
                    error: function(errorThrown) {
                        console.log(errorThrown);
                    }
                });
            })
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            const pollsPerPage = 10;
            let currentPage = 1;
            const rows = jQuery('.gray-row');
            const totalRows = rows.length;

            function displayRows() {
                rows.hide(); // Hide all rows
                const startIndex = (currentPage - 1) * pollsPerPage;
                const endIndex = startIndex + pollsPerPage;

                for (let i = startIndex; i < endIndex && i < totalRows && i < startIndex + pollsPerPage; i++) {
                    rows.eq(i).show(); // Show the rows for the current page
                }

                jQuery('#currentPage').text(`Page ${currentPage}`);

                // Disable "Previous" button if on the first page
                jQuery('#prevPage').prop('disabled', currentPage === 1);

                // Disable "Next" button if on the last page
                const totalPages = Math.ceil(totalRows / pollsPerPage);
                jQuery('#nextPage').prop('disabled', currentPage === totalPages || totalRows === 0);
            }

            displayRows();

            jQuery('#prevPage').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    displayRows();
                }
            });

            jQuery('#nextPage').on('click', function() {
                const totalPages = Math.ceil(totalRows / pollsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    displayRows();
                }
            });
        });
    </script>

</body>