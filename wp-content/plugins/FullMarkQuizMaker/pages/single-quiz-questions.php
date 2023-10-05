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
        <div class="position-relative py-4 w-100">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                <div class="col">
                    <div class="question-card position-relative bg-white border border-2 d-flex flex-column rounded-3">
                        <div class="select-container cursor-pointer p-3">
                            <div class="d-flex align-items-center justify-content-between ">
                                <!-- Question number  -->
                                <span style="font-size: 20px;" class="d-flex justify-content-center align-items-center text-primary fw-bold">
                                    #1
                                </span>

                                <!-- Question select box -->
                                <div style="width: 40px; height: 40px;" class="select-box d-flex justify-content-center align-items-center border border-2 rounded-2 bg-white">
                                    <i style="font-size: 25px;" class="fas fa-check text-success opacity-0"></i>
                                </div>


                            </div>

                            <p class="mt-3 mb-0">This is question title This is question This is question title This is question...</p>
                        </div>

                        <button style="font-size: 14px; border-radius: 0.50rem; border-top-left-radius: 0; border-top-right-radius:0 ;" class="bg-primary text-white p-2 px-3 border-0" type="button" data-bs-toggle="modal" data-bs-target="#preview-question-modal">Preview<i class="fas fa-eye fa-md text-white ms-2"></i></button>

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
        const row = document.querySelector('.row');

        for (let i = 0; i < 30; i++) {
            const question_card = document.querySelector('.col');
            const duplicate_question_card = question_card.cloneNode(true);
            row.appendChild(duplicate_question_card);
        }

        const selectContainers = document.querySelectorAll('.select-container');
        selectContainers.forEach((container) => {
            container.addEventListener('click', () => {
                const parentCard = container.closest('.question-card');
                const selectBox = container.querySelector(".select-box")
                parentCard.classList.toggle('active-group');
                selectBox.classList.toggle('border-primary');

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