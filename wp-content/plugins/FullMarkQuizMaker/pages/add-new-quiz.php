<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<body>
    <main class="col-lg-8 col-md-10 col-11 mx-auto main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">

        <div class="d-flex flex-column justify-content-center align-items-center mt-5">
            <div class="border colored-border-div-top w-100 p-4 border-top bg-white mb-4 rounded-3">
                <input style="font-size: 30px;" type="text" class="form-control border mb-2" placeholder="Untitled quiz" id="quiz_title_value" value="" />
                <input type="text" class="form-control border mb-3 p-2" placeholder="Quiz description" id="quiz_description_value" value="" />
            </div>

            <!-- Final output cards [Cards container] -->
            <div id="cardsContainer" class="w-100 d-flex flex-column gap-3">
                <div class="quiz-card position-relative d-flex w-100 flex-column border colored-border-div-left w-100 p-4 border-top bg-white mb-2 rounded-3" data-quiz-type="1">
                    <div style="width:25px; height: 25px; font-size: 13px;" class="counter position-absolute d-flex justify-content-center align-items-center top-0 start-0 bg-primary text-white rounded-full p-3">
                    </div>
                    <div class="d-flex align-items-center gap-4 mb-2 mt-4">
                        <input style="font-size: 23px;" type="text" class="form-control border" placeholder="Untitled question" id="questionTitle" value="" />

                        <div class="d-flex align-items-center gap-3 w-50">
                            <select id="quizTypeSelect" class="w-100 border bg-transparent p-2 " aria-label="Default select example">
                                <option selected value="1">Multiple choice </option>
                                <option value="2">True/False</option>
                                <option value="3">Short answer</option>
                            </select>

                            <?php
                            $name = 'Upload_Image';

                            // Get the path to your plugin directory
                            $plugin_directory = plugin_dir_path(__FILE__);

                            // Go up one level to the parent directory
                            $parent_directory = dirname($plugin_directory);

                            // Include the file from the parent directory
                            include $parent_directory . '/media_uploader_script.php';
                            ?>
                        </div>
                    </div>

                    <!-- <div id="image_container" class="position-relative rounded-3 mt-4 mb-2 border">
                        <div id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" class="position-absolute cursor-pointer negative-position border d-flex justify-content-center align-items-center bg-white p-2 rounded-circle shadow-sm z-index-5" style="width: 40px;height: 40px; z-index: 10;">
                            <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                        </div>
                        <ul class="dropdown-menu border shadow-md " aria-labelledby="dropdownMenuButton1">
                            <li class="dropdown-item d-flex align-items-center gap-3 cursor-pointer p-2 px-3 m-0 ">
                                <i class="fas fa-pen"></i>
                                <span>Edit</span>
                            </li>
                            <li class="dropdown-item d-flex align-items-center gap-3 cursor-pointer p-2 px-3 m-0">
                                <i class="fas fa-trash text-danger"></i>
                                <span>Delete</span>
                            </li>
                        </ul>

                        <div style="height: 350px;" class="position-relative" id="image_holder_<?php echo $name; ?>">
                        </div>
                    </div> -->


                    <div id="optionsGroup" class="d-flex flex-column gap-2 my-3">

                    </div>

                    <div id="addNewOptionContainer" class="d-flex align-items-center gap-3">
                        <input disabled type="radio">
                        <a id="add_new_option" class="cursor-pointer opacity-80 text-primary text-sm m-0" title="Add new option">Add new
                            option</a>
                    </div>

                    <hr class="mt-4">

                    <div class="d-flex justify-content-between p-2">
                        <div class="difficulty-container d-flex flex-column gap-1">
                            <label for="difficulty" class="form-label m-0 mb-1">Difficulty</label>
                            <div class="d-flex flex-row align-items-center gap-2 ">
                                <input type="range" class="form-range" value="0" min="0" max="10" step="1" id="difficulty">
                                <p id="range_text" class="m-0 fw-bolder" style="font-size: 15px;">0/10</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <i title="Add new question card" class="fa-solid fa-circle-plus fa-lg text-dark cursor-pointer"></i>
                            <i title="Duplicate question card" class="fa-regular fa-copy fa-lg text-dark cursor-pointer"></i>
                            <i title="Delete question card" class="fas fa-trash-can fa-lg text-danger cursor-pointer"></i>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" id="save_button" class="align-self-start text-white btn bg-primary col-lg-4 col-md-6 col-7 text-sm font-weight-bold mb-5 mt-4">
                Save
            </button>
        </div>
    </main>
    <!-- 
    <script>
        const difficulty_containers = document.querySelectorAll(".difficulty-container");
        difficulty_containers.forEach((elem) => {
            const difficulty = elem.querySelector("#difficulty");
            const range_text = elem.querySelector("#range_text");

            difficulty.addEventListener("input", (event) => {
                const value = event.target.value;
                range_text.textContent = value + "/10";
            });
        });
    </script> -->

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
                    })

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

                // if (pollsCardsArray.length > 0) {
                //     jQuery.ajax({
                //         type: "POST",
                //         url: my_ajax_object.ajaxurl,
                //         data: {
                //             action: "PSX_save_poll_Multiple_data",
                //             nonce: nonce, // Pass the nonce
                //             poll_data: JSON.stringify(finalObj),
                //         },
                //         success: function(shortcode) {
                //             console.log("Done");
                //             save_button.textContent = "Save";
                //             save_button.disabled = false;

                //             // Create a new toast element
                //             var toast = document.createElement("div");
                //             toast.style = "z-index:1000; right: 10px; bottom: 10px";
                //             toast.className =
                //                 "position-fixed p-2 px-4 bg-success border rounded-2";
                //             toast.innerHTML = `
                //                     <p class="m-0 fw-bold text-xs text-white">
                //                     New survey has been added successfully!
                //                     </p>
                //                 `;
                //             // Append the toast to the document
                //             document.body.appendChild(toast);

                //             // Initialize the Bootstrap toast
                //             var bootstrapToast = new bootstrap.Toast(toast);
                //             bootstrapToast.show();

                //             setTimeout(() => {
                //                 window.location.reload();
                //             }, 500)
                //         },
                //         error: function(error) {
                //             console.error("Error:", error);
                //             save_button.textContent = "Save";
                //             save_button.disabled = false;
                //         },
                //     });
                // }
            });
        });
    </script>

</body>