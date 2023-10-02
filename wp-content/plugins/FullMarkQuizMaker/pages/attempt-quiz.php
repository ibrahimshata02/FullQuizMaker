<!DOCTYPE html>
<html lang="en">

<head>
    <title>Survey</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<body class="main-content position-relative max-height-vh-100 h-100">

    <div class="position-relative col-lg-7 col-md-10 col-12 mx-auto mt-4">

        <!-- Timer container -->
        <div style="width: fit-content; z-index: 10;" id="quiz_timer" class="bg-dark text-white border p-2 px-3 rounded-1 position-sticky top-5">
            <i class="fa-regular text-white fa-hourglass me-2"></i> <span>00:00 mins left</span>
        </div>

        <!-- progress bar here -->
        <div class="d-flex align-items-center justify-content-between gap-2 w-100 mt-4">
            <div class="d-flex align-items-center gap-1">
                <h4 id="current_question_count" class="text-dark"></h4>
                <span>/</span>
                <span id="questions_count" style="font-size: 14px;" class="text-gray fw-bold opacity-6">10</span>
            </div>
            <div style="height: 5px;" class="progress p-0 m-0 rounded-3 overflow-hidden w-100">
                <div class="progress-bar rounded-3 m-0 p-0" role="progressbar" aria-valuenow="10" aria-valuemin="1" aria-valuemax="10" style="width: 10%; height: 100%;"></div>
            </div>
        </div>

        <!-- Question card -->
        <div class="question-card position-relative bg-white rounded-top-0 rounded-bottom-3 border d-flex flex-wrap flex-column p-4 mt-2 rounded-1">
            <!-- Question title -->
            <h4 class="question-title text-break mt-2"></h4>

            <!-- Questions container -->
            <div class="questions-container d-flex flex-column gap-2 mt-3">
                <div class="d-flex align-items-center gap-3">
                    <input id="radio_1" type="radio" value="1" name="Question_id">
                    <label for="radio_1" class="m-0 form-check-label option-text">Make sure to include the Bootstrap CSS link in your HTML to make use of Bootstrap classes.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_2" type="radio" value="2" name="Question_id">
                    <label for="radio_2" class="m-0 form-check-label option-text">We added Bootstrap classes like col-lg-8, col-md-9, etc., for styling and responsiveness.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_3" type="radio" value="3" name="Question_id">
                    <label for="radio_3" class="m-0 form-check-label option-text">Use border utilities to quickly style the border and border-radius of an element. Great for images, buttons, or any other element.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_4" type="radio" value="4" name="Question_id">
                    <label for="radio_4" class="m-0 form-check-label option-text">Use border utilities to add or remove an element’s borders. Choose from all borders or one at a time.</label>
                </div>
            </div>
        </div>

        <button disabled id="next_question" class="btn btn-primary p-3 m-0 mt-4 col-lg-3 col-md-6 col-6">Next question
            <i class="fa-solid fa-arrow-right text-white ms-2 fa-lg"></i>
        </button>
    </div>

    <script>
        var timer = localStorage.getItem("quiz_timer") || 30;
        const PercentOfTimer = timer * 0.3;
        const quiz_timer = document.getElementById('quiz_timer');
        const quiz_timer_text = quiz_timer.querySelector('span');
        const quiz_timer_icon = quiz_timer.querySelector('i');
        var interval;
        let answers_array = [];

        function showConfirmationAlert() {
            Swal.fire({
                title: 'Are you sure you want ot submit answers?',
                text: "You won't be able to revert this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#125b50',
                cancelButtonColor: '#c0392b',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.isConfirmed) {
                    clearInterval(interval);
                    localStorage.removeItem("quiz_timer");
                    localStorage.removeItem("quiz_progress");
                    window.location.reload()
                }
            })
        }

        function timeOutAlert() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your answers have been submitted successfully',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                iconSize: '1rem'
            }).then(() => {
                localStorage.removeItem("quiz_timer");
                localStorage.removeItem("quiz_progress");
                window.location.reload()
            })
        }

        // Timer function to update the timer value
        function updateTimer() {
            // Store the current timer value in local storage first
            localStorage.setItem("quiz_timer", timer);

            var minutes = Math.floor(timer / 60);
            var seconds = timer % 60;
            let var_mins = minutes == 0 ? 'seconds' : "minutes";
            quiz_timer_text.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds + ` ${var_mins} left`;
            timer--;

            if (timer < PercentOfTimer) {
                quiz_timer.className = "bg-warning border p-2 px-3 rounded-1 text-white position-sticky top-5";
                quiz_timer_icon.className = "fa-regular fa-hourglass-half me-2 text-white";
            }
            if (timer < 0) {
                clearInterval(interval);
                quiz_timer.className = "bg-danger border p-2 px-3 rounded-1 text-white position-sticky top-5";
                quiz_timer_text.textContent = '00:00 Timed out';
                quiz_timer_icon.className = "fa-solid fa-stopwatch me-2 text-white shake";
                timeOutAlert()
            }
        }

        // Initialize the timer
        interval = setInterval(updateTimer, 1000);

        // Call updateTimer to start or resume the timer when the page loads
        updateTimer();

        // Question cards data here
        const questionCards = [{
                id: 1,
                title: "This is Question title 1",
                options: [{
                        id: 1,
                        title: "What is the main purpose of including the Bootstrap CSS link in your HTML?",
                    },
                    {
                        id: 2,
                        title: "How do you add Bootstrap classes for styling and responsiveness?",
                    },
                    {
                        id: 3,
                        title: "Explain the usage of border utilities in Bootstrap.",
                    },
                    {
                        id: 4,
                        title: "What are the different options available for adding or removing borders in Bootstrap?",
                    },
                ],
            },
            {
                id: 2,
                title: "This is Question title 2",
                options: [{
                        id: 1,
                        title: "Why is responsive design important in web development?",
                    },
                    {
                        id: 2,
                        title: "List some of the commonly used Bootstrap grid classes.",
                    },
                    {
                        id: 3,
                        title: "What are the advantages of using utility classes for styling?",
                    },
                    {
                        id: 4,
                        title: "Explain the concept of a responsive navigation bar.",
                    },
                ],
            },
            {
                id: 3,
                title: "This is Question title 3",
                options: [{
                        id: 1,
                        title: "What are the key components of a Bootstrap-based webpage?",
                    },
                    {
                        id: 2,
                        title: "How can you create a responsive image using Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of the Bootstrap grid system?",
                    },
                    {
                        id: 4,
                        title: "Explain the use of Bootstrap navigation components.",
                    },
                ],
            },
            {
                id: 4,
                title: "This is Question title 4",
                options: [{
                        id: 1,
                        title: "What is the role of Bootstrap's responsive breakpoints?",
                    },
                    {
                        id: 2,
                        title: "How can you customize Bootstrap styles in your project?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of Bootstrap's modal component?",
                    },
                    {
                        id: 4,
                        title: "Explain the usage of Bootstrap alerts.",
                    },
                ],
            },
            {
                id: 5,
                title: "This is Question title 5",
                options: [{
                        id: 1,
                        title: "What are the benefits of using Bootstrap's CSS classes?",
                    },
                    {
                        id: 2,
                        title: "How can you create a responsive layout with Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of the Bootstrap carousel component?",
                    },
                    {
                        id: 4,
                        title: "Explain the use of Bootstrap badges.",
                    },
                ],
            },
            {
                id: 6,
                title: "This is Question title 6",
                options: [{
                        id: 1,
                        title: "What are the best practices for using Bootstrap in web development?",
                    },
                    {
                        id: 2,
                        title: "How can you create a responsive navbar using Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of Bootstrap forms?",
                    },
                    {
                        id: 4,
                        title: "Explain the usage of Bootstrap tooltips.",
                    },
                ],
            },
            {
                id: 7,
                title: "This is Question title 7",
                options: [{
                        id: 1,
                        title: "What is the significance of Bootstrap's responsive utilities?",
                    },
                    {
                        id: 2,
                        title: "How can you integrate Bootstrap with JavaScript libraries?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of Bootstrap tables?",
                    },
                    {
                        id: 4,
                        title: "Explain the use of Bootstrap progress bars.",
                    },
                ],
            },
            {
                id: 8,
                title: "This is Question title 8",
                options: [{
                        id: 1,
                        title: "What are the differences between Bootstrap 4 and Bootstrap 5?",
                    },
                    {
                        id: 2,
                        title: "How can you create responsive typography with Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of the Bootstrap accordion component?",
                    },
                    {
                        id: 4,
                        title: "Explain the usage of Bootstrap modals.",
                    },
                ],
            }, {
                id: 9,
                title: "This is Question title 9",
                options: [{
                        id: 1,
                        title: "What are the differences between Bootstrap 4 and Bootstrap 5?",
                    },
                    {
                        id: 2,
                        title: "How can you create responsive typography with Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of the Bootstrap accordion component?",
                    },
                    {
                        id: 4,
                        title: "Explain the usage of Bootstrap modals.",
                    },
                ],
            }, {
                id: 10,
                title: "This is Question title 10",
                options: [{
                        id: 1,
                        title: "What are the differences between Bootstrap 4 and Bootstrap 5?",
                    },
                    {
                        id: 2,
                        title: "How can you create responsive typography with Bootstrap?",
                    },
                    {
                        id: 3,
                        title: "What is the purpose of the Bootstrap accordion component?",
                    },
                    {
                        id: 4,
                        title: "Explain the usage of Bootstrap modals.",
                    },
                ],
            },
            // Add more question cards here with different text
        ];

        const next_question = document.getElementById('next_question');
        const current_question_count = document.getElementById('current_question_count');
        const questions_count = document.getElementById('questions_count');
        const progress_bar = document.querySelector('.progress-bar');

        // Load first question card
        const question_card = document.querySelector('.question-card');
        const question_title = question_card.querySelector('.question-title');
        const questions_container = question_card.querySelector('.questions-container');
        const options = questions_container.querySelectorAll('input[type="radio"]');
        const options_labels = questions_container.querySelectorAll('.option-text');

        window.addEventListener('load', () => {
            const storedProgress = localStorage.getItem('quiz_progress');
            if (storedProgress) {
                current_question_count.textContent = storedProgress;
                // Update the progress bar width accordingly
                progress_bar.style.width = parseInt(storedProgress) * 10 + '%';

                // Set the initial values for the first question card
                question_card.setAttribute('data-question-id', questionCards[storedProgress - 1].id)
                question_title.textContent = questionCards[storedProgress - 1].title;
                options_labels.forEach((label, index) => {
                    label.textContent = questionCards[storedProgress - 1].options[index].title;
                })

            } else {
                // Set the initial values for the first question card
                current_question_count.textContent = 1;
                progress_bar.style.width = '10%';

                question_card.setAttribute('data-question-id', questionCards[0].id)
                question_title.textContent = questionCards[0].title;
                options_labels.forEach((label, index) => {
                    label.textContent = questionCards[0].options[index].title;
                })
            }
        });

        // Set the initial values for the progress bar after each next_button click
        next_question.addEventListener("click", () => {
            extractQuizCardValues()

            if (current_question_count.textContent == questions_count.textContent) {
                next_question.textContent = 'Submit Answers';
                next_question.removeAttribute('disabled');
                localStorage.setItem("quiz_progress", current_question_count.textContent);

                // Show the alert to confirm submitting the answers 
                showConfirmationAlert()
            } else {
                // Increasing the question card count by 1
                question_card.setAttribute('data-question-id', questionCards[parseInt(current_question_count.textContent)].id)
                question_title.textContent = questionCards[parseInt(current_question_count.textContent)].title;
                options_labels.forEach((label, index) => {
                    label.textContent = questionCards[parseInt(current_question_count.textContent)].options[index].title;
                })
                current_question_count.textContent = parseInt(current_question_count.textContent) + 1;
                progress_bar.style.width = parseInt(current_question_count.textContent) * 10 + '%';
                localStorage.setItem("quiz_progress", current_question_count.textContent);

                next_question.setAttribute('disabled', 'disabled');
                options.forEach((option) => {
                    option.checked = false;
                });
            }
            // If its the last question card, change the next button text to Submit Answers
            if (current_question_count.textContent == questions_count.textContent) {
                next_question.textContent = 'Submit Answers';
                next_question.removeAttribute('disabled');
            }
        })

        options.forEach((option) => {
            option.addEventListener('change', checkSelectedOptions);
        });

        // Function to check if at least one option is selected
        function checkSelectedOptions() {
            // Iterate through the options and check if any option is selected
            const atLeastOneSelected = Array.from(options).some((option) => option.checked);

            // Enable or disable the save button based on the result
            if (atLeastOneSelected) {
                next_question.removeAttribute('disabled');
            } else {
                next_question.setAttribute('disabled', 'disabled');
            }
        }

        // extractQuizCardValues
        function extractQuizCardValues() {
            const question_card = document.querySelector('.question-card');
            const question_title = question_card.querySelector('.question-title');
            const questions_container = question_card.querySelector('.questions-container');
            const options = questions_container.querySelectorAll('input[type="radio"]');
            const options_labels = questions_container.querySelectorAll('.option-text');
            const selected_option = questions_container.querySelector('input[type="radio"]:checked');
            const selected_option_label = questions_container.querySelector('input[type="radio"]:checked + .option-text');

            answers_array.push({
                question_id: question_card.getAttribute('data-question-id'),
                question_title: question_title.textContent,
                selected_option: selected_option ? selected_option.id : null,
                selected_option_label: selected_option_label ? selected_option_label.textContent : null,
            })

            const uniqueArray = answers_array.filter((item, index, self) =>
                self.findIndex((obj) => obj.question_id === item.question_id) === index
            );
            console.log("uniqueArray", uniqueArray);
        }
    </script>

</body>

</html>