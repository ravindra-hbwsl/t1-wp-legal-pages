<?php

/**
 * The file that defines the core WP Legal Pages class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wplegalpages.com/
 * @since      1.5.2
 *
 * @package    WP_Legal_Pages
 * @subpackage WP_Legal_Pages/includes
 */

/**
 * The core WP Legal Pages class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this WP Legal Pages as well as the current
 * version of the WP Legal Pages.
 *
 * @since      1.5.2
 * @package    WP_Legal_Pages
 * @subpackage WP_Legal_Pages/includes
 * @author     WPEka <support@wplegalpages.com>
 */
class WP_Legal_Pages {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the WP Legal Pages.
	 *
	 * @since    1.5.2
	 * @access   protected
	 * @var      WP_Legal_Pages_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of WP Legal Pages.
	 *
	 * @since    1.5.2
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	public $plugin_name;

	/**
	 * The current version of the WP Legal Pages.
	 *
	 * @since    1.5.2
	 * @access   protected
	 * @var      string    $version    The current version of the WP Legal Pages.
	 */
	protected $version;

	/**
	 * Define the core functionality of the WP Legal Pages.
	 *
	 * Set the WP Legal Pages name and the WP Legal Pages version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.5.2
	 */
	public function __construct() {
            
                global $table_prefix;
		$this->plugin_name = 'wp-legal-pages';
		$this->version = '1.5.2';
                $this->tablename = $table_prefix . "legal_pages";
                $this->popuptable = $table_prefix . "lp_popups";
//                die();
//		$this->load_dependencies();
//		$this->set_locale();
		$this->define_admin_hooks();
//		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for WP Legal Pages.
	 *
	 * Include the following files that make up the WP Legal Pages:
	 *
	 * - WP_Legal_Pages_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Legal_Pages_i18n. Defines internationalization functionality.
	 * - WP_Legal_Pages_Admin. Defines all hooks for the admin area.
	 * - WP_Legal_Pages_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.5.2
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core WP_Legal_Pages.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-legal-pages-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the WP_Legal_Pages.
		 */
//		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-plugin-name-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-legal-pages-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
//		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-plugin-name-public.php';

		$this->loader = new WP_Legal_Pages_Loader();

	}

	/**
	 * Define the locale for this WP_Legal_Pages for internationalization.
	 *
	 * Uses the WP_Legal_Pages_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.5.2
	 * @access   private
	 */
//	private function set_locale() {
//
//		$plugin_i18n = new WP_Legal_Pages_i18n();
//
//		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
//
//	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the WP_Legal_Pages.
	 *
	 * @since    1.5.2
	 * @access   private
	 */
	private function define_admin_hooks() {

		add_action('admin_menu', array($this, 'admin_menu'));
                 include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-legal-pages-admin.php';  
//                $plugin_admin = new WP_Legal_Pages_Admin( $this->get_plugin_name(), $this->get_version() );                
//		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
//		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                
                
	}
        
        /**
         * 
         * 
         * 
         */
        
        function admin_menu()
        {
                add_menu_page(__('Legal Pages','legal-pages'), 'Legal Pages', 'manage_options', 'legal-pages', array($this, 'admin_setting'));
                $terms = get_option('lp_accept_terms');
                if($terms == 1){
                        add_submenu_page(__('legal-pages','legal-pages'), 'Settings', 'Settings', 'manage_options', 'legal-pages', array($this, 'admin_setting'));
                        add_submenu_page(__('legal-pages','legal-pages'), 'Legal Pages', 'Legal Pages', 'manage_options', 'lp-show-pages', array($this, 'show_pages'));
                        add_submenu_page(__('legal-pages','legal-pages'), 'Create Page', 'Create Page', 'manage_options', 'lp-create-page', array($this, 'create_page'));
                }
        }
        
        /**
         * 
         */
        function admin_setting()
        {
            include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin-settings.php';   
        }
        
        /**
         * 
         */
        function create_page()
        {
             include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/create-page.php';   
        }
        
        /**
         * 
         */

        function show_pages()
        {
            include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/show-pages.php';   
        }
        
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the WP_Legal_Pages.
	 *
	 * @since    1.5.2
	 * @access   private
	 */
//	private function define_public_hooks() {
//
//		$plugin_public = new WP_Legal_Pages_Public( $this->get_plugin_name(), $this->get_version() );
//
//		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
//		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
//
//	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.5.2
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the WP_Legal_Pages used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.5.2
	 * @return    string    The name of the WP_Legal_Pages.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the WP_Legal_Pages.
	 *
	 * @since     1.5.2
	 * @return    WP_Legal_Pages_Loader    Orchestrates the hooks of the WP_Legal_Pages.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the WP_Legal_Pages.
	 *
	 * @since     1.5.2
	 * @return    string    The version number of the WP_Legal_Pages.
	 */
	public function get_version() {
		return $this->version;
	}

}
