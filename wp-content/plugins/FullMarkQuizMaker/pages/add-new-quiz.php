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
        <!-- newQuiz tab -->
        <div class="position-relative mt-5" id="nav-newQuiz" role="tabpanel" aria-labelledby="nav-newQuiz-tab">
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
    </main>
</body>

</html>