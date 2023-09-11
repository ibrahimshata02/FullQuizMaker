<?php 

class FullQuizMaker{
    // Constructor for class includes all hooks
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'FQM_enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'FQM_add_admin_menu_link'));
        add_action('admin_bar_menu', array($this, 'FQM_toolbar_link'), 99);
        add_action('wp_enqueue_scripts', array($this, 'FQM_enqueue_frontend_scripts'));
    }

    public function FQM_enqueue_frontend_scripts()
    {

        wp_enqueue_script('jquery');
        wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . '/js/main.js', array('jquery'), '1.7', true);
        wp_localize_script('plugin-custom', 'my_ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_ajax_nonce'),
        ));
        wp_enqueue_style('dashboard-styles', plugin_dir_url(__FILE__) . 'css/custom-styles.css', array(), "1.9");
    }

    // Enqueue scripts and styles for the admin area
    public function FQM_enqueue_admin_scripts()
    {
        //enqueue Script files
        if ((isset($_GET['page']) && (($_GET['page'] === 'poll-survey-xpress-surveys' || $_GET['page'] === 'poll-survey-xpress-recycle' || $_GET['page'] === 'poll-survey-xpress-add' || $_GET['page'] === 'poll-survey-xpress-settings' || $_GET['page'] === 'view_template_page' || $_GET['page'] === 'edit_template_page' || $_GET['page'] === 'poll-survey-xpress-recycle' || $_GET['page']
            === 'show_template_page')))|| true) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('plugin-custom', plugin_dir_url(__FILE__) . '/js/main.js', array('jquery'), '2.0', true);

            wp_localize_script('plugin-custom', 'my_ajax_object', array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('my_ajax_nonce'),
            ));
            wp_enqueue_style('dashboard-styles', plugin_dir_url(__FILE__) . 'css/custom-styles.css', array(), "1.6");
        }
    }

    // Add main menu page (FullQuizMaker)
    public function FQM_add_admin_menu_link()
    {
        add_menu_page(
            'FullQuizMaker',                  // the page title of Plugin
            'FullQuizMaker',                  // the Title that appears in the menu bar
            'manage_options',               // permissions that can see the menu (admin OR higher) => capability
            'full-quiz-maker',             // unique menu slug
            array($this, 'FQM_Quizzes_callback'),    // method for output
            'dashicons-text-page', // You can add the link of custom icon 
            70
        );
        
        remove_submenu_page('full-quiz-maker', 'full-quiz-maker');
    }

    // Callback method for the Recycle Bin page
    public function FQM_Quizzes_callback()
    {
        include 'Quizzes.php';
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
}
$FullQuizMaker  = new FullQuizMaker();
?>