<?php

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class FullQuizMaker
{
    private $version = 3.4;

    // Constructor for class includes all hooks
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'FQM_enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'FQM_add_admin_menu_link'));
        add_action('admin_bar_menu', array($this, 'FQM_toolbar_link'), 99);
        add_action('wp_enqueue_scripts', array($this, 'FQM_enqueue_frontend_scripts'));
        add_action('wp_ajax_FQM_Add_Year_And_Levels', array($this, 'FQM_Add_Year_And_Levels'));

        add_action('wp_ajax_FQM_add_questions', array($this, 'FQM_add_questions'));
        add_action('wp_ajax_FQM_add_quiz', array($this, 'FQM_add_quiz'));
        add_action('wp_ajax_FQM_archive_quiz', array($this, 'FQM_archive_quiz'));
        add_action('wp_ajax_FQM_permenent_delete_quiz', array($this, 'FQM_permenent_delete_quiz'));
        add_action('wp_ajax_FQM_restore_quiz', array($this, 'FQM_restore_quiz'));
        add_action('wp_ajax_FQM_email_students', array($this, 'FQM_email_students'));
        add_action('wp_ajax_FQM_upload_file', array($this, 'FQM_upload_file'));
        add_action('wp_ajax_nopriv_FQM_upload_file', array($this, 'FQM_upload_file'));

        add_action('wp_ajax_FQM_importStudentDataFromExcel', array($this, 'FQM_importStudentDataFromExcel'));
        add_action('wp_ajax_FQM_download_default_template', array($this, 'FQM_download_default_template'));
        add_action('wp_ajax_nopriv_FQM_importStudentDataFromExcel', array($this, 'FQM_importStudentDataFromExcel'));
    }

    public function FQM_enqueue_frontend_scripts()
    {

        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('popper', plugin_dir_url(__FILE__) . 'assets/js/popper.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('sweatAlert', plugin_dir_url(__FILE__) . 'assets/js/sweatAlert.js', array('jquery'), $this->version, true);
        wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), $this->version, true);

        wp_localize_script('plugin-custom', 'my_ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_ajax_nonce'),
        ));
        wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'assets/css/custom-styles.css', array(), $this->version);
    }

    // Enqueue scripts and styles for the admin area
    public function FQM_enqueue_admin_scripts()
    {
        //enqueue Script files
        if (
            (isset($_GET['page']) && (
                ($_GET['page'] === 'add-year' ||
                    $_GET['page'] === 'add-teacher' ||
                    $_GET['page'] === 'poll-survey-xpress-add' ||
                    $_GET['page'] === 'poll-survey-xpress-settings' ||
                    $_GET['page'] === 'view_template_page' ||
                    $_GET['page'] === 'edit_template_page' ||
                    $_GET['page'] === 'poll-survey-xpress-recycle' ||
                    $_GET['page'] === 'show_template_page')
            ))
        ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), $this->version, true);
            wp_enqueue_script('popper', plugin_dir_url(__FILE__) . 'assets/js/popper.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('sweatAlert', plugin_dir_url(__FILE__) . 'assets/js/sweatAlert.js', array('jquery'), $this->version, true);
            wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('media-upload');

            wp_enqueue_media();
            // Enqueue the Font Awesome stylesheet
            wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

            wp_localize_script('plugin-custom', 'my_ajax_object', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('my_ajax_nonce'),
            ));

            wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.css', array(), $this->version);
            wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'assets/css/custom-styles.css', array(), $this->version);
        }
    }

    // Add main menu page (FullQuizMaker)
    public function FQM_add_admin_menu_link()
    {
        add_menu_page(
            'FullQuizMaker',                    // the page title of Plugin
            'FullQuizMaker',                    // the Title that appears in the menu bar
            'manage_options',                   // permissions that can see the menu (admin OR higher) => capability
            'full-quiz-maker',                 // unique menu slug
            array($this, 'FQM_Profile_callback'),    // method for output
            'dashicons-text-page',               // You can add the link of a custom icon 
            70
        );
        if (current_user_can('administrator')) {
            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Add Year & Level',                    // page title
                'Add Year & Level',                    // menu title
                'manage_options',                  // capability required to access
                'add-year',                    // menu slug
                array($this, 'FQM_Add_Year_callback')  // callback function for the page
            );
            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Add Teacher',                    // page title
                'Add Teacher',                    // menu title
                'manage_options',                  // capability required to access
                'add-teacher',                    // menu slug
                array($this, 'FQM_Add_Teacher_callback')  // callback function for the page
            );
        } else {

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Teacher Profile',                    // page title
                'Teacher Profile',                    // menu title
                'manage_options',                  // capability required to access
                'teacher-profile',                    // menu slug
                array($this, 'FQM_Teacher_Profile_callback')  // callback function for the page
            );
            // Add a submenu page for "Add New Quiz"
            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Add New',                    // page title
                'Add New',                    // menu title
                'manage_options',                  // capability required to access
                'add-quiz-questions',                    // menu slug
                array($this, 'FQM_singleQuiz_callback')  // callback function for the page
            );
            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Questions Bank',                    // page title
                'Questions Bank',                    // menu title
                'manage_options',                  // capability required to access
                'questions-bank',                    // menu slug
                array($this, 'FQM_addQuizQuestions_callback')  // callback function for the page
            );


            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Add Partecipents',                    // page title
                'Add-Partecipents',                    // menu title
                'manage_options',                  // capability required to access
                'Add Partecipents',                    // menu slug
                array($this, 'FQM_Add_Partecipents_callback')  // callback function for the page
            );



            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Teacher page',                    // page title
                'Teacher page',                    // menu title
                'manage_options',                  // capability required to access
                'Teacher page',                    // menu slug
                array($this, 'FQM_Add_TeacherPage_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Class page',                    // page title
                'Class page',                    // menu title
                'manage_options',                  // capability required to access
                'Class page',                    // menu slug
                array($this, 'FQM_Add_ClassPage_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'Student page',                    // page title
                'Student page',                    // menu title
                'manage_options',                  // capability required to access
                'Student page',                    // menu slug
                array($this, 'FQM_Add_StudentPage_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'RecentQuizzes page',                    // page title
                'RecentQuizzes page',                    // menu title
                'manage_options',                  // capability required to access
                'RecentQuizzes page',                    // menu slug
                array($this, 'FQM_Add_RecentQuizzesPage_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'AddNewQuiz page',                    // page title
                'AddNewQuiz page',                    // menu title
                'manage_options',                  // capability required to access
                'add-new-quiz',                    // menu slug
                array($this, 'FQM_Add_AddNewQuiz_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'AttemptQuiz page',                    // page title
                'AttemptQuiz page',                    // menu title
                'manage_options',                  // capability required to access
                'attempt-quiz',                    // menu slug
                array($this, 'FQM_Add_AttemptQuiz_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'QuestionsBank page',                    // page title
                'QuestionsBank page',                    // menu title
                'manage_options',                  // capability required to access
                'questions-bank',                    // menu slug
                array($this, 'FQM_Add_QuestionsBank_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'EditQuestion page',                    // page title
                'EditQuestion page',                    // menu title
                'manage_options',                  // capability required to access
                'edit-question',                    // menu slug
                array($this, 'FQM_Add_EditQuestion_callback')  // callback function for the page
            );

            add_submenu_page(
                'full-quiz-maker',                 // parent menu slug
                'SingleQuizQuestions page',                    // page title
                'SingleQuizQuestions page',                    // menu title
                'manage_options',                  // capability required to access
                'single-quiz-questions',                    // menu slug
                array($this, 'FQM_SingleQuizQuestion_callback')  // callback function for the page
            );
        }

        // Remove the submenu page that you want to hide
        remove_submenu_page('full-quiz-maker', 'full-quiz-maker');
    }
    //Callback method for the Add Teacher page
    public function FQM_Add_Teacher_callback()
    {
        include 'pages/Add Teacher.php';
    }
    //Callback method for the Add Year page
    public function FQM_Add_Year_callback()
    {
        include 'pages/Add Year.php';
    }
    // Callback method for the Quizzes page
    public function FQM_Teacher_Profile_callback()
    {
        include 'Teacher_Profile.php';
    }
    public function FQM_settings_callback()
    {
        include 'Settings.php';
    }

    public  function FQM_Add_Partecipents_callback()
    {
        include 'pages/Add Partecipents.php';
    }

    // Callback method for the add new quiz page
    public function FQM_addQuizQuestions_callback()
    {
        include 'pages/add-quiz-questions.php';
    }

    // Callback method for the single quiz page
    public function FQM_singleQuiz_callback()
    {
        include 'pages/single-quiz.php';
    }

    // Callback method for the admin page
    public function FQM_Add_AdminPage_callback()
    {
        include 'pages/admin-page.php';
    }

    // Callback method for the teacher page
    public function FQM_Add_TeacherPage_callback()
    {
        include 'pages/teacher-page.php';
    }

    // Callback method for the class page
    public function FQM_Add_ClassPage_callback()
    {
        include 'pages/class-page.php';
    }

    // Callback method for the Quizzes page
    public function FQM_Add_StudentPage_callback()
    {
        include 'pages/student-page.php';
    }

    // Callback method for the Recent Quizzes page
    public function FQM_Add_RecentQuizzesPage_callback()
    {
        include 'pages/recent-quizzes.php';
    }

    // Callback method for the Quizzes page
    public function FQM_Add_AddNewQuiz_callback()
    {
        include 'pages/add-new-quiz.php';
    }

    // Callback method for the Quizzes page
    public function FQM_Add_AttemptQuiz_callback()
    {
        include 'pages/attempt-quiz.php';
    }

    // Callback method for the questions bank page
    public function FQM_Add_QuestionsBank_callback()
    {
        include 'pages/questions-bank.php';
    }

    // Callback method for the Edit quiz page
    public function FQM_Add_EditQuestion_callback()
    {
        include 'pages/edit-question.php';
    }

    // Callback method for the single quiz questions page
    public function FQM_SingleQuizQuestion_callback()
    {
        include 'pages/single-quiz-questions.php';
    }

    // Add menu link in top bar (FullQuizMaker)
    public function FQM_toolbar_link($wp_admin_bar)
    {
        if (is_admin()) {

            $link_data = array(
                'id'    => 'full-quiz-maker',
                'title' => '<span class="ab-icon dashicons-text-page"></span><span>Quiz Maker</span>',
                'href'  => admin_url('admin.php?page=full-quiz-maker'),
            );

            // Add the main menu item
            $wp_admin_bar->add_node($link_data);
        }
    }

    // //Add Questions to Question Bank
    // public function FQM_add_questions()
    // {
    //     global $wpdb;
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["questions_data"])) {
    //         $questions_data_array = json_decode(stripslashes($_POST["questions_data"]), true);
    //         $form_type = $questions_data_array['type'];

    //         if ($form_type == 'Edit') {
    //             $question_id = sanitize_text_field($questions_data_array['question_id']);

    //             $table_questions = $wpdb->prefix . "FQM_questions";
    //             $table_answers = $wpdb->prefix . "FQM_defaultanswers";
    //             // Delete Qusetion answers
    //             $wpdb->delete($table_answers, array("poll_id" => $question_id));
    //             // Delete from  Question
    //             $wpdb->delete($table_questions, array("poll_id" => $question_id));
    //         }
    //         $questions = $questions_data_array['questions'];

    //         foreach ($questions as $question) {
    //             $question_text = $question['question_text'];
    //             $question_type = $question['question_type'];
    //             $question_attachments_data = $question['question_attachments_data'];

    //             // Create an array for question data
    //             $question_data = array(
    //                 'question_text' => sanitize_text_field($question_text),
    //                 'question_type' => sanitize_text_field($question_type),
    //                 'question_attachments_data' => sanitize_text_field($question_attachments_data),
    //             );

    //             // Check if it's an Edit or Insert operation
    //             if ($form_type == 'Edit') {
    //                 $question_id = $question['question_id']; // Assuming you have question_id in your data
    //                 $wpdb->update($wpdb->prefix . 'FQM_questions', $question_data, array('question_id' => $question_id));
    //             } else {
    //                 $wpdb->insert($wpdb->prefix . 'FQM_questions', $question_data);
    //                 $question_id = $wpdb->insert_id;
    //             }
    //             $answers = $question['answers'];
    //             foreach ($answers as $answer) {
    //                 $answer_text = sanitize_text_field($answer['answer_text']);
    //                 $answer_is_correct = sanitize_text_field($answer['answer_is_correct']);
    //                 $sequenceData = sanitize_text_field($answer['sequence']);

    //                 // Insert the answer into the FQM_defaultanswers table
    //                 $insert_answer_query = $wpdb->prepare(
    //                     "INSERT INTO {$wpdb->prefix}FQM_defaultanswers (answer_text, answer_is_correct, sequenceData ,question_id) VALUES (%s, %d, %d, %d)",
    //                     $answer_text,
    //                     $answer_is_correct,
    //                     $sequenceData,
    //                     $question_id
    //                 );
    //                 $wpdb->query($insert_answer_query);
    //             }
    //         }
    //     }
    // }

    // // Add Quiz and Questions to Quiz 
    // public function FQM_add_quiz()
    // {
    //     global $wpdb;

    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }

    //     // Check if the request method is POST and questions_data is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["questions_data"])) {
    //         $quiz_data_array = json_decode(stripslashes($_POST["quiz_data"]), true);
    //         $form_type = $quiz_data_array['type'];

    //         // Quiz data
    //         $quiz_name = sanitize_text_field($quiz_data_array['quiz_name']);
    //         $quiz_description = sanitize_text_field($quiz_data_array['quiz_description']);
    //         $quiz_created_date = sanitize_text_field($quiz_data_array['quiz_created_date']);
    //         $quiz_end_date = sanitize_text_field($quiz_data_array['quiz_end_date']);
    //         $quiz_status = sanitize_text_field($quiz_data_array['quiz_status']);
    //         $quiz_time = sanitize_text_field($quiz_data_array['quiz_time']);
    //         $quiz_duration = sanitize_text_field($quiz_data_array['quiz_duration']);
    //         $quiz_type = sanitize_text_field($quiz_data_array['quiz_type']);
    //         $class_id = intval($quiz_data_array['class_id']);
    //         $year_id = intval($quiz_data_array['year_id']);
    //         $level_id = intval($quiz_data_array['level_id']);

    //         if ($form_type == 'Edit') {
    //             $quiz_id = intval($quiz_data_array['quiz_id']);

    //             // Update quiz details
    //             $wpdb->update(
    //                 $wpdb->prefix . 'FQM_Quizzes',
    //                 array(
    //                     'quiz_name' => $quiz_name,
    //                     'quiz_description' => $quiz_description,
    //                     'quiz_created_date' => $quiz_created_date,
    //                     'quiz_end_date' => $quiz_end_date,
    //                     'quiz_status' => $quiz_status,
    //                     'quiz_time' => $quiz_time,
    //                     'quiz_duration' => $quiz_duration,
    //                     'quiz_type' => $quiz_type,
    //                     'quiz_seed_random' => 7,
    //                     'class_id' => $class_id,
    //                     'year_id' => $year_id,
    //                     'level_id' => $level_id,
    //                 ),
    //                 array('quiz_id' => $quiz_id)
    //             );
    //         } else {
    //             // Insert new quiz
    //             $wpdb->insert(
    //                 $wpdb->prefix . 'FQM_Quizzes',
    //                 array(
    //                     'quiz_name' => $quiz_name,
    //                     'quiz_description' => $quiz_description,
    //                     'ID' => get_current_user_id(),
    //                     'quiz_created_date' => $quiz_created_date,
    //                     'quiz_end_date' => $quiz_end_date,
    //                     'quiz_status' => $quiz_status,
    //                     'quiz_time' => $quiz_time,
    //                     'quiz_duration' => $quiz_duration,
    //                     'quiz_type' => $quiz_type,
    //                     'quiz_seed_random' => 9,
    //                     'class_id' => $class_id,
    //                     'year_id' => $year_id,
    //                     'level_id' => $level_id,
    //                 )
    //             );
    //             $quiz_id = $wpdb->insert_id; // Get the newly inserted quiz_id
    //         }

    //         // Quiz questions data
    //         $questions_in_quiz = $quiz_data_array['questions'];

    //         foreach ($questions_in_quiz as $question) {
    //             $question_id = intval($question['question_id']);
    //             $question_mark = intval($question['question_points']);
    //             $question_answer_seed_random = 5;

    //             // Check if it's an Edit or Insert operation for quiz questions
    //             if ($form_type == 'Edit') {
    //                 //delete question from quiz
    //                 $wpdb->delete(
    //                     $wpdb->prefix . 'FQM_quizQuestions',
    //                     array(
    //                         'quiz_id' => $quiz_id,
    //                     )
    //                 );
    //             }
    //             // Insert new quiz question
    //             $wpdb->insert(
    //                 $wpdb->prefix . 'FQM_quizQuestions',
    //                 array(
    //                     'quiz_id' => $quiz_id,
    //                     'question_id' => $question_id,
    //                     'question_mark' => $question_mark,
    //                     'question_answer_seed_random' => $question_answer_seed_random,
    //                 )
    //             );
    //         }
    //     }
    // }
    // // Archive Quiz
    // public function FQM_archive_quiz()
    // {
    //     global $wpdb;

    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }

    //     // Check if the request method is POST and quiz_id is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
    //         $quiz_id = intval($_POST["quiz_id"]);

    //         // Update quiz status to archived
    //         $wpdb->update(
    //             $wpdb->prefix . 'FQM_Quizzes',
    //             array(
    //                 'quiz_status' => 'archived',
    //             ),
    //             array('quiz_id' => $quiz_id)
    //         );
    //     }
    // }
    // Restore Quiz
    // public function FQM_restore_quiz()
    // {
    //     global $wpdb;

    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }

    //     // Check if the request method is POST and quiz_id is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
    //         $quiz_id = intval($_POST["quiz_id"]);

    //         // Update quiz status to active
    //         $wpdb->update(
    //             $wpdb->prefix . 'FQM_Quizzes',
    //             array(
    //                 'quiz_status' => 'active',
    //             ),
    //             array('quiz_id' => $quiz_id)
    //         );
    //     }
    // }
    // // Delete Quiz
    // public function FQM_permenent_delete_quiz()
    // {
    //     global $wpdb;

    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }

    //     // Check if the request method is POST and quiz_id is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
    //         $quiz_id = intval($_POST["quiz_id"]);

    //         // Delete quiz questions
    //         $wpdb->delete(
    //             $wpdb->prefix . 'FQM_quizQuestions',
    //             array(
    //                 'quiz_id' => $quiz_id,
    //             )
    //         );
    //         // Delete quiz
    //         $wpdb->delete(
    //             $wpdb->prefix . 'FQM_Quizzes',
    //             array(
    //                 'quiz_id' => $quiz_id,
    //             )
    //         );
    //     }
    // }
    // Send Email For Students in the Group with Code
    // public function FQM_email_students()
    // {
    //     global $wpdb;
    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }
    //     // Check if the request method is POST and quiz_id is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["class_id"])) {
    //         $class_id = intval($_POST["class_id"]);
    //         //Get the student emails for the class
    //         $query = $wpdb->prepare(
    //             "SELECT user_email
    //                 FROM {$wpdb->prefix}users 
    //                 WHERE ID IN (
    //                     SELECT ID 
    //                     FROM {$wpdb->prefix}FQM_studentinGroups 
    //                     WHERE class_id = %d
    //                 ) and ID IN (
    //                     SELECT user_id 
    //                     FROM {$wpdb->prefix}usermeta 
    //                     WHERE meta_key = 'wp_capabilities' 
    //                     AND meta_value LIKE '%student%'
    //                 )",
    //             $class_id
    //         );

    //         $student_emails = $wpdb->get_results($query);


    //         foreach ($student_emails as $student) {
    //             $to = $student;
    //             $subject = sanitize_text_field($_POST['email_subject']);
    //             $body = sanitize_text_field($_POST['email_body']);
    //             $headers = array('Content-Type: text/html; charset=UTF-8');
    //             wp_mail($to, $subject, $body, $headers);
    //         }
    //     }
    // }
    // ShortCode For Profile Page of Student
    // public function FQM_student_profile()
    // {
    //     global $wpdb;
    //     $user_id = get_current_user_id();

    //     $user_info = get_userdata($user_id);


    //     //Add this shortcode if the user is a student

    //     if (in_array('student', $user_info->roles)) {
    //         $output = '<div class="container">';
    //         $output .= '<div class="row">';
    //         $output .= '<div class="col-md-12">';
    //         $output .= '<h1 class="text-center">Welcome ' . $user_info->first_name . ' ' . $user_info->last_name . '</h1>';
    //         $output .= '</div>';
    //         $output .= '</div>';
    //         $output .= '<div class="row">';
    //         $output .= '<div class="col-md-12">';
    //         $output .= '<h2 class="text-center">Your Classes</h2>';
    //         $output .= '</div>';
    //         $output .= '</div>';
    //         $output .= '<div class="row">';
    //         $output .= '<div class="col-md-12">';
    //         $output .= '<table class="table table-striped">';
    //         $output .= '<thead>';
    //         $output .= '<tr>';
    //         $output .= '<th scope="col">Class Name</th>';
    //         $output .= '<th scope="col">Class Code</th>';
    //         $output .= '<th scope="col">Class Teacher</th>';
    //         $output .= '<th scope="col">Class Year</th>';
    //         $output .= '<th scope="col">Class Level</th>';
    //         $output .= '</tr>';
    //         $output .= '</thead>';
    //         $output .= '<tbody>';
    //         $output .=  $wpdb->get_results("SELECT class_id FROM {$wpdb->prefix}FQM_studentinGroups WHERE ID = $user_id", ARRAY_A);
    //         $output .= '</tbody>';
    //         $output .= '</table>';
    //         $output .= '</div>';
    //         $output .= '</div>';
    //         $output .= '</div>';
    //         return $output;
    //     }
    // }
    // ShortCode For Profile Page of Teacher
    // public function FQM_teacher_profile()
    // {
    //     global $wpdb;
    //     $user_id = get_current_user_id();

    //     $user_info = get_userdata($user_id);
    // }

    // function excelColumnToNumber($column)
    // {
    //     $column = strtoupper($column);
    //     $columnNumber = 0;
    //     $length = strlen($column);

    //     for ($i = 0; $i < $length; $i++) {
    //         $char = $column[$i];
    //         $columnNumber = $columnNumber * 26 + (ord($char) - 65 + 1);
    //     }

    //     return $columnNumber;
    // }
    // function numberToExcelColumn($columnNumber)
    // {
    //     if ($columnNumber <= 0) {
    //         return ''; // Return an empty string for non-positive column numbers
    //     }

    //     $excelColumn = '';

    //     while ($columnNumber > 0) {
    //         $remainder = ($columnNumber - 1) % 26; // Subtract 1 for 0-based indexing
    //         $excelColumn = chr(65 + $remainder) . $excelColumn; // Convert to letter
    //         $columnNumber = floor(($columnNumber - $remainder) / 26);
    //     }

    //     return $excelColumn;
    // }


    // public function FQM_importStudentDataFromExcel()
    // {
    //     global $wpdb;

    //     // Verify nonce
    //     if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    //         wp_send_json_error('Invalid nonce.');
    //     }

    //     // Check if the request method is POST and Import File is set
    //     if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //         // Check if a file was uploaded
    //         if (!empty($_FILES['file']['tmp_name'])) {
    //             // Load the Excel file
    //             try {
    //                 $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
    //             } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    //                 die('Error loading the Excel file: ' . $e->getMessage());
    //             }

    //             // Add the year and get the year_id
    //             $year_title = sanitize_text_field($_POST['year']);
    //             Self::FQM_add_year_to_database($year_title);
    //             $year_id = $wpdb->insert_id;

    //             // Add the level and get the level_id
    //             $level = sanitize_text_field($_POST['level']);
    //             Self::FQM_add_level_to_database($level, $year_id);
    //             $level_id = $wpdb->insert_id;
    //             $type = sanitize_text_field($_POST['type']);
    //             // Select the active worksheet
    //             $worksheet = $spreadsheet->getActiveSheet();
    //             if ($type == 'Defult') {
    //                 // Iterate through rows and create user accounts
    //                 for ($row = 2; $row <= $worksheet->getHighestRow(); $row++) {
    //                     // Get data from columns A to D in the current row
    //                     $referenceCode = $worksheet->getCell('C' . $row)->getValue(); // Column A
    //                     $fullName = $worksheet->getCell('D' . $row)->getValue(); // Column D
    //                     $class_id =  $worksheet->getCell('B' . $row)->getValue(); // Column B
    //                     // Create a username based on reference code or any unique identifier
    //                     $username = 'student_' . $referenceCode;

    //                     // Check if the username already exists
    //                     if (username_exists($username)) {
    //                         // Username already exists, so skip this user or handle it as needed
    //                         continue;
    //                     }

    //                     // Create a random password
    //                     $password = wp_generate_password();

    //                     // Create the user account
    //                     $user_id = wp_create_user($username, $password, $username . '@gmail.com');

    //                     // Check if user creation was successful
    //                     if (!is_wp_error($user_id)) {
    //                         // Add the 'student' role to the user
    //                         $user = new WP_User($user_id);
    //                         $user->add_role('student');
    //                         $user->remove_role('subscriber');

    //                         $table_classes = $wpdb->prefix . 'FQM_classes';
    //                         $wpdb->insert(
    //                             $table_classes,
    //                             array(
    //                                 'class_name' => 'Grade ' . $class_id,
    //                                 'class_description' => 'Description',
    //                                 'year_id' => $year_id,
    //                                 'level_id' => $level_id,
    //                                 'ID' => $user_id,
    //                             ),
    //                             array(
    //                                 '%s', // class_name is a string
    //                                 '%s', // class_description is a string
    //                                 '%d', // year_id is an integer
    //                                 '%d', // level_id is an integer
    //                                 '%d', // ID is an integer
    //                             )
    //                         );
    //                         $table_studentinGroups = $wpdb->prefix . 'FQM_studentinGroups';
    //                         $wpdb->insert(
    //                             $table_studentinGroups,
    //                             array(
    //                                 'class_id' => $class_id,
    //                                 'ID' => $user_id,
    //                             ),
    //                             array(
    //                                 '%d', // class_id is an integer
    //                                 '%d', // ID is an integer
    //                             )
    //                         );

    //                         // Insert data into the FQM_classes table

    //                     }
    //                 }
    //             } else {
    //                 for ($row = 2; $row <= $worksheet->getHighestRow(); $row++) {
    //                     // Get data from columns A to D in the current row
    //                     $referenceCode = $worksheet->getCell('F' . $row)->getValue(); // Column F
    //                     $fullName = $worksheet->getCell('J' . $row)->getValue(); // Column D
    //                     $class_id = $worksheet->getCell('D' . $row)->getValue(); // Column F
    //                     $level_data = $worksheet->getCell('C' . $row)->getValue(); // Column J

    //                     $username = 'student_' . $referenceCode;

    //                     // Check if the username already exists
    //                     if (username_exists($username)) {
    //                         // Username already exists, so skip this user or handle it as needed
    //                         continue;
    //                     }

    //                     // Create a random password
    //                     $password = wp_generate_password();

    //                     // Create the user account
    //                     $user_id = wp_create_user($username, $password, $username . '@gmail.com');

    //                     // Check if user creation was successful
    //                     if (!is_wp_error($user_id)) {
    //                         // Add the 'student' role to the user
    //                         $user = new WP_User($user_id);
    //                         $user->add_role('student');
    //                         $user->remove_role('subscriber');

    //                         $table_classes = $wpdb->prefix . 'FQM_classes';
    //                         $wpdb->insert(
    //                             $table_classes,
    //                             array(
    //                                 'class_name' => 'Grade ' . $class_id,
    //                                 'class_description' => 'Description',
    //                                 'year_id' => $year_id,
    //                                 'level_id' => $level_id,
    //                                 'ID' => $user_id,
    //                             ),
    //                             array(
    //                                 '%s', // class_name is a string
    //                                 '%s', // class_description is a string
    //                                 '%d', // year_id is an integer
    //                                 '%d', // level_id is an integer
    //                                 '%d', // ID is an integer
    //                             )
    //                         );
    //                         $table_studentinGroups = $wpdb->prefix . 'FQM_studentinGroups';
    //                         $wpdb->insert(
    //                             $table_studentinGroups,
    //                             array(
    //                                 'class_id' => $class_id,
    //                                 'ID' => $user_id,
    //                             ),
    //                             array(
    //                                 '%d', // class_id is an integer
    //                                 '%d', // ID is an integer
    //                             )
    //                         );

    //                         // Insert data into the FQM_classes table

    //                     }
    //                 }
    //             }
    //             // Optional: Redirect or display a success message
    //         } else {
    //             echo '<p>No file uploaded.</p>';
    //         }
    //     }
    // }

    //Function to create a new year & levels 
    public function FQM_Add_Year_And_Levels()
    {
        global $wpdb;

        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
        // Check if the request method is POST and quiz_id is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["data"])) {
            $data = json_decode(stripslashes($_POST["data"]), true);
            $year = $data['studyYear'];
            $levels = $data['studyLevels'];

            $table_year = $wpdb->prefix . 'FQM_year';
            $table_levels = $wpdb->prefix . 'FQM_level';
            $wpdb->insert(
                $table_year,
                array(
                    'year_title' => $year,
                ),
                array(
                    '%s', // year_name is a string
                )
            );
            $year_id = $wpdb->insert_id;
            foreach ($levels as $level) {
                $wpdb->insert(
                    $table_levels,
                    array(
                        'level' => $level,
                        'year_id' => $year_id,
                    ),
                    array(
                        '%s', // level_name is a string
                        '%d', // year_id is an integer
                    )
                );
            }
            wp_send_json_success('success');
        }
    }
}

$FullQuizMaker  = new FullQuizMaker();
