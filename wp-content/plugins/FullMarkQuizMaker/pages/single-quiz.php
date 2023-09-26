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

    /* Hide the file input */
    #formFile {
        display: none;
    }

    /* Style the label to look like the icon */
    .file-input-label {
        display: inline-block;
        cursor: pointer;
    }

    .file-input-label i {
        font-size: 25px !important;
    }
</style>


<body>
    <main class="col-lg-9 col-md-10 col-10 mx-auto main-content position-relative max-height-vh-100 h-100 mt-4 border-radius-lg">

        <!-- Nav buttons -->
        <div class="position-relative bg-white d-flex align-items-center nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active border-right" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Preview/edit <i class="fa-regular fa-pen-to-square ms-2"></i></button>
            <button class="nav-link border-right" id="nav-classes-tab" data-bs-toggle="tab" data-bs-target="#nav-classes" role="tab" aria-controls="nav-classes" aria-selected="false">classes <i class="fa-solid fa-chalkboard-user ms-2"></i></button>
            <button class="nav-link " id="nav-settings-tab" data-bs-toggle="tab" data-bs-target="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">Settings <i class="fa-solid fa-gears ms-2"></i></button>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <!-- Preview and edit tab -->
            <div class="tab-pane show active fade mt-5" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <h4 class="m-0 mt-3">Edit quiz</h4>

                <div class="d-flex flex-column justify-content-center align-items-center mt-4">
                    <div class="border colored-border-div-top w-100 p-4 border-top bg-white mb-4 rounded-3">
                        <input style="font-size: 30px;" type="text" class="form-control border mb-2" placeholder="Untitled quiz" id="quiz_title_value" value="" />
                        <input type="text" class="form-control border mb-3 p-2" placeholder="Quiz description" id="quiz_description_value" value="" />
                    </div>

                    <!-- Final output cards [Cards container] -->
                    <div id="cardsContainer" class="w-100 d-flex flex-column gap-3">
                        <div class="quiz-card position-relative d-flex w-100 flex-column border colored-border-div-left w-100 p-4 border-top bg-white mb-2 rounded-3" data-quiz-type="1">
                            <!-- <div style="width:25px; height: 25px; font-size: 13px;" class="counter position-absolute d-flex justify-content-center align-items-center top-0 start-0 bg-primary text-white rounded-full p-3">
                    </div> -->
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
                                    <label for="difficulty" class="form-label m-0">Difficulty</label>
                                    <div class="d-flex flex-row align-items-center gap-2 ">
                                        <input type="range" class="difficulty form-range" value="1" min="1" max="5" step="1">
                                        <p class="range_text m-0 fw-bolder" style="font-size: 15px;">1/5</p>
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
            </div>

            <!-- classes tab -->
            <div class="tab-pane fade mt-5" id="nav-classes" role="tabpanel" aria-labelledby="nav-classes-tab">
                <h4 class="m-0 mt-2"> Assigned classes</h4>

                <!-- Classes row -->
                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-3">
                    <div class="position-relative col">
                        <i class="fa-solid fa-check fa-xl text-success position-absolute top-10 end-4 opacity-0"></i>
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>
                        </div>
                    </div>

                    <div class="cursor-pointer position-relative col">
                        <i class="fa-solid fa-check fa-xl text-success position-absolute top-10 end-4 opacity-0"></i>
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>
                        </div>
                    </div>
                </div>

                <!-- Classes row -->
                <div class="row row-cols-1 row-cols-lg-2 card-hover g-3 mt-1">
                    <div class="position-relative col">
                        <i class="fa-solid fa-check fa-xl text-success position-absolute top-10 end-4 opacity-0"></i>
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>
                        </div>
                    </div>

                    <div class="cursor-pointer position-relative col">
                        <i class="fa-solid fa-check fa-xl text-success position-absolute top-10 end-4 opacity-0"></i>
                        <div class="quiz-class p-4 bg-white border-2 rounded-3 p-4 border rounded-3 cursor-pointer ">
                            <h5>Class name</h5>
                            <p>Find quick answers to your questions and get the most out of Font Awesome with our step-by-step docs and troubleshooting tips.</p>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-4 w-25 p-3">Save </button>
            </div>

            <!-- Quiz Settings tab -->
            <div class="tab-pane fade mt-5" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                <h4 class="m-0 mt-2"> Quiz settings</h4>

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
                            const addNewOptionContainer = card.querySelector(".addNewOptionContainer");

                            // Show the add new option container
                            addNewOptionContainer.style.cssText = "display: flex !important;";

                        } else if (selectedValue === "2") { // True/False
                            // Hide the add new option container
                            const card = select.closest(".quiz-card");
                            const addNewOptionContainer = card.querySelector(".addNewOptionContainer");
                            addNewOptionContainer.style.cssText = "display: none !important;";

                            const option1 = createOption("True", card);
                            const option2 = createOption("False", card);
                            optionsGroup.appendChild(option1);
                            optionsGroup.appendChild(option2);

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
                                range_text.textContent = `${range.value}/5`;
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

                            // Set the question number
                            // counter.textContent = index + 1;

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
                            <label for="difficulty" class="form-label m-0">Difficulty</label>
                            <div class="d-flex flex-row align-items-center gap-2 ">
                                <input type="range" class="difficulty form-range" value="1" min="1" max="5" step="1">
                                <p class="range_text m-0 fw-bolder" style="font-size: 15px;">1/5</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <i title="Add new question card" class="fa-solid fa-circle-plus fa-lg text-dark cursor-pointer"></i>
                            <i title="Duplicate question card" class="fa-regular fa-copy fa-lg text-dark cursor-pointer"></i>
                            <i title="Delete question card" class="fas fa-trash-can fa-lg text-danger cursor-pointer"></i>
                        </div>
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

            <!-- Image upload handler -->
            <script>
                function preview() {
                    frame.src = URL.createObjectURL(event.target.files[0]);
                }

                function clearImage() {
                    document.getElementById('formFile').value = null;
                    frame.src = "";
                }
            </script>

            <script>
                const quizClasses = document.querySelectorAll('.quiz-class');
                quizClasses.forEach((group) => {
                    group.addEventListener('click', () => {
                        group.classList.toggle('active-group');
                        if (group.classList.contains('active-group')) {
                            group.parentNode.querySelector('i').style.cssText = 'opacity:1 !important; transition: all 0.3s ease-in-out;';
                        } else {
                            group.parentNode.querySelector('i').style.cssText = 'opacity:0 !important; transition: all 0.3s ease-in-out;';
                        }
                    })
                })
            </script>
    </main>
</body>