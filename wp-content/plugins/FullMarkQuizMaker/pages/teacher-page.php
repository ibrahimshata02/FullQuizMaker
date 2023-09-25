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
            <button class="nav-link border-right" id="nav-quizzes-tab" data-bs-toggle="tab" data-bs-target="#nav-quizzes" role="tab" aria-controls="nav-quizzes" aria-selected="true">My Quizzes <i class="fa-regular fa-pen-to-square ms-2"></i></button>
            <button class="nav-link border-right active" id="nav-classes-tab" data-bs-toggle="tab" data-bs-target="#nav-classes" role="tab" aria-controls="nav-classes" aria-selected="false">My Classes <i class="fa-solid fa-chalkboard-user ms-2"></i></button>
            <button class="nav-link border-right" id="nav-newQuiz-tab" data-bs-toggle="tab" data-bs-target="#nav-newQuiz" role="tab" aria-controls="nav-newQuiz" aria-selected="false">New quiz <i class="fa-solid fa-plus ms-2"></i></button>
            <button class="nav-link " id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">Settings <i class="fa-solid fa-gears ms-2"></i></button>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <!-- Recent Quizzes -->
            <div class="tab-pane fade mt-5" id="nav-quizzes" role="tabpanel" aria-labelledby="nav-quizzes-tab">
                <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                    <h4 class="m-0">Recent quizzes</h4>
                    <a href="<?php echo admin_url('admin.php?page=poll-survey-xpress-add'); ?>" class="btn btn-primary m-0">New Quiz
                        <i style="cursor: pointer" class="fas fa-add text-white ms-2"></i>
                    </a>
                </div>

                <div class="table-responsive p-0 bg-white mt-3 rounded-3">
                    <table class="table align-items-center m-0 w-100">
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
            <div class="tab-pane show active fade mt-5" id="nav-classes" role="tabpanel" aria-labelledby="nav-classes-tab">
                <h4 class="m-0 mt-2">Assigned classes</h4>

                <!-- Classes row -->
                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-3">
                    <div class="position-relative col">
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>

                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-regular fa-user fa-sm"></i>
                                    <p class="m-0" style="font-size: 13px;"> +187</p>
                                </div>

                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-solid fa-award"></i>
                                    <p class="m-0" style="font-size: 13px;">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative col">
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>

                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-regular fa-user fa-sm"></i>
                                    <p class="m-0" style="font-size: 13px;"> +187</p>
                                </div>

                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-solid fa-award"></i>
                                    <p class="m-0" style="font-size: 13px;">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-1">
                    <div class="position-relative col">
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>

                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-regular fa-user fa-sm"></i>
                                    <p class="m-0" style="font-size: 13px;"> +187</p>
                                </div>

                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-solid fa-award"></i>
                                    <p class="m-0" style="font-size: 13px;">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative col">
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>

                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-regular fa-user fa-sm"></i>
                                    <p class="m-0" style="font-size: 13px;"> +187</p>
                                </div>

                                <div class="d-flex text-primary align-items-center gap-2">
                                    <i class="fa-solid fa-award"></i>
                                    <p class="m-0" style="font-size: 13px;">Excellent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- newQuiz tab -->
            <div class="tab-pane fade mt-5" id="nav-newQuiz" role="tabpanel" aria-labelledby="nav-newQuiz-tab">
                <h4 class="m-0 mt-2"> Add new quiz</h4>

                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-3">
                    <div class="col">
                        <label class="form-label">Quiz title</label>
                        <input type="text" class="form-control border p-2" placeholder="Edit Quiz title" value="" />
                    </div>

                    <div class="col">
                        <label class="form-label">Quiz status</label>
                        <select id="quizTypeSelect" class="form-control border bg-white p-2" aria-label="Quiz type select">
                            <option selected value="1">Active </option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-2">
                    <div class="col">
                        <label class="form-label">Start date</label>
                        <input type="datetime-local" class="form-control border p-2" placeholder="Edit Quiz title" value="" />
                    </div>

                    <div class="col">
                        <label class="form-label">End date</label>
                        <input type="datetime-local" class="form-control border p-2" placeholder="Edit Quiz title" value="" />
                    </div>
                </div>

                <div class="mt-3">
                    <label>Duration</label>
                    <input class="form-control border p-2" type="tel" placeholder="Enter the quiz duration">
                </div>

                <div class="mt-3">
                    <label>Questions bank</label>
                    <input class="form-control border p-2" type="tel" placeholder="Choose questions from the question bank">
                </div>

                <button class="btn btn-primary mt-4 w-25 p-3">Save </button>
            </div>

            <!-- Quiz Settings tab -->
            <div class="tab-pane fade mt-5" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                <h4 class="m-0 mt-2"> Quiz settings</h4>

                <button class="btn btn-primary mt-4 w-25 p-3">Save </button>
            </div>

            <!-- Edit quizzes tab -->
            <script>
                jQuery(document).ready(function(jQuery) {
                    const cardsContainer = document.getElementById("cardsContainer");

                    // Function to generate a unique ID
                    function generateUniqueId() {
                        return new Date().toISOString() + Math.random().toString(36).substr(2, 9);
                    }

                    function updateOptions(select, optionsGroup) {
                        const selectedValue = select.value;
                        // Clear existing options
                        optionsGroup.innerHTML = "";


                        if (selectedValue === "1") { // Multiple choice
                            // Show the add new option container
                            const card = select.closest(".quiz-card");
                            const addNewOptionContainer = card.querySelector("#addNewOptionContainer");

                            // Show the add new option container
                            addNewOptionContainer.style.cssText = "display: flex !important;";

                        } else if (selectedValue === "2") { // True/False
                            // Hide the add new option container
                            const card = select.closest(".quiz-card");
                            const addNewOptionContainer = card.querySelector("#addNewOptionContainer");
                            addNewOptionContainer.style.cssText = "display: none !important;";

                            const option1 = createOption("True", card);
                            const option2 = createOption("False", card);
                            optionsGroup.appendChild(option1);
                            optionsGroup.appendChild(option2);

                        } else if (selectedValue === "3") { // Short answer
                            // Hide the add new option container
                            const card = select.closest(".quiz-card");
                            const addNewOptionContainer = card.querySelector("#addNewOptionContainer");
                            addNewOptionContainer.style.cssText = "display: none !important;";

                            const optionCard = document.createElement("div");
                            optionCard.className = "option-card";
                            const optionId = generateUniqueId();
                            optionCard.setAttribute("data-option-id", optionId);
                            optionCard.innerHTML = `
                        <div class="w-100">
                            <textarea rows="2" class="w-100 rounded-3 p-3 border" placeholder="Short answer text"></textarea>
                        </div>
                    `;
                            optionsGroup.appendChild(optionCard);
                        }
                    }

                    function createOption(optionText, card) {
                        const optionCard = document.createElement("div");
                        optionCard.className = "option-card d-flex justify-content-between align-items-center gap-2";
                        const cardId = card.getAttribute("data-card-id");
                        const optionId = generateUniqueId();
                        optionCard.setAttribute("data-option-id", optionId);
                        optionCard.innerHTML = `
                        <div class="d-flex align-items-center gap-2 w-100">
                            <input name="option-${cardId}" type="radio" value="value-${optionId}" />
                            <input readonly type="text" class="form-control border bg-transparent p-2" placeholder="Option title" value="${optionText}" />
                        </div>
                        `;
                        return optionCard;
                    }

                    // Add new option event listener
                    function updateQuizzes() {
                        const quiz_cards = document.querySelectorAll(".quiz-card");

                        quiz_cards.forEach((card, index) => {
                            const add_new_option = card.querySelector("#add_new_option");
                            const optionsGroup = card.querySelector("#optionsGroup");
                            const counter = card.querySelector(".counter");
                            const select = card.querySelector("#quizTypeSelect")
                            const deleteCardIcons = card.querySelectorAll(".fa-trash-can");

                            deleteCardIcons.forEach((deleteCardIcon) => {
                                if (index == 0)
                                    deleteCardIcon.style.cssText = "display: none !important;";
                                else deleteCardIcon.style.cssText = "display: block !important;";
                            });

                            // Remove existing event listeners to prevent duplicates
                            select.removeEventListener("change", handleSelectChange);
                            add_new_option.removeEventListener("click", handleAddOptionClick);

                            // Add an event listener to listen for changes in the select box
                            select.addEventListener("change", handleSelectChange);

                            // Set the question number
                            counter.textContent = index + 1;

                            const cardId = generateUniqueId(); // Generate a unique ID for the card
                            card.setAttribute("data-card-id", cardId);

                            // Add event listener for adding a new option
                            add_new_option.addEventListener("click", handleAddOptionClick);

                            // Add event listener for deleting the card
                            const deleteCardIcon = card.querySelector(".fa-trash-can");
                            deleteCardIcon.addEventListener("click", (event) => {
                                event.stopPropagation();
                                card.remove();
                                updateQuizzes();
                            });
                        });
                    }

                    function handleSelectChange(event) {
                        const select = event.target;
                        const card = select.closest(".quiz-card");
                        const optionsGroup = card.querySelector("#optionsGroup");
                        const selectedValue = select.value;

                        // Set the data-quiz-type attribute to the selected value
                        card.setAttribute("data-quiz-type", selectedValue);

                        updateOptions(select, optionsGroup);
                    }


                    // Add new option event listener
                    function handleAddOptionClick(event) {
                        const add_new_option = event.target;
                        const card = add_new_option.closest(".quiz-card");
                        const optionsGroup = card.querySelector("#optionsGroup");

                        const optionCard = document.createElement("div");
                        optionCard.className =
                            "option-card d-flex justify-content-between align-items-center gap-2"; // Add justify-content-between class
                        const optionId = generateUniqueId(); // Generate a unique ID for the option
                        const cardId = card.getAttribute("data-card-id"); // Get the unique card ID

                        optionCard.setAttribute("data-option-id", optionId);
                        optionCard.innerHTML = `
                            <div class="d-flex align-items-center gap-2 w-100">
                                <input type="radio" name="option-${cardId}" value="value-${optionId}">
                                <input type="text" class="form-control border p-2" placeholder="Option title" value="Option title" />
                            </div>
                            <i class="cursor-pointer fa-regular fa-circle-xmark fa-lg text-danger" data-option-id="${optionId}"></i>
                        `;
                        optionsGroup.appendChild(optionCard);

                        // Add event listener for deleting this option
                        const deleteOptionIcon = optionCard.querySelector(`[data-option-id="${optionId}"]`);
                        deleteOptionIcon.addEventListener("click", (event) => {
                            event.stopPropagation();
                            optionCard.remove();
                        });
                    }

                    document.addEventListener("click", function(event) {
                        if (event.target.classList.contains("fa-circle-plus")) {
                            const newCard = document.createElement("div");
                            const cardId = generateUniqueId(); // Generate a unique ID for the card
                            newCard.setAttribute("data-card-id", cardId);
                            newCard.innerHTML = `<div class="quiz-card position-relative d-flex w-100 flex-column border colored-border-div-left w-100 p-4 border-top bg-white mb-2 rounded-3" data-quiz-type="1">
                    <div style="width:25px; height: 25px; font-size: 13px;" class="counter position-absolute d-flex justify-content-center align-items-center top-0 start-0 bg-primary text-white rounded-full p-3">1</div>
                    <div class="d-flex align-items-center gap-4 mb-2 mt-2">
                        <input style="font-size: 23px;" type="text" class="form-control border" placeholder="Untitled question" id="questionTitle" value="">

                        <div class="d-flex align-items-center gap-3 w-50">
                            <select id="quizTypeSelect" class="w-100 border bg-transparent p-2 " aria-label="Default select example">
                                <option selected="" value="1">Multiple choice </option>
                                <option value="2">True/False</option>
                                <option value="3">Short answer</option>
                            </select>
                            <i title="Add new image" class="cursor-pointer fas fa-image text-dark fa-xl"> </i>
                        </div>
                    </div>

                    <div id="optionsGroup" class="d-flex flex-column gap-2 my-3">

                    </div>

                    <div id="addNewOptionContainer" class="d-flex align-items-center gap-3">
                        <input disabled type="radio">
                        <a id="add_new_option" class="cursor-pointer opacity-80 text-primary text-sm m-0" title="Add new option">Add new
                            option</a>
                    </div>

                    <hr class="mt-4">

                    <div class="d-flex justify-content-end gap-4 p-2">
                        <i title="Add new question card" class="fa-solid fa-circle-plus fa-lg text-dark cursor-pointer"></i>
                        <i title="Duplicate question card" class="fa-regular fa-copy fa-lg text-dark cursor-pointer"></i>
                        <i title="Delete question card" class="fas fa-trash-can fa-lg text-danger cursor-pointer"></i>
                    </div>
                </div>`
                            cardsContainer.appendChild(newCard)
                            updateQuizzes()
                        }
                    });

                    // Duplication card function
                    function duplicateCard(card) {
                        const cardClone = card.cloneNode(true); // Clone the card including its children
                        const cardId = generateUniqueId(); // Generate a unique ID for the card
                        cardClone.setAttribute("data-card-id", cardId);
                        cardsContainer.appendChild(cardClone);

                        // Add event listeners for the cloned card's options
                        cardClone.querySelectorAll(".fa-circle-xmark").forEach((deleteOptionIcon) => {
                            const optionId = deleteOptionIcon.getAttribute("data-option-id");
                            deleteOptionIcon.addEventListener("click", (event) => {
                                event.stopPropagation();
                                const optionContainer = cardClone.querySelector(
                                    `[data-option-id="${optionId}"]`);
                                if (optionContainer) {
                                    optionContainer.remove();
                                }
                            });
                        });
                    }

                    // Event listener for duplicating a card
                    document.addEventListener("click", function(event) {
                        if (event.target.classList.contains("fa-copy")) {
                            const card = event.target.closest(".quiz-card"); // Find the closest card element
                            if (card) {
                                duplicateCard(card); // Call the duplicateCard function when the icon is clicked
                                updateQuizzes()
                            }
                        }
                    });

                    // Initial setup
                    updateQuizzes();

                    // Function to extract the quiz card values
                    function extractQuizCardValues() {
                        const quizCards = document.querySelectorAll(".quiz-card");

                        const quizData = [];

                        quizCards.forEach((card) => {
                            const cardType = card.getAttribute("data-quiz-type");
                            const cardId = card.getAttribute("data-card-id");
                            const questionTitle = card.querySelector("#questionTitle").value;

                            // Extract options data based on the card type
                            let options = [];
                            if (cardType === "1") { // Multiple choice or True/False
                                card.querySelectorAll(".option-card").forEach((option) => {
                                    const optionId = option.getAttribute("data-option-id");
                                    const optionTitle = option.querySelector("input[type='text']").value;
                                    const optionValue = option.querySelector("input[type='radio']").checked;
                                    options.push({
                                        optionId,
                                        optionTitle,
                                        optionValue
                                    });
                                });
                            } else if (cardType === "2") { // True/False
                                card.querySelectorAll(".option-card").forEach((option) => {
                                    const optionId = option.getAttribute("data-option-id");
                                    const radioButton = option.querySelector("input[type='radio']");
                                    const optionTitle = option.querySelector("input[type='text']").value;

                                    let optionValue = null; // Initialize optionValue to null

                                    if (radioButton.checked) {
                                        // Set optionValue to the selected option's text
                                        optionValue = optionTitle;
                                        options.push({
                                            optionId,
                                            optionValue
                                        });
                                    }


                                });

                            } else { // Short answer
                                card.querySelectorAll(".option-card").forEach((option) => {
                                    const optionId = option.getAttribute("data-option-id");
                                    const shortAnswerText = option.querySelector("textarea").value;
                                    options.push({
                                        optionId,
                                        shortAnswerText
                                    });
                                });
                            }

                            quizData.push({
                                cardType,
                                cardId,
                                questionTitle,
                                options,
                            });
                        });

                        return quizData;
                    }

                    save_button.addEventListener("click", () => {
                        const extractedData = extractQuizCardValues();
                        console.log(extractedData); // This will log the extracted data as an array of objects
                    });
                });
            </script>
    </main>
</body>