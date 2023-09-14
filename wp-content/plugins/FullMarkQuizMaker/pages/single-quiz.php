<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>


<body>
    <main class="col-10 col-11 mx-auto main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">

        <div class="d-flex align-items-center gap-2 my-4">
            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-surveys'); ?>" class="m-0 text-dark">Home</a>
            <i class="fas fa-angle-right"></i>
            <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>" class="m-0 text-dark">Add new
                questions</a>
        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Preview/edit</button>
                <button class="nav-link" id="nav-participants-tab" data-bs-toggle="tab" data-bs-target="#nav-participants" type="button" role="tab" aria-controls="nav-participants" aria-selected="false">participants</button>
                <button class="nav-link active" id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button" role="tab" aria-controls="nav-settings" aria-selected="false">Settings</button>
            </div>
        </nav>

        <div style="height: 500px;" class="tab-content bg-white p-3 border border-top-0" id="nav-tabContent">
            <div class="tab-pane fade p-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...
            </div>
            <div class="tab-pane fade p-4" id="nav-participants" role="tabpanel" aria-labelledby="nav-participants-tab">
                <div class="p-0 pt-0 border rounded-3 w-100">
                    <div class="table-responsive p-0 bg-white rounded-3">
                        <table class="table align-items-center m-0 col-lg-12 col-xxl-10 rounded-3">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-center text-xxs text-center py-4">
                                        ID
                                    </th>

                                    <th class="text-uppercase text-center text-xxs py-4">
                                        Title
                                    </th>

                                    <th class="text-uppercase text-xxs text-center py-4">
                                        Status
                                    </th>

                                    <th class="text-uppercase text-xxs text-center py-4">
                                        Level
                                    </th>

                                    <th class="text-uppercase text-center text-xxs text-center py-4">
                                        Participants
                                    </th>

                                    <th class="text-uppercase text-xxs text-center py-4">
                                        Start Date
                                    </th>

                                    <th class=" text-uppercase text-xxs text-center py-4">
                                        End Date
                                    </th>

                                    <th class=" text-uppercase text-xxs text-center py-4">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (empty($polls)) { ?>
                                    <tr>
                                        <td colspan="7" class="text-xss text-center py-4">No surveys found,<a class="text-primary ms-1 fw-bold" href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>">add
                                                new record</a></td>
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

                                            <td class="align-middle text-center">
                                                <span class="badge badge-sm bg-gradient-<?php echo statusColor($poll->status) ?>">
                                                    <?php echo ucfirst($poll->status); ?>
                                                </span>
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

                                            <td class="text-center d-flex align-items-center justify-content-center px-0 py-4 gap-lg-3 gap-md-2 gap-1" style="height: 77px;">
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
            </div>

            <div class="tab-pane fade show active p-4" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                <h4 class="m-0 mt-2"> Quiz settings</h4>
                <div class="w-100 mt-4">
                    <input type="text" class="col-lg-6 col-12 border p-2" placeholder="Edit Quiz title" value="" />
                    <select id="quizTypeSelect" class="col-lg-6 col-12 border bg-transparent p-2 " aria-label="Quiz type select">
                        <option selected value="1">Active </option>
                        <option value="2">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

    </main>


</body>