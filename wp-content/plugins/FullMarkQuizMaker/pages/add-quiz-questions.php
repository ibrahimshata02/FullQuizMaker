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
                    <div class="d-flex align-items-center gap-4 mb-2 mt-4">
                        <input style="font-size: 23px;" type="text" class="questionTitle form-control border" placeholder="Untitled question" value="" />

                        <div class="d-flex align-items-center gap-3 w-50">
                            <select class="quizTypeSelect w-100 border bg-transparent p-2 " aria-label="Default select example">
                                <option selected value="1">Multiple choice </option>
                                <option value="2">True/False</option>
                                <option value="3">Short answer</option>
                            </select>

                            <label for="image_upload" class="upload-icon file-input-label cursor-pointer m-0">
                                <i title="Add new image" class="cursor-pointer fas fa-image text-dark fa-xl"></i>
                                <input class="upload-image-input m-0" type="file" id="image_upload">
                            </label>
                        </div>
                    </div>

                    <div class="image-container">

                    </div>

                    <div class="optionsGroup d-flex flex-column gap-2 my-3">

                    </div>

                    <div class="addNewOptionContainer d-flex align-items-center gap-3">
                        <input disabled type="radio">
                        <a class="add_new_option cursor-pointer opacity-80 text-primary text-sm m-0" title="Add new option">Add new
                            option</a>
                    </div>

                    <hr class="mt-4">

                    <div class="d-flex justify-content-between p-2">
                        <div class="difficulty-container d-flex flex-column gap-1">
                            <label for="difficulty" class="difficulty-text form-label m-0">Very easy</label>
                            <div class="d-flex flex-row align-items-center gap-2 ">
                                <input type="range" class="difficulty form-range" value="1" min="1" max="10" step="1">
                                <p class="range_text m-0 fw-bolder" style="font-size: 15px;">1/10</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <i title="Add new question card" class="fa-solid fa-circle-plus fa-lg text-dark cursor-pointer"></i>
                            <i title="Duplicate question card" class="fa-regular fa-copy fa-lg text-dark cursor-pointer"></i>
                            <i title="Delete question card" class="fas fa-trash-can fa-lg text-danger cursor-pointer"></i>
                        </div>
                    </div>
                    <div style="background-color: #f8d7da; font-size: 13px;" class="alert error-message d-none fw-bold mt-2" role="alert">
                    </div>
                </div>
            </div>

            <button type="submit" id="save_button" class="align-self-start text-white btn bg-primary col-lg-4 col-md-6 col-7 text-sm font-weight-bold mb-5 mt-4">
                Save
            </button>
        </div>
    </main>


    <script>
        jQuery(document).ready(function(jQuery) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-right',
                iconColor: 'red',
                customClass: {
                    popup: 'colored-toast'
                },
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            })

            const cardsContainer = document.getElementById("cardsContainer");

            // Difficulty function to change the text according to the range value
            function getDifficultyText(rangeValue) {
                if (rangeValue <= 2) {
                    return "Very easy"
                } else if (rangeValue <= 4) {
                    return "Easy"
                } else if (rangeValue <= 6) {
                    return "Medium"
                } else if (rangeValue <= 8) {
                    return "Hard"
                } else {
                    return "Very hard"
                }
            }

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
                    const addNewOptionContainer = card.querySelector(".addNewOptionContainer");

                    // Show the add new option container
                    addNewOptionContainer.style.cssText = "display: flex !important;";

                } else if (selectedValue === "2") { // True/False
                    // Hide the add new option container
                    const card = select.closest(".quiz-card");
                    const addNewOptionContainer = card.querySelector(".addNewOptionContainer");
                    addNewOptionContainer.style.cssText = "display: none !important;";

                    const trueFalseContainer = document.createElement("div");
                    trueFalseContainer.className = "option-card d-flex align-items-center gap-2 "
                    trueFalseContainer.setAttribute("data-trueFalse-answer", "");

                    const optionId_1 = generateUniqueId();
                    const optionId_2 = generateUniqueId();

                    trueFalseContainer.innerHTML = `
                        <div data-option-id="${optionId_1}" class="true-false-option d-flex align-items-center justify-content-center p-3 border border-2 rounded-1 cursor-pointer"> <i class="fa-solid fa-check fa-lg text-success"></i> </div>
                        <div data-option-id="${optionId_2}" class="true-false-option d-flex align-items-center justify-content-center p-3 border border-2 rounded-1 cursor-pointer"><i class="fa-solid fa-xmark fa-lg text-danger"></i></div>
                    `;

                    optionsGroup.appendChild(trueFalseContainer);

                    const trueFalseOptions = trueFalseContainer.querySelectorAll(".true-false-option");
                    trueFalseOptions.forEach((option) => {

                        option.addEventListener("click", () => {
                            const icon = option.querySelector("i");
                            if (icon.classList.contains("fa-check")) {
                                trueFalseContainer.setAttribute("data-trueFalse-answer", "True");
                            } else {
                                trueFalseContainer.setAttribute("data-trueFalse-answer", "False");
                            }

                            const trueFalseAnswer = trueFalseContainer.getAttribute("data-trueFalse-answer");

                            console.log(trueFalseAnswer);
                            if (trueFalseAnswer == "True") {
                                trueFalseOptions[0].classList.add("text-success", "border-success");
                                trueFalseOptions[1].classList.remove("text-danger", "text-dark", "border-danger");
                            } else {
                                trueFalseOptions[1].classList.add("text-danger", "border-danger");
                                trueFalseOptions[0].classList.remove("text-success", "text-dark", "border-success");
                            }
                        });
                    });

                } else if (selectedValue === "3") { // Short answer
                    // Hide the add new option container
                    const card = select.closest(".quiz-card");
                    const addNewOptionContainer = card.querySelector(".addNewOptionContainer");
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
                    const add_new_option = card.querySelector(".add_new_option");
                    const optionsGroup = card.querySelector(".optionsGroup");

                    const select = card.querySelector(".quizTypeSelect")
                    const deleteCardIcons = card.querySelectorAll(".fa-trash-can");
                    const range = card.querySelector(".difficulty");

                    // Upload function
                    const upload_image_input = card.querySelector('.upload-image-input');
                    const image_container = card.querySelector('.image-container');

                    upload_image_input.addEventListener("change", (event) => {
                        image_container.className = "image-container position-relative my-3 rounded-3"
                        image_container.innerHTML = `
                        <div id="dropdownMenuButton1" data-bs-toggle="dropdown" class="position-absolute cursor-pointer negative-position border d-flex justify-content-center align-items-center bg-white p-2 rounded-circle shadow-sm z-index-5" style="width: 40px;height: 40px; z-index: 10;">
                            <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                        </div>
                        <ul class="dropdown-menu border shadow-md" aria-labelledby="dropdownMenuButton1">
                            <li class="change-image dropdown-item d-flex align-items-center gap-3 cursor-pointer p-2 px-3 m-0">
                                <i class="fas fa-pen"></i>
                                <span>Edit</span>
                            </li>
                            <li class="remove-image dropdown-item d-flex align-items-center gap-3 cursor-pointer p-2 px-3 m-0">
                                <i class="fas fa-trash text-danger"></i>
                                <span>Delete</span>
                            </li>
                        </ul>
                        <img id="frame" style="height: 350px;" class="w-100 rounded-3" src="${URL.createObjectURL(event.target.files[0])}" />
                    `;
                        updateQuizzes()
                    });

                    // Remove Image function
                    const removeImageIcon = card.querySelector('.remove-image');
                    if (removeImageIcon != null) {
                        removeImageIcon.addEventListener("click", () => {
                            image_container.innerHTML = "";
                            image_container.className = "image-container"
                            updateQuizzes()
                        })
                    }

                    // Change Image function    
                    const changeImageIcon = card.querySelector('.change-image');
                    if (changeImageIcon != null) {
                        changeImageIcon.addEventListener("click", () => {
                            upload_image_input.click();
                            updateQuizzes()
                        })
                    }

                    range.addEventListener("input", () => {
                        const range_text = card.querySelector(".range_text");
                        const difficultyText = card.querySelector(".difficulty-text");
                        range_text.textContent = `${range.value}/10`;
                        difficultyText.textContent = getDifficultyText(range.value);
                    })

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

                    const cardId = generateUniqueId(); // Generate a unique ID for the card
                    card.setAttribute("data-card-id", cardId);

                    // Add event listener for adding a new option
                    add_new_option.addEventListener("click", handleAddOptionClick);

                    // Add event listener for deleting the card
                    const deleteCardIcon = card.querySelector(".fa-trash-can");
                    deleteCardIcon.addEventListener("click", (event) => {
                        event.stopPropagation();
                        card.remove();
                        Toast.fire({
                            icon: 'error',
                            title: 'Your question has been deleted successfully!',
                            position: 'bottom-right',
                        })
                        updateQuizzes();
                    });
                });
            };

            function handleSelectChange(event) {
                const select = event.target;
                const card = select.closest(".quiz-card");
                const optionsGroup = card.querySelector(".optionsGroup");
                const selectedValue = select.value;

                // Set the data-quiz-type attribute to the selected value
                card.setAttribute("data-quiz-type", selectedValue);

                updateOptions(select, optionsGroup);
            }

            // Add new option event listener
            function handleAddOptionClick(event) {
                const add_new_option = event.target;
                const card = add_new_option.closest(".quiz-card");
                const optionsGroup = card.querySelector(".optionsGroup");

                const optionCard = document.createElement("div");
                optionCard.className =
                    "option-card d-flex justify-content-between align-items-center gap-2"; // Add justify-content-between class
                const optionId = generateUniqueId(); // Generate a unique ID for the option
                const cardId = card.getAttribute("data-card-id"); // Get the unique card ID

                optionCard.setAttribute("data-option-id", optionId);
                optionCard.innerHTML = `
                    <div class="d-flex align-items-center gap-2 w-100">
                        <input type="radio" name="option-${cardId}" value="value-${optionId}">
                        <input type="text" class="form-control border p-2" placeholder="Option title" value="" />
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
                    <div class="d-flex align-items-center gap-4 mb-2 mt-4">
                        <input style="font-size: 23px;" type="text" class="questionTitle form-control border" placeholder="Untitled question" value="">

                        <div class="d-flex align-items-center gap-3 w-50">
                            <select class="quizTypeSelect w-100 border bg-transparent p-2 " aria-label="Default select example">
                                <option selected="" value="1">Multiple choice </option>
                                <option value="2">True/False</option>
                                <option value="3">Short answer</option>
                            </select>
                                <label for="${cardId}" class="upload-icon file-input-label cursor-pointer m-0">
                                <i title="Add new image" class="cursor-pointer fas fa-image text-dark fa-xl"></i>
                                <input class="upload-image-input m-0" type="file" id="${cardId}">
                            </label>                     
                            </div>
                    </div>

                    <div class="image-container">

                    </div>

                    <div class="optionsGroup d-flex flex-column gap-2 my-3">

                    </div>

                    <div class="addNewOptionContainer d-flex align-items-center gap-3">
                        <input disabled type="radio">
                        <a class="add_new_option cursor-pointer opacity-80 text-primary text-sm m-0" title="Add new option">Add new option</a>
                    </div>

                        <hr class="mt-4">

                        <div class="d-flex justify-content-between p-2">
                        <div class="difficulty-container d-flex flex-column gap-1">
                            <label for="difficulty" class="form-label difficulty-text m-0">Difficulty</label>
                            <div class="d-flex flex-row align-items-center gap-2 ">
                                <input type="range" class="difficulty form-range" value="1" min="1" max="10" step="1">
                                <p class="range_text m-0 fw-bolder" style="font-size: 15px;">1/10</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <i title="Add new question card" class="fa-solid fa-circle-plus fa-lg text-dark cursor-pointer"></i>
                            <i title="Duplicate question card" class="fa-regular fa-copy fa-lg text-dark cursor-pointer"></i>
                            <i title="Delete question card" class="fas fa-trash-can fa-lg text-danger cursor-pointer"></i>
                        </div>
                    </div> 
                    <div style="background-color: #f8d7da; font-size: 13px;" class="alert error-message d-none fw-bold mt-2" role="alert">
                    </div>             
                </div>`

                    cardsContainer.appendChild(newCard)
                    updateQuizzes()
                    // scroll into the screen to show the new card  
                    window.scrollTo(0, document.body.scrollHeight);
                }
            });

            // Duplication card function
            function duplicateCard(card) {
                const cardClone = card.cloneNode(true); // Clone the card including its children
                const cardId = generateUniqueId(); // Generate a unique ID for the card
                cardClone.setAttribute("data-card-id", cardId);

                const quizTypeSelect = cardClone.querySelector(".quizTypeSelect");
                quizTypeSelect.value = card.getAttribute("data-quiz-type");

                updateOptions(quizTypeSelect, cardClone.querySelector(".optionsGroup"));

                const image_upload_input = cardClone.querySelector('.upload-image-input');
                image_upload_input.id = cardId;

                const upload_icon_label = cardClone.querySelector('.upload-icon');
                upload_icon_label.setAttribute("for", cardId);

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
                        updateQuizzes();
                        // scroll into the screen to show the new card  
                        window.scrollTo(0, document.body.scrollHeight);
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
                    const questionTitle = card.querySelector(".questionTitle").value;

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
                            const optionId = option.querySelector("div").getAttribute("data-option-id");
                            const answer = option.getAttribute("data-trueFalse-answer");

                            options.push({
                                optionId,
                                answer
                            });
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

            // MCQ validation question
            function validateMCQ(card) {
                const questionTitle = card.querySelector('.questionTitle');
                const options = card.querySelectorAll('.option-card div');
                const selectedOption = card.querySelector('input[type="radio"]:checked');
                const errorMessage = card.querySelector('.error-message');
                let errorMessages = []; // Store error messages in an array

                if (questionTitle.value.trim() === '') {
                    errorMessages.push('Question title cannot be empty.');
                    questionTitle.classList.add('border-danger');
                    card.classList.add('border-danger');
                } else {
                    questionTitle.classList.remove('border-danger');
                    card.classList.remove('border-danger');
                }

                if (options.length < 2) {
                    errorMessages.push('You need at least 2 options for MCQ.');
                    card.classList.add('border-danger');
                } else {
                    card.classList.remove('border-danger');
                }

                for (const option of options) {
                    const optionTitle = option.querySelector('input[type="text"]').value.trim();
                    const optionInput = option.querySelector('input[type="text"]');

                    if (optionTitle === '') {
                        errorMessages.push('Option titles cannot be empty.');
                        optionInput.classList.add('border-danger');
                        card.classList.add('border-danger');
                    } else {
                        optionInput.classList.remove('border-danger');
                    }
                }

                if (!selectedOption) {
                    errorMessages.push('Select one answer for the question.');
                    card.classList.add('border-danger');
                } else {
                    card.classList.remove('border-danger');
                }

                if (errorMessages.length > 0) {
                    errorMessage.textContent = errorMessages[0]; // Display the first error message
                    errorMessage.classList.remove('d-none');
                    return false; // Validation error(s) found
                } else {
                    errorMessage.classList.add('d-none');
                    return true; // No validation error
                }
            }

            // True/ False validation question
            function validateTrueFalse(card) {
                const questionTitle = card.querySelector('.questionTitle');
                const answer = card.querySelector('.option-card').getAttribute("data-trueFalse-answer");
                const errorMessage = card.querySelector('.error-message');
                let errorMessages = []; // Store error messages in an array

                if (questionTitle.value.trim() === '') {
                    errorMessages.push('Question title cannot be empty.');
                    questionTitle.classList.add('border-danger');
                    card.classList.add('border-danger');
                } else {
                    questionTitle.classList.remove('border-danger');
                    card.classList.remove('border-danger');
                }

                if (answer === "") {
                    errorMessages.push('Select either True or False.');
                    card.classList.add('border-danger');
                } else {
                    card.classList.remove('border-danger');
                }

                if (errorMessages.length > 0) {
                    errorMessage.textContent = errorMessages[0]; // Display the first error message
                    errorMessage.classList.remove('d-none');
                    return false; // Validation error(s) found
                } else {
                    errorMessage.classList.add('d-none');
                    return true; // No validation error
                }
            }


            // Short answer validation question
            function validateShortAnswer(card) {
                const questionTitle = card.querySelector('.questionTitle');
                const shortAnswerText = card.querySelector('.option-card textarea');
                const errorMessage = card.querySelector('.error-message');
                let errorMessages = []; // Store error messages in an array

                if (questionTitle.value.trim() === '') {
                    errorMessages.push('Question title cannot be empty.');
                    questionTitle.classList.add('border-danger');
                    card.classList.add('border-danger');
                } else {
                    questionTitle.classList.remove('border-danger');
                    card.classList.remove('border-danger');
                }

                if (shortAnswerText.value.trim() === "") {
                    errorMessages.push('Short answer text cannot be empty.');
                    card.classList.add('border-danger');
                    shortAnswerText.classList.add('border-danger');
                } else {
                    shortAnswerText.classList.remove('border-danger');
                    card.classList.remove('border-danger');
                }

                if (errorMessages.length > 0) {
                    errorMessage.textContent = errorMessages[0]; // Display the first error message
                    errorMessage.classList.remove('d-none');
                    return false; // Validation error(s) found
                } else {
                    errorMessage.classList.add('d-none');
                    return true; // No validation error
                }
            }

            // Validate the card
            function validateCard(card) {
                const quizType = card.getAttribute('data-quiz-type');

                if (quizType === '1') {
                    validateMCQ(card);
                } else if (quizType === '2') {
                    validateTrueFalse(card);
                } else if (quizType === '3') {
                    validateShortAnswer(card);
                }
            }

            // Save button event listener
            save_button.addEventListener("click", () => {
                const extractedData = extractQuizCardValues();
                console.log(extractedData); // This will log the extracted data as an array of objects

                const cards = document.querySelectorAll('.quiz-card');
                let isValid = true;

                for (const card of cards) {
                    if (!validateCard(card)) {
                        // scroll into the card view
                        card.scrollIntoView({
                            behavior: 'smooth',
                        });
                    };
                }
            });

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
            //                 "position-fixed p-4 bg-success border rounded-2";
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
    </script>

</body>