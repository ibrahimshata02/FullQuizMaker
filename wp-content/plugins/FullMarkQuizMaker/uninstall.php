<?php

// Check if the uninstall constant is defined to prevent direct access to this file
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Load WordPress database configuration
require_once(ABSPATH . 'wp-config.php');

// Drop the plugin's tables if clear_data option is not zero
global $wpdb;

$clearDataOptionValue = get_option('FQM_clear_data');

if ($clearDataOptionValue !== '0') {
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_StudentAnswers");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_StudentQuizAttempts");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_defaultanswers");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_quizQuestions");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_questions");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_Quizzes");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_studentinGroups");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_classes");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_level");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}FQM_year");

}