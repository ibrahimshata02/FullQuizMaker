<?php
/*
Plugin Name:  #FullMarkQuizMaker
Plugin URI:   https://codepress.ps/
Description:  Full Mark Quiz Maker Plugin
Text Domain: Full-Mark-Quiz-Maker
Version:      1.0
Author:       CODEPRESS IT Solutions
Author URI:   https://codepress.ps/
*/

add_action('init', 'FMQ_load_textdomain');
function FMQ_load_textdomain()
{
    load_plugin_textdomain('Full-Mark-Quiz-Maker', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


$plugin_name = plugin_basename(__FILE__);
add_filter('plugin_action_links_' . $plugin_name, 'FMQ_settings_link');
function FMQ_settings_link($links)
{
    // Build and escape the URL.
    $url = esc_url(
        add_query_arg(
            'page',
            'add-new-quiz',
            get_admin_url() . 'admin.php'
        )
    );

    // Create the link.
    $settings_link = "<a href='$url'>" . __('Settings') . '</a>';

    // Adds the link to the end of the array.
    array_unshift($links, $settings_link);

    return $links;
}

function FMQ_add_database_tables()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $option_name = 'installation_time_of_FullMarkQuizMakerPlugin';

    // Check if the option already exists
    $existing_option = get_option($option_name);

    if (!$existing_option) {
        // Option doesn't exist, so add it with the current time
        $current_time = current_time('mysql');

        add_option($option_name, $current_time);
    }

    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    // Create FQM_year table
    $table_FQM_year = $wpdb->prefix . 'FQM_year';
    $sql_FQM_year = "CREATE TABLE IF NOT EXISTS $table_FQM_year (
        year_id INT(11) NOT NULL AUTO_INCREMENT,
        year_title VARCHAR(255) NOT NULL,
        PRIMARY KEY (year_id)
    ) $charset_collate;";

    // Create FQM_level table
    $table_FQM_level = $wpdb->prefix . 'FQM_level';
    $sql_FQM_level = "CREATE TABLE IF NOT EXISTS $table_FQM_level (
        level_id INT(11) NOT NULL AUTO_INCREMENT,
        level VARCHAR(255) NOT NULL,
        year_id INT(11) NOT NULL,
        PRIMARY KEY (level_id),
        FOREIGN KEY (year_id) REFERENCES $table_FQM_year(year_id)
    ) $charset_collate;";

    // Create FQM_user_years table
    $table_FQM_user_years = $wpdb->prefix . 'FQM_user_years';
    $sql_FQM_user_years = "CREATE TABLE IF NOT EXISTS $table_FQM_user_years (
        year_id INT(11),
        user_reference INT,
        PRIMARY KEY (year_id, user_reference),
        FOREIGN KEY (year_id) REFERENCES $table_FQM_year(year_id)
    ) $charset_collate;";

    $table_FQM_user_levels = $wpdb->prefix . 'FQM_user_levels';
    $sql_FQM_user_levels = "CREATE TABLE IF NOT EXISTS $table_FQM_user_levels (
        level_id INT(11),
        user_reference INT,
        PRIMARY KEY (level_id, user_reference),
        FOREIGN KEY (level_id) REFERENCES $table_FQM_level(level_id)
    ) $charset_collate;";


    $table_classes = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_classes (
        class_id int(11) NOT NULL AUTO_INCREMENT,
        class_name varchar(255) NOT NULL,
        class_description varchar(255) NOT NULL,
        year_id int(11) NOT NULL,
        level_id int(11) NOT NULL,
        ID bigint(20) unsigned NOT NULL,
        FOREIGN KEY (year_id) REFERENCES {$wpdb->prefix}FQM_year(year_id),
        FOREIGN KEY (level_id) REFERENCES {$wpdb->prefix}FQM_level(level_id),
        FOREIGN KEY (ID) REFERENCES {$wpdb->prefix}users(ID), 
        PRIMARY KEY  (class_id)
    ) $charset_collate;";

    $table_studentinGroups = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_studentinGroups (
        temp_id int(11) NOT NULL AUTO_INCREMENT,
        class_id int(11) NOT NULL,
        ID bigint(20) unsigned NOT NULL,
        FOREIGN KEY (ID) REFERENCES {$wpdb->prefix}users(ID),  -- Use uppercase ID here
        FOREIGN KEY (class_id) REFERENCES {$wpdb->prefix}FQM_classes(class_id),
        PRIMARY KEY (temp_id)
    ) $charset_collate;";

    $table_Quizzes = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_Quizzes (
        quiz_id int(11) NOT NULL AUTO_INCREMENT,
        quiz_name varchar(255) NOT NULL,
        quiz_description varchar(255) NOT NULL,
        ID bigint(20) unsigned NOT NULL,
        quiz_created_date date NOT NULL,
        quiz_end_date date NOT NULL,
        quiz_status varchar(255) NOT NULL,
        quiz_time time NOT NULL,
        quiz_duration time NOT NULL,
        quiz_type varchar(255) NOT NULL,
        quiz_seed_random varchar(255) NOT NULL,
        class_id int(11) NOT NULL,
        year_id int(11) NOT NULL,
        level_id int(11) NOT NULL,
        FOREIGN KEY (class_id) REFERENCES {$wpdb->prefix}FQM_classes(class_id),
        FOREIGN KEY (ID) REFERENCES {$wpdb->prefix}users(ID), 
        FOREIGN KEY (year_id) REFERENCES {$wpdb->prefix}FQM_year(year_id),
        FOREIGN KEY (level_id) REFERENCES {$wpdb->prefix}FQM_level(level_id),
        PRIMARY KEY  (quiz_id)
    ) $charset_collate;";

    $table_questions = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_questions (
        question_id int(11) NOT NULL AUTO_INCREMENT,
        question_text varchar(255) NOT NULL,
        question_type varchar(255) NOT NULL,
        question_attachments_data varchar(255) NOT NULL,
        PRIMARY KEY  (question_id)
    ) $charset_collate;";

    $table_quizQuestions = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_quizQuestions (
        temp_id int(11) NOT NULL AUTO_INCREMENT,
        quiz_id int(11) NOT NULL,
        question_id int(11) NOT NULL,
        question_mark int(11) NOT NULL,
        question_answer_seed_random int (11) NOT NULL,
        FOREIGN KEY (quiz_id) REFERENCES {$wpdb->prefix}FQM_Quizzes(quiz_id),
        FOREIGN KEY (question_id) REFERENCES {$wpdb->prefix}FQM_questions(question_id),
        PRIMARY KEY  (temp_id)
    ) $charset_collate;";

    $table_defaultanswers = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_defaultanswers (
        answer_id int(11) NOT NULL AUTO_INCREMENT,
        answer_text varchar(255) NOT NULL,
        answer_is_correct boolean NOT NULL,
        sequenceData varchar(255) NOT NULL,
        question_id int(11) NOT NULL,
        FOREIGN KEY (question_id) REFERENCES {$wpdb->prefix}FQM_questions(question_id),
        PRIMARY KEY  (answer_id)
    ) $charset_collate;";


    $table_StudentQuizAttempts = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_StudentQuizAttempts (
        attempt_id int(11) NOT NULL AUTO_INCREMENT,
        ID bigint(20) unsigned NOT NULL,
        quiz_id int(11) NOT NULL,
        quiz_attempt_date date NOT NULL,
        quiz_attempt_time time NOT NULL,
        quiz_attempt_duration time NOT NULL,
        quiz_attempt_mark float(11) NOT NULL,
        progress_status float(11) NOT NULL,
        FOREIGN KEY (ID) REFERENCES {$wpdb->prefix}users(ID), 
        FOREIGN KEY (quiz_id) REFERENCES {$wpdb->prefix}FQM_Quizzes(quiz_id),
        PRIMARY KEY  (attempt_id)
    ) $charset_collate;";


    $table_StudentAnswers = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}FQM_StudentAnswers (
        temp_id int(11) NOT NULL AUTO_INCREMENT,
        attempt_id int(11) NOT NULL,
        question_id int(11) NOT NULL,
        answer_id int(11) NOT NULL,
        short_answer_text varchar(255),
        FOREIGN KEY (attempt_id) REFERENCES {$wpdb->prefix}FQM_StudentQuizAttempts(attempt_id),
        FOREIGN KEY (question_id) REFERENCES {$wpdb->prefix}FQM_questions(question_id),
        FOREIGN KEY (answer_id) REFERENCES {$wpdb->prefix}FQM_defaultanswers(answer_id),
        PRIMARY KEY (temp_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_FQM_year);
    dbDelta($sql_FQM_level);
    dbDelta($sql_FQM_user_years);
    dbDelta($table_classes);
    dbDelta($sql_FQM_user_levels);
    dbDelta($table_studentinGroups);
    dbDelta($table_Quizzes);
    dbDelta($table_questions);
    dbDelta($table_quizQuestions);
    dbDelta($table_defaultanswers);
    dbDelta($table_StudentQuizAttempts);
    dbDelta($table_StudentAnswers);


    update_option('FQM_current_year', 2023);
    $existing_student_role = get_role('student');

    if (!$existing_student_role) {
        // Create the 'student' role
        add_role('student', 'Student', array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ));
    }

    // Check if the 'teacher' role already exists
    $existing_teacher_role = get_role('teacher');

    if (!$existing_teacher_role) {
        // Create the 'teacher' role
        add_role('teacher', 'Teacher', array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
        ));
    }
}
register_activation_hook(__FILE__, 'FMQ_add_database_tables');
global $wpdb;
$year_table = $wpdb->prefix . 'FQM_year';

$allowed_to_run = true;

if ($wpdb->get_var("SHOW TABLES LIKE '$year_table'") !== $year_table) {
    $allowed_to_run = false;
}

if ($allowed_to_run) {
    require_once(plugin_dir_path(__FILE__) . 'functions.php');
    require_once 'vendor/autoload.php';
} else {
    add_action('after_plugin_row', 'FMQ_custom_after_plugin_row_content', 10, 3);
}
// Add custom content after a plugin's row in plugin settings page
function FMQ_custom_after_plugin_row_content($plugin_file, $plugin_data, $status)
{
    // Get the folder name and file name from $plugin_basename
    $plugin_basename = plugin_basename(__FILE__);
    $folder_name = dirname($plugin_basename);
    $file_name = basename($plugin_basename);

    // Check if the plugin matches the desired plugin
    if ($file_name === basename($plugin_file) && $folder_name === dirname($plugin_file)) {
        echo '<tr class="plugin-update-tr">
            <td colspan="3" class="plugin-update colspanchange">
                <div class="update-message notice inline notice-info notice-alt">
                    <p>🚨 The Plugin cannot work because the required tables were not created successfully OR the plugin can`t add the roles to users table. Please check your database privileges and then deactivate and activate the plugin again.  </p>
                </div>
            </td>
        </tr>';
    }
}
