
<?php
global $wpdb;
$table_name = $wpdb->prefix . 'polls_psx_polls';
$statuses = array('active', 'inactive'); // List of statuses to display
$polls = $wpdb->get_results("SELECT * FROM $table_name WHERE status IN ('" . implode("','", $statuses) . "')");
if ( !current_user_can( 'teacher' ) ) {


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<style>
    .quiz-class:hover {
        border: 2px solid #125b50 !important;
    }
</style>


<body>
    <main class="col-lg-9 col-md-10 col-10 mx-auto main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">

        <!-- Nav buttons -->
        <div class="position-relative bg-white d-flex align-items-center nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link border-right" id="nav-newQuiz-tab" data-bs-toggle="tab" data-bs-target="#nav-newQuiz" role="tab" aria-controls="nav-newQuiz" aria-selected="false"> <?php _e('Profile', 'Full-Mark-Quiz-Maker'); ?>   <i class="fa-solid fa-user ms-2"></i></button>
            <button class="active nav-link border-right" id="nav-quizzes-tab" data-bs-toggle="tab" data-bs-target="#nav-quizzes" role="tab" aria-controls="nav-quizzes" aria-selected="true"><?php _e('My Quizzes', 'Full-Mark-Quiz-Maker'); ?> <i class="fa-regular fa-pen-to-square ms-2"></i></button>
            <button class="nav-link border-right " id="nav-classes-tab" data-bs-toggle="tab" data-bs-target="#nav-classes" role="tab" aria-controls="nav-classes" aria-selected="false"><?php _e('My Classes', 'Full-Mark-Quiz-Maker'); ?>  <i class="fa-solid fa-chalkboard-user ms-2"></i></button>
            
        </div>

        <div class="tab-content" id="nav-tabContent">
            <!-- Recent Quizzes -->
            <div class="tab-pane show active fade mt-5" id="nav-quizzes" role="tabpanel" aria-labelledby="nav-quizzes-tab">
                <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                    <h4 class="m-0"><?php _e('Recent quizzes', 'Full-Mark-Quiz-Maker'); ?> </h4>
                    <a href="<?php echo admin_url('admin.php?page=add-new-quiz'); ?>" class="btn btn-primary m-0"><?php _e('New Quiz', 'Full-Mark-Quiz-Maker'); ?>
                        <i style="cursor: pointer" class="fas fa-add text-white ms-2"></i>
                    </a>
                </div>

                <div class="table-responsive p-0 bg-white mt-3 rounded-3">
                    <table class="table align-items-center m-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-center text-xxs text-center py-4">
                                <?php _e('ID', 'Full-Mark-Quiz-Maker'); ?> 
                                </th>

                                <th class="text-uppercase text-center text-xxs py-4">
                                <?php _e('Title', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class="text-uppercase text-xxs text-center py-4">
                                <?php _e('Status', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class="text-uppercase text-xxs text-center py-4">
                                <?php _e('Level', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class="text-uppercase text-center text-xxs text-center py-4">
                                <?php _e('Participants', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class="text-uppercase text-xxs text-center py-4">
                                                   
                                <?php _e('Start Date', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class=" text-uppercase text-xxs text-center py-4">
                                <?php _e('End Date', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>

                                <th class=" text-uppercase text-xxs text-center py-4">
                                <?php _e('Actions', 'Full-Mark-Quiz-Maker'); ?> 

                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($polls)) { ?>
                                <tr>
                                    <td colspan="7" class="text-xss text-center py-4"> <?php _e('No surveys found,', 'Full-Mark-Quiz-Maker'); ?> <a class="text-primary ms-1 fw-bold" href="<?php echo admin_url('admin.php?page=add-new-quiz'); ?>"> <?php _e('add', 'Full-Mark-Quiz-Maker'); ?> 
                                            new quiz</a></td>
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

                                        <td style="width: 100px;" class="align-middle text-center">
                                            <p title="<?php echo $poll->title; ?>" class="text-xs m-0 text-truncate">
                                                <?php echo  $poll->title; ?>
                                            </p>
                                        </td>

                                        <td class="status-menu align-middle text-center">
                                                        <span id="statusDropDownMenu" class="badge badge-sm dropdown-toggle cursor-pointer status" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php _e('Active', 'Full-Mark-Quiz-Maker'); ?> </span>

                                                        <div class="dropdown-menu shadow-sm border" aria-labelledby="statusDropDownMenu">
                                                            <button class="dropdown-item text-success" type="button" data-status="Active"><?php _e('Activate', 'Full-Mark-Quiz-Maker'); ?> </button>
                                                            <button class="dropdown-item text-danger" type="button" data-status="Inactive"><?php _e('Deactivate', 'Full-Mark-Quiz-Maker'); ?> </button>
                                                        </div>
                                                    </td>

                                        <td class="align-middle text-center">
                                            <p class="text-xs m-0">
                                                <?php echo $poll->template; ?>
                                            </p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <p class="text-xs m-0 text-center">
                                                +150
                                            </p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <p class="text-xs m-0">
                                                <?php echo $poll->end_date; ?>
                                            </p>
                                        </td>

                                        <td class="align-middle text-center">
                                            <p class="text-xs m-0 ">
                                                <?php echo $poll->end_date; ?>
                                            </p>
                                        </td>

                                        <!-- Other dynamic data columns here -->
                                        <td class="text-center d-flex align-items-center justify-content-center px-0 py-4 gap-lg-3 gap-md-2 gap-1" style="height: 70px;">
                                            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-surveys&template=' . $poll->template . '&poll_id=' . $poll->poll_id); ?>">
                                                <i class="fas fa-chart-bar text-sm text-dark" style="cursor: pointer"></i>
                                            </a>
                                            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-surveys&template=' . $poll->template . '&poll_id=' . $poll->poll_id . '&action=edit'); ?>">
                                                <i class="fas fa-gear text-sm text-dark" style="cursor: pointer"></i>
                                            </a>

                                            <i style="cursor: pointer" class="fas fa-trash text-sm text-danger archiveButton" data-bs-toggle="modal" data-bs-target="#deleteModal" data-poll-id="<?php echo $poll->poll_id; ?>"></i>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- classes tab -->
            <div class="tab-pane fade mt-5" id="nav-classes" role="tabpanel" aria-labelledby="nav-classes-tab">
                <h4 class="m-0 mt-2"><?php _e('Assigned classes', 'Full-Mark-Quiz-Maker'); ?> </h4>

                <!-- Classes row -->
                <div class="row row-cols-1 row-cols-lg-2 g-3 mt-3">
                    <div class="position-relative col">
                        <a href="<?php echo admin_url('admin.php?page=Class&Class_id=') ?>">
                            <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                                <h5><?php _e('Class name', 'Full-Mark-Quiz-Maker'); ?></h5> <!-- variable -->
                                <p><?php _e('Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.', 'Full-Mark-Quiz-Maker'); ?>  </p> <!-- variable -->

                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex text-primary align-items-center gap-2">
                                        <i class="fa-regular fa-user fa-sm"></i>
                                        <p class="m-0" style="font-size: 13px;">+187</p> <!-- variable -->
                                    </div>

                                    <div class="d-flex text-primary align-items-center gap-2">
                                        <i class="fa-solid fa-award"></i>
                                        <p class="m-0" style="font-size: 13px;"><?php _e('Excellent', 'Full-Mark-Quiz-Maker'); ?></p><!-- variable -->
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Profile Details tab -->
            <div class="tab-pane fade mt-5" id="nav-newQuiz" role="tabpanel" aria-labelledby="nav-newQuiz-tab">
                <h4 class="m-0 mt-2"> <?php _e('Profile', 'Full-Mark-Quiz-Maker'); ?>  </h4>
                <div class="position-relative d-flex flex-column align-items-center justify-content-center p-5 bg-white border rounded-3 mb-6  col-12 mx-auto">
                <img class="rounded-circle border shadow-sm" src="https://source.unsplash.com/featured/300x201" width="130" height="130" alt="">
                <h3 class="m-0 mt-3">Yousef Abu Aisha</h3>
                <p style="font-size: 14px;" class="m-0">yousef.aboesha@hotmail.com</p>
                <h5 class="m-0 mt-2">Level 3</h5>
            </div>
            <!-- Edit quizzes tab -->
            </main>
            <script>
        // Status color function
        function statusColor(status) {
            if (status === 'Active') {
                return 'success';
            } else if (status === 'Inactive') {
                return 'warning';
            } else {
                return 'danger';
            }
        }

        const statusTexts = document.querySelectorAll(".status");
        statusTexts.forEach(statusText => {
            const status = statusText.textContent;
            if (status === 'Active') {
                statusText.classList.add("bg-gradient-success");
            } else if (status === 'Inactive') {
                statusText.classList.add("bg-gradient-warning");
            } else {
                statusText.classList.add("bg-gradient-danger");
            }
        });

        // Status dropdown
        const statusButtons = document.querySelectorAll(".status-menu .dropdown-item");
        statusButtons.forEach(button => {
            button.addEventListener("click", function() {
                const status = button.getAttribute("data-status");
                const statusMenu = button.closest(".status-menu");
                const statusBtn = statusMenu.querySelector(".status");

                // Update the text and color of the status button
                statusBtn.textContent = status;
                statusBtn.classList.remove("bg-gradient-success", "bg-gradient-warning", "bg-gradient-danger");
                statusBtn.classList.add(`bg-gradient-${statusColor(status)}`);
            });
        });
    </script>
</body>
<?php }?>