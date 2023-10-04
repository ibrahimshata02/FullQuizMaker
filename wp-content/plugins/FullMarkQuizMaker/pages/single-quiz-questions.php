<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>FQM plugin</title>
</head>

<body>
    <main class="container-fluid w-100 position-relative max-height-vh-100 h-100 mt-4">
        <h3 class="mb-4">Select Quiz questions</h3>

        <!-- cards container  -->
        <div class="position-relative mt-4 w-100">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 mb-2">
                <div class="col">
                    <div class="question-card position-relative bg-white border d-flex flex-column rounded-3 p-3">
                        <div class="mb-3">
                            <button style="font-size: 12px;" class="select-box p-2 px-3 border rounded-2 bg-white "><i style="font-size: 22px;" class="fas fa-check text-success opacity-0"></i></button>
                        </div>

                        <p>This is question title This is question This is question title This is question</p>
                        <button style="font-size: 14px;" class="bg-primary text-white p-2 px-3 border-0 rounded-2" type="button" data-bs-toggle="modal" data-bs-target="#preview-question-modal">Preview<i class="fas fa-eye fa-md text-white ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview question modal -->
        <div class="modal fade " id="preview-question-modal" tabindex="-1" aria-labelledby="Preview question modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <div class="quiz-card position-relative d-flex w-100 flex-column" data-quiz-type="1" data-card-id="2023-10-04 08:05:22">
                        <div class="d-flex align-items-center gap-4 mb-3 mt-2">
                            <h4>1) This is quiz title This is quiz title</h4>
                        </div>

                        <div style="width: 100%; height: 300px;" class="image-container border rounded-3">
                            <!-- get random image url -->
                            <img style="height: 300px;" src="https://picsum.photos/seed/picsum/350" class="w-100 rounded-3" alt="quiz image">
                        </div>

                        <div class="px-4">
                            <ul class="alphabet-list d-flex flex-column gap-2 mt-4">
                                <li>This is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question option</li>
                                <li>This is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question option</li>
                                <li>This is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question option</li>
                                <li>This is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question optionThis is question option</li>
                            </ul>
                        </div>

                        <hr class="mb-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <b>(5 marks)</b>
                            <div class="badge bg-primary px-3 py-2 rounded-3">Easy</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        const quizClasses = document.querySelectorAll('.select-box');
        quizClasses.forEach((group) => {
            group.addEventListener('click', () => {
                const parentCard = group.closest('.question-card');
                parentCard.classList.toggle('active-group');
                group.classList.toggle('border-primary');

                const icon = parentCard.querySelector('i');

                if (parentCard.classList.contains('active-group')) {
                    icon.classList.add('opacity-100');
                    icon.classList.remove('opacity-0');
                } else {
                    icon.classList.add('opacity-0');
                    icon.classList.remove('opacity-100');
                }
            })
        })
    </script>

</body>