<?php
global $wpdb;
$table_name = $wpdb->prefix . 'polls_psx_polls';
$statuses = array('active', 'inactive'); // List of statuses to display
$polls = $wpdb->get_results("SELECT * FROM $table_name WHERE status IN ('" . implode("','", $statuses) . "')");

// Status color function
function statusColor($status)
{
    if ($status == 'active') {
        return 'success';
    } elseif ($status == 'inactive') {
        return 'warning';
    } else {
        return 'danger';
    }
}
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
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1">
        <div class="container-fluid py-4">
            <div class="py-4">
                <div class="row">
                    <div class="col-lg-12 col-xxl-10">

                        <div class=" w-100 pb-0 d-flex align-items-center justify-content-between mb-6">
                            <h4 class="fw-bolder col-4 m-0 p-0">Class students</h4>

                            <div class="d-flex gap-2 align-items-center m-0 p-0">
                                <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>" class="btn btn-primary m-0">Export data
                                    <i class="fa-solid fa-download fa-lg text-white ms-2"></i>
                                </a>
                                <a href="<?php echo (admin_url('admin.php?page=poll-survey-xpress-recycle')); ?>" class="btn btn-dark m-0">Import data <i class="fa-solid fa-file-arrow-up fa-lg text-white ms-2"></i> </a>
                            </div>
                        </div>

                        <div class="p-0 pt-0 border rounded-3 w-100">
                            <div class="table-responsive p-0 bg-white rounded-3">
                                <table class="table align-items-center m-0 col-lg-12 col-xxl-10 rounded-3">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-center text-xxs text-center py-4">
                                                ID
                                            </th>

                                            <th class="text-uppercase text-center text-xxs py-4">
                                                Name
                                            </th>

                                            <th class="text-uppercase text-xxs text-center py-4">
                                                Level
                                            </th>

                                            <th class="text-uppercase text-xxs text-center py-4">
                                                Email
                                            </th>

                                            <th class=" text-uppercase text-xxs text-center py-4">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (empty($polls)) { ?>
                                            <tr>
                                                <td colspan="7" class="text-xss text-center py-4">No surveys found,<a class="text-primary ms-1 fw-bold" href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>">add new record</a></td>
                                            </tr>
                                        <?php } else { ?>
                                            <?php
                                            $index = 0; // Initialize index
                                            $reversedPolls = array_reverse($polls);
                                            foreach ($reversedPolls as $poll) {
                                            ?>
                                                <tr data-count=<?php echo count($polls); ?> class="gray-row" id="survey_data" data-card-id=<?php echo $poll->poll_id; ?>>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs m-0">
                                                            <?php echo $poll->poll_id; ?>
                                                        </p>
                                                    </td>

                                                    <td class="align-middle text-center">
                                                        <p title="<?php echo $poll->title; ?>" class="text-xs m-0 text-truncate">
                                                            <?php echo  $poll->title; ?>
                                                        </p>
                                                    </td>

                                                    <td class="align-middle text-center text-xs">
                                                        Seventh
                                                    </td>

                                                    <td class="align-middle text-center text-xs">
                                                        example@gmail.com
                                                    </td>

                                                    <!-- Other dynamic data columns here -->
                                                    <td class="text-center d-flex align-items-center justify-content-center px-0 py-4 gap-lg-3 gap-md-2 gap-1" style="height: 77px;">
                                                        <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-surveys&template=' . $poll->template . '&poll_id=' . $poll->poll_id); ?>" title="Show student details">
                                                            <i class="fas fa-eye text-sm text-dark" style="cursor: pointer"></i>
                                                        </a>
                                                        <i style="cursor: pointer" class="fas fa-trash text-sm text-danger archiveButton" data-bs-toggle="modal" data-bs-target="#deleteModal" data-poll-id="<?php echo $poll->poll_id; ?>" title="Remove student"></i>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mt-4 gap-2" id="pagination">
                        <button class="btn bg-white text-primary shadow-none m-0 border" id="prevPage">Previous</button>
                        <span class="m-0 p-0" id="currentPage">Page 1</span>
                        <button class="btn btn-white text-primary shadow-none m-0 border" id="nextPage">Next</button>
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