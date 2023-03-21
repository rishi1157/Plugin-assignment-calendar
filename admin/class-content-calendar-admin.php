<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rishabh.wisdmlabs.net
 * @since      1.0.0
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_Calendar
 * @subpackage Content_Calendar/admin
 * @author     Rishabh <rishabh.pandey@wisdmlabs.com>
 */
class Content_Calendar_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/content-calendar-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_Calendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_Calendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/content-calendar-admin.js', array('jquery'), $this->version, false);
	}


	public function calendar_menu()
	{
		add_menu_page(
			'Content Calendar Tool',
			'Content Calendar',
			'manage_options',
			'content-calendar',
			array($this, 'content_form'),
			'dashicons-calendar',
			15
		);
	}


	public function content_form()
	{
		echo "<h1>";
		esc_html_e(get_admin_page_title());
		echo "</h1>";
?>
		<form class="cc_form" method="post">
			<input type="hidden" name="action">
			
			<div class="cc_item">
				<label class="cc_label" for="date">Date:&emsp;&emsp;&emsp;&emsp;</label>
				<input type="date" name="date" required><br><br>
			</div>

			<div class="item">
				<label class="cc_label" for="occasion">Occasion:&emsp;&emsp;</label>
				<input type="text" name="occasion" required><br><br>
			</div>
			
			<div class="item">
				<label class="cc_label" for="title">Title:&emsp;&emsp;&emsp;&emsp;</label>
				<input type="text" name="title" required><br><br>
			</div>

			<div class="item">
			<label class="cc_label" for="author">Author:&emsp;&emsp;&emsp;</label>
			<select name="author" id="author" required>
				<?php $users = get_users(
					array('fields' => array('ID', 'display_name'))
				);
				foreach ($users as $user) {
					echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
				}
				?>
			</select><br><br>
			</div>

			<div class="item">
			<label class="cc_label" for="reviewer">Reviewer:&emsp;&emsp;</label>
			<select name="reviewer" id="reviewer" required>
				<?php $users = get_users(
					array('fields' => array('ID', 'display_name'))
				);
				foreach ($users as $user) {
					echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
				}
				?>
			</select><br><br>
			</div>

			<?php submit_button('Submit'); ?>
		</form>
<?

		if (isset($_POST['submit'])) {
			$this -> insert_data_into_table();
			$this -> view_content_table();
		}
	}

	public function insert_data_into_table()
	{
		global $wpdb;

		if (
			isset($_POST['date']) && isset($_POST['occasion']) &&
			isset($_POST['title']) && isset($_POST['author']) &&
			isset($_POST['reviewer'])
		) {
			$table_name = $wpdb->prefix . 'content_data';
			$date = sanitize_text_field($_POST['date']);
			$occasion = sanitize_text_field($_POST['occasion']);
			$title = sanitize_text_field($_POST['title']);
			$author = sanitize_text_field($_POST['author']);
			$reviewer = sanitize_text_field($_POST['reviewer']);
			$wpdb->insert(
				$table_name,
				array(
					'date' => $date,
					'occasion' => $occasion,
					'title' => $title,
					'author' => $author,
					'reviewer' => $reviewer
				)
			);
		}
	}

	public function view_content_table()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'content_data';

		$data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date");

		echo '<table class="cc_table">';
		echo '<tr><th>ID</th><th>Date</th><th>Occasion</th><th>Post Title</th><th>Author</th><th>Reviewer</th></tr>';
		foreach ($data as $row) 
		{
			echo '<tr>';
			echo '<td>' . $row->id . '</td>';
			echo '<td>' . $row->date . '</td>';
			echo '<td>' . $row->occasion . '</td>';
			echo '<td>' . $row->title . '</td>';
			echo '<td>' . get_userdata($row->author)->display_name . '</td>';
			echo '<td>' . get_userdata($row->reviewer)->display_name . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
}
