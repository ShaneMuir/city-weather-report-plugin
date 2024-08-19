<?php
/**
 * Plugin Name: City Weather Report
 * Description: Displays a specified city weather using a shortcode
 * Version: 1.0
 * Author: Shane Muirhead
 *
 **/

// Exit if Accessed Directly
if (!defined('ABSPATH')) {
	exit;
}

// Load Scripts
require_once(plugin_dir_path(__FILE__) . '/includes/city-weather-report-scripts.php');

// Register Shortcode
function cwr_city_weather_report_shortcode($atts): false|string {
	// Set default attributes and merge with user-defined attributes
	$atts = shortcode_atts(
		array(
			'city' => 'Leeds',
			'state' => '',
			'use_geolocation' => false,
			'show_humidity' => false,
			'temp_type' => 'Celsius'
		),
		$atts,
		'city_weather'
	);
	// Extract attributes into variables
	$city = $atts['city'];
	$state = $atts['state'];
	$options = array(
		'use_geolocation' => filter_var($atts['use_geolocation'], FILTER_VALIDATE_BOOLEAN),
		'show_humidity' => filter_var($atts['show_humidity'], FILTER_VALIDATE_BOOLEAN),
		'temp_type' => $atts['temp_type']
	);

	// Get and display weather
	return cwr_get_weather($city, $state, $options);
}

add_shortcode('city_weather', 'cwr_city_weather_report_shortcode');

// Function to get and display weather
function cwr_get_weather($city, $state, $options) {
	// Get the API key from the settings
	$apiKey = get_option('cwr_api_key');

	if (empty($apiKey)) {
		return "API key is not set. Please configure it in the General Settings.";
	}

	// Build the OpenWeatherMap API request URL
	$weather_url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=$apiKey&units=" . ($options['temp_type'] == 'Celsius' ? 'metric' : 'imperial');

	$weather_json = file_get_contents($weather_url);
	$weather_data = json_decode($weather_json, true);

	if (empty($weather_data)) {
		return "Weather data is currently unavailable. Please try again later.";
	}

	$location = $weather_data['name'] . ', ' . $weather_data['sys']['country'];
	$current_weather = $weather_data['weather'][0]['description'];
	$temp = $weather_data['main']['temp'] . " °" . ($options['temp_type'] == 'Celsius' ? 'C' : 'F');
	$humidity = $weather_data['main']['humidity'];
	$icon_url = "http://openweathermap.org/img/wn/" . $weather_data['weather'][0]['icon'] . "@2x.png";

	ob_start();
	?>
    <div class="city-weather">
        <h3><?php echo esc_html($location); ?></h3>
        <h1><?php echo esc_html($temp); ?></h1>
        <p><?php echo esc_html(ucwords($current_weather)); ?></p>
        <img src="<?php echo esc_url($icon_url); ?>" alt="Weather Icon">
		<?php if ($options['show_humidity']) : ?>
            <div>
                <strong>Humidity: <?php echo esc_html($humidity); ?>%</strong>
            </div>
		<?php endif; ?>
    </div>
	<?php
	return ob_get_clean();
}

// Add the settings field to the General settings page
function cwr_register_settings() {
	// Register a new setting for the API key
	register_setting('general', 'cwr_api_key', array(
		'type' => 'string',
		'description' => 'OpenWeatherMap API Key',
		'sanitize_callback' => 'sanitize_text_field',
		'show_in_rest' => false,
	));

	// Add a new section to the General settings page
	add_settings_section(
		'cwr_settings_section', // ID
		'City Weather Report Settings', // Title
		null, // Callback, can be null if not needed
		'general' // Page where the section appears (general settings)
	);

	// Add a new field to the General settings page
	add_settings_field(
		'cwr_api_key', // ID
		'OpenWeatherMap API Key', // Title
		'cwr_api_key_field_html', // Callback function to display the field
		'general', // Page where the field appears (general settings)
		'cwr_settings_section' // Section ID where the field appears
	);
}

add_action('admin_init', 'cwr_register_settings');

// HTML for the API key input field
function cwr_api_key_field_html() {
	$apiKey = get_option('cwr_api_key', '');
	?>
	<input type="text" id="cwr_api_key" name="cwr_api_key" value="<?php echo esc_attr($apiKey); ?>" class="regular-text">
	<p class="description">Enter your OpenWeatherMap API key here.</p>
	<?php
}
