<!DOCTYPE html>
<html lang="en">

<head>
    <title>Survey</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<body class="main-content position-relative max-height-vh-100 h-100">

    <div class="position-relative col-lg-8 col-md-10 col-12 mx-auto mt-4">
        <!-- <h2 class="mb-4">This is quiz title</h2> -->

        <!-- Timer container -->
        <div style="width: fit-content;" id="quiz_timer" class="bg-dark text-white border p-2 px-3 rounded-1 position-sticky top-5">
            <i class="fa-regular text-white fa-hourglass me-2"></i> <span>00:00 mins left</span>
        </div>

        <!-- progress bar here -->
        <div class="d-flex align-items-center justify-content-between gap-2 w-100 mt-4">
            <div class="d-flex align-items-center gap-1">
                <h4 class="text-dark">1</h4>
                <span style="font-size: 14px;" class="text-gray fw-bold opacity-6">/10</span>
            </div>
            <div style="height: 5px;" class="progress p-0 m-0 rounded-3 overflow-hidden w-100">
                <div class="progress-bar rounded-3 m-0 p-0" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="10" style="width: 10%; height: 100%;"></div>
            </div>
        </div>

        <!-- Question card -->
        <div class="position-relative bg-white rounded-top-0 rounded-bottom-3 border d-flex flex-wrap flex-column p-4 mt-2 rounded-1">
            <!-- Question title -->
            <h4 class="text-break mt-2">1) This is Question title </h4>

            <!-- Questions container -->
            <div class="questions-container d-flex flex-column gap-2 mt-3">
                <div class="d-flex align-items-center gap-3">
                    <input id="radio_1" type="radio" value="1" name="Question_id">
                    <label for="radio_1" class="m-0 form-check-label">Make sure to include the Bootstrap CSS link in your HTML to make use of Bootstrap classes.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_2" type="radio" value="2" name="Question_id">
                    <label for="radio_2" class="m-0 form-check-label">We added Bootstrap classes like col-lg-8, col-md-9, etc., for styling and responsiveness.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_3" type="radio" value="3" name="Question_id">
                    <label for="radio_3" class="m-0 form-check-label">Use border utilities to quickly style the border and border-radius of an element. Great for images, buttons, or any other element.</label>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <input id="radio_4" type="radio" value="4" name="Question_id">
                    <label for="radio_4" class="m-0 form-check-label">Use border utilities to add or remove an element’s borders. Choose from all borders or one at a time.</label>
                </div>
            </div>

        </div>

        <button class="btn btn-primary p-3 m-0 mt-4 col-lg-3 col-md-6 col-6">Next question
            <i class="fa-solid fa-arrow-right text-white ms-2 fa-lg"></i>
        </button>
    </div>

    <script>
        var timer = 6;
        const PercentOfTimer = timer * 0.3;
        const quiz_timer = document.getElementById('quiz_timer');
        const quiz_timer_text = quiz_timer.querySelector('span');
        const quiz_timer_icon = quiz_timer.querySelector('i');
        var interval = setInterval(() => {
            var minutes = Math.floor(timer / 60);
            var seconds = timer % 60;
            quiz_timer_text.textContent = minutes + ":" + seconds + " mins left";
            timer--;
            if (timer < PercentOfTimer) {
                quiz_timer.className = "bg-warning border p-2 px-3 rounded-1 text-white position-sticky top-5"
                quiz_timer_icon.className = "fa-regular fa-hourglass-half me-2 text-white"
            }
            if (timer < 0) {
                clearInterval(interval);
                quiz_timer.className = "bg-danger border p-2 px-3 rounded-1 text-white position-sticky top-5"
                quiz_timer_text.textContent = '00:00 Timed out';
                quiz_timer_icon.className = "fa-solid fa-stopwatch me-2 text-white shake"
            }
        }, 1000);
    </script>

</body>

</html>