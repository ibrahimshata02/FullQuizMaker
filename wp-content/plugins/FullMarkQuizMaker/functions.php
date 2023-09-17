<?php

class FullQuizMaker
{
    private $version = 2.1;

    // Constructor for class includes all hooks
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'FQM_enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'FQM_add_admin_menu_link'));
        add_action('admin_bar_menu', array($this, 'FQM_toolbar_link'), 99);
        add_action('wp_enqueue_scripts', array($this, 'FQM_enqueue_frontend_scripts'));
        add_action('wp_ajax_FQM_add_questions', array($this, 'FQM_add_questions'));
        add_action('wp_ajax_FQM_add_quiz', array($this, 'FQM_add_quiz'));
        add_action('wp_ajax_FQM_archive_quiz', array($this, 'FQM_archive_quiz'));
        add_action('wp_ajax_FQM_permenent_delete_quiz', array($this, 'FQM_permenent_delete_quiz'));
        add_action('wp_ajax_FQM_restore_quiz', array($this, 'FQM_restore_quiz'));
        add_action('wp_ajax_FQM_email_students', array($this, 'FQM_email_students'));
        add_action('wp_ajax_FQM_upload_file', array($this, 'FQM_upload_file'));
        add_action('wp_ajax_nopriv_FQM_upload_file',array($this, 'FQM_upload_file'));
        add_action('wp_ajax_RCS_GET_MEDIUM_IMG_I', array($this,'get_medium_image')) ;

    }

    public function FQM_enqueue_frontend_scripts()
    {

        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . '/js/bootstrap.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('popper', plugin_dir_url(__FILE__) . '/js/popper.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . '/js/main.js', array('jquery'), $this->version, true);

        wp_localize_script('plugin-custom', 'my_ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_ajax_nonce'),
        ));
        wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'css/custom-styles.css', array(), $this->version);
    }

    // Enqueue scripts and styles for the admin area
    public function FQM_enqueue_admin_scripts()
    {
        //enqueue Script files
        if (
            (isset($_GET['page']) && (
                ($_GET['page'] === 'add-new-quiz' ||
                    $_GET['page'] === 'poll-survey-xpress-recycle' ||
                    $_GET['page'] === 'poll-survey-xpress-add' ||
                    $_GET['page'] === 'poll-survey-xpress-settings' ||
                    $_GET['page'] === 'view_template_page' ||
                    $_GET['page'] === 'edit_template_page' ||
                    $_GET['page'] === 'poll-survey-xpress-recycle' ||
                    $_GET['page'] === 'show_template_page')
            )) || true
        ) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . '/js/main.js', array('jquery'), $this->version, true);
            wp_enqueue_script('popper', plugin_dir_url(__FILE__) . '/js/popper.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__) . '/js/bootstrap.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('media-upload');

            wp_enqueue_media();
            // Enqueue the Font Awesome stylesheet
            wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

            wp_localize_script('plugin-custom', 'my_ajax_object', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('my_ajax_nonce'),
            ));

            wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.css', array(), $this->version);
            wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'css/custom-styles.css', array(), $this->version);
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
            array($this, 'FQM_Quizzes_callback'),    // method for output
            'dashicons-text-page',               // You can add the link of a custom icon 
            70
        );
        add_submenu_page(
            'full-quiz-maker',                 // parent menu slug
            'Quizzes',                    // page title
            'Quizzes',                    // menu title
            'manage_options',                  // capability required to access
            'quizzes',                    // menu slug
            array($this, 'FQM_Quizzes_callback')  // callback function for the page
        );
        // Add a submenu page for "Add New Quiz"
        add_submenu_page(
            'full-quiz-maker',                 // parent menu slug
            'Add New Quiz',                    // page title
            'Add New Quiz',                    // menu title
            'manage_options',                  // capability required to access
            'add-new-quiz',                    // menu slug
            array($this, 'FQM_addNewQuiz_callback')  // callback function for the page
        );

        add_submenu_page(
            'full-quiz-maker',                 // parent menu slug
            'single quiz',                    // page title
            'single quiz',                    // menu title
            'manage_options',                  // capability required to access
            'single-quiz.php',                    // menu slug
            array($this, 'FQM_singleQuiz_callback')  // callback function for the page
        );

        // Remove the submenu page that you want to hide
        remove_submenu_page('full-quiz-maker', 'full-quiz-maker');
    }

    // Callback method for the Quizzes page
    public function FQM_Quizzes_callback()
    {
        include 'Quizzes.php';
    }

    // Callback method for the Quizzes page
    public function FQM_addNewQuiz_callback()
    {
        include 'pages/add-new-quiz.php';
    }

    // Callback method for the Quizzes page
    public function FQM_singleQuiz_callback()
    {
        include 'pages/single-quiz.php';
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

    //Add Questions to Question Bank
    public function FQM_add_questions()
    {
        global $wpdb;
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["questions_data"])) {
            $questions_data_array = json_decode(stripslashes($_POST["questions_data"]), true);
            $form_type = $questions_data_array['type'];

            if ($form_type == 'Edit') {
                $question_id = sanitize_text_field($questions_data_array['question_id']);

                $table_questions = $wpdb->prefix . "FQM_questions";
                $table_answers = $wpdb->prefix . "FQM_defaultanswers";
                // Delete Qusetion answers
                $wpdb->delete($table_answers, array("poll_id" => $question_id));
                // Delete from  Question
                $wpdb->delete($table_questions, array("poll_id" => $question_id));

            }
            $questions = $questions_data_array['questions'];

            foreach ($questions as $question) {
                $question_text = $question['question_text'];
                $question_type = $question['question_type'];
                $question_attachments_data = $question['question_attachments_data'];
            
                // Create an array for question data
                $question_data = array(
                    'question_text' => sanitize_text_field ($question_text),
                    'question_type' =>sanitize_text_field ( $question_type),
                    'question_attachments_data' => sanitize_text_field ($question_attachments_data),
                );
            
                // Check if it's an Edit or Insert operation
                if ($form_type == 'Edit') {
                    $question_id = $question['question_id']; // Assuming you have question_id in your data
                    $wpdb->update($wpdb->prefix . 'FQM_questions', $question_data, array('question_id' => $question_id));
                } else {
                    $wpdb->insert($wpdb->prefix . 'FQM_questions', $question_data);
                    $question_id = $wpdb->insert_id;
                }
                $answers = $question['answers'];
                foreach ($answers as $answer) {
                    $answer_text = sanitize_text_field ($answer['answer_text']);
                    $answer_is_correct = sanitize_text_field ($answer['answer_is_correct']);
                    $sequenceData = sanitize_text_field ($answer['sequence']);

                    // Insert the answer into the FQM_defaultanswers table
                    $insert_answer_query = $wpdb->prepare(
                        "INSERT INTO {$wpdb->prefix}FQM_defaultanswers (answer_text, answer_is_correct, sequenceData ,question_id) VALUES (%s, %d, %d, %d)",
                        $answer_text,
                        $answer_is_correct,
                        $sequenceData,
                        $question_id
                    );
                    $wpdb->query($insert_answer_query);
                }
            }

        }

    }

    // Add Quiz and Questions to Quiz 
    public function FQM_add_quiz() 
    {
        global $wpdb;
    
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        // Check if the request method is POST and questions_data is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["questions_data"])) {
            $quiz_data_array = json_decode(stripslashes($_POST["quiz_data"]), true);
            $form_type = $quiz_data_array['type'];
    
            // Quiz data
            $quiz_name = sanitize_text_field($quiz_data_array['quiz_name']);
            $quiz_description = sanitize_text_field($quiz_data_array['quiz_description']);
            $quiz_created_date = sanitize_text_field($quiz_data_array['quiz_created_date']);
            $quiz_end_date = sanitize_text_field($quiz_data_array['quiz_end_date']);
            $quiz_status = sanitize_text_field($quiz_data_array['quiz_status']);
            $quiz_time = sanitize_text_field($quiz_data_array['quiz_time']);
            $quiz_duration = sanitize_text_field($quiz_data_array['quiz_duration']);
            $quiz_type = sanitize_text_field($quiz_data_array['quiz_type']);
            $class_id = intval($quiz_data_array['class_id']);
            $year_id = intval($quiz_data_array['year_id']);
            $level_id = intval($quiz_data_array['level_id']);
    
            if ($form_type == 'Edit') {
                $quiz_id = intval($quiz_data_array['quiz_id']);
    
                // Update quiz details
                $wpdb->update(
                    $wpdb->prefix . 'FQM_Quizzes',
                    array(
                        'quiz_name' => $quiz_name,
                        'quiz_description' => $quiz_description,
                        'quiz_created_date' => $quiz_created_date,
                        'quiz_end_date' => $quiz_end_date,
                        'quiz_status' => $quiz_status,
                        'quiz_time' => $quiz_time,
                        'quiz_duration' => $quiz_duration,
                        'quiz_type' => $quiz_type,
                        'quiz_seed_random' => 7,
                        'class_id' => $class_id,
                        'year_id' => $year_id,
                        'level_id' => $level_id,
                    ),
                    array('quiz_id' => $quiz_id)
                );
            } else {
                // Insert new quiz
                $wpdb->insert(
                    $wpdb->prefix . 'FQM_Quizzes',
                    array(
                        'quiz_name' => $quiz_name,
                        'quiz_description' => $quiz_description,
                        'ID' => get_current_user_id(),
                        'quiz_created_date' => $quiz_created_date,
                        'quiz_end_date' => $quiz_end_date,
                        'quiz_status' => $quiz_status,
                        'quiz_time' => $quiz_time,
                        'quiz_duration' => $quiz_duration,
                        'quiz_type' => $quiz_type,
                        'quiz_seed_random' => 9,
                        'class_id' => $class_id,
                        'year_id' => $year_id,
                        'level_id' => $level_id,
                    )
                );
                $quiz_id = $wpdb->insert_id; // Get the newly inserted quiz_id
            }
    
            // Quiz questions data
            $questions_in_quiz = $quiz_data_array['questions'];
    
            foreach ($questions_in_quiz as $question) {
                $question_id = intval($question['question_id']);
                $question_mark = intval($question['question_points']);
                $question_answer_seed_random = 5;
    
                // Check if it's an Edit or Insert operation for quiz questions
                if ($form_type == 'Edit') {
                    //delete question from quiz
                    $wpdb->delete(
                        $wpdb->prefix . 'FQM_quizQuestions',
                        array(
                            'quiz_id' => $quiz_id,
                        )
                    );
                } 
                // Insert new quiz question
                $wpdb->insert(
                    $wpdb->prefix . 'FQM_quizQuestions',
                    array(
                        'quiz_id' => $quiz_id,
                        'question_id' => $question_id,
                        'question_mark' => $question_mark,
                        'question_answer_seed_random' => $question_answer_seed_random,
                    )
                );
                
            }
        }
    }
    // Archive Quiz
    public function FQM_archive_quiz()
    {
        global $wpdb;
    
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        // Check if the request method is POST and quiz_id is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
            $quiz_id = intval($_POST["quiz_id"]);
    
            // Update quiz status to archived
            $wpdb->update(
                $wpdb->prefix . 'FQM_Quizzes',
                array(
                    'quiz_status' => 'archived',
                ),
                array('quiz_id' => $quiz_id)
            );
        }
    }
    // Restore Quiz
    public function FQM_restore_quiz()
    {
        global $wpdb;
    
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        // Check if the request method is POST and quiz_id is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
            $quiz_id = intval($_POST["quiz_id"]);
    
            // Update quiz status to active
            $wpdb->update(
                $wpdb->prefix . 'FQM_Quizzes',
                array(
                    'quiz_status' => 'active',
                ),
                array('quiz_id' => $quiz_id)
            );
        }
    }
    // Delete Quiz
    public function FQM_permenent_delete_quiz() 
    {
        global $wpdb;
    
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
    
        // Check if the request method is POST and quiz_id is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["quiz_id"])) {
            $quiz_id = intval($_POST["quiz_id"]);
        
            // Delete quiz questions
            $wpdb->delete(
                $wpdb->prefix . 'FQM_quizQuestions',
                array(
                    'quiz_id' => $quiz_id,
                )
            );
            // Delete quiz
            $wpdb->delete(
                $wpdb->prefix . 'FQM_Quizzes',
                array(
                    'quiz_id' => $quiz_id,
                )
            );

        }
    }
    // Send Email For Students in the Group with Code
    public function FQM_email_students()
    {
        global $wpdb;
        // Verify nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
            wp_send_json_error('Invalid nonce.');
        }
        // Check if the request method is POST and quiz_id is set
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["class_id"])) {
            $class_id = intval($_POST["class_id"]);
            //Get the student emails for the class
            $query = $wpdb->prepare(
                "SELECT user_email
                    FROM {$wpdb->prefix}users 
                    WHERE ID IN (
                        SELECT ID 
                        FROM {$wpdb->prefix}FQM_studentinGroups 
                        WHERE class_id = %d
                    ) and ID IN (
                        SELECT user_id 
                        FROM {$wpdb->prefix}usermeta 
                        WHERE meta_key = 'wp_capabilities' 
                        AND meta_value LIKE '%student%'
                    )",
                $class_id
            );
        
            $student_emails = $wpdb->get_results($query);


            foreach ($student_emails as $student) {
                $to = $student;
                $subject = sanitize_text_field($_POST['email_subject']);
                $body = sanitize_text_field( $_POST['email_body']);
                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail( $to, $subject, $body, $headers );
            }
        }
    }
    // ShortCode For Profile Page of Student
    public function FQM_student_profile()
    {
        global $wpdb ;
        $user_id = get_current_user_id();

        $user_info = get_userdata($user_id);


        //Add this shortcode if the user is a student

        if (in_array('student', $user_info->roles)) {
            $output = '<div class="container">';
            $output .= '<div class="row">';
            $output .= '<div class="col-md-12">';
            $output .= '<h1 class="text-center">Welcome ' . $user_info->first_name . ' ' . $user_info->last_name . '</h1>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="row">';
            $output .= '<div class="col-md-12">';
            $output .= '<h2 class="text-center">Your Classes</h2>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="row">';
            $output .= '<div class="col-md-12">';
            $output .= '<table class="table table-striped">';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th scope="col">Class Name</th>';
            $output .= '<th scope="col">Class Code</th>';
            $output .= '<th scope="col">Class Teacher</th>';
            $output .= '<th scope="col">Class Year</th>';
            $output .= '<th scope="col">Class Level</th>';
            $output .= '</tr>';
            $output .= '</thead>';
            $output .= '<tbody>';
            $output .=  $wpdb->get_results("SELECT class_id FROM {$wpdb->prefix}FQM_studentinGroups WHERE ID = $user_id", ARRAY_A);
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

        
    }
    // ShortCode For Profile Page of Teacher
    public function FQM_teacher_profile()
    {
        global $wpdb ;
        $user_id = get_current_user_id();

        $user_info = get_userdata($user_id);

         
    }

    function rcs_get_attachment_id_from_url($attachment_url){
        global $wpdb;
        $upload_dir_paths = wp_upload_dir();
        if(strpos($attachment_url, $upload_dir_paths['baseurl']) !== false){
            $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
            
            $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
            
            $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM ".$wpdb->posts." wposts, ".$wpdb->postmeta." wpostmeta 
                                                            WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' 
                                                            AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
                                                            
            return $attachment_id;
        }
        return false;
    }
    
    function get_medium_image(){
        $attch_url = (isset($_POST['attch_url']))? $_POST['attch_url'] : '';
        if(!empty($attch_url)){
            $attch_id = self::rcs_get_attachment_id_from_url(urldecode($attch_url));
            if($attch_id){
                $img = wp_get_attachment_image_src($attch_id, 'medium');
                if(empty($img[0])){
                    $img = wp_get_attachment_image_src($attch_id, 'small');
                }
                echo $attch_id.'--++##++--'.$img[0];
            }
        }
        die();
    }
}

$FullQuizMaker  = new FullQuizMaker();
