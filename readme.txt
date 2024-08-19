=== City Weather Report ===
Contributors: Shane Muirhead
Donate link:
Tags: weather, city weather, weather report, shortcode, geolocation
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
City Weather Report is a simple and flexible WordPress plugin that allows you to display the current weather for a specified city using a shortcode. You can also enable geolocation to dynamically display the weather based on the visitor's location. The plugin supports temperature display in Fahrenheit, Celsius, or both. The OpenWeatherMap API key is required and can be configured directly in the WordPress General Settings page.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/city-weather-report` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to the 'Settings' > 'General' page in the WordPress admin and enter your OpenWeatherMap API key in the provided field.
4. Use the provided shortcode `[city_weather]` in any post or page to display the weather report.

== Usage ==
1. **Shortcode**: Use `[city_weather]` to display the weather for a specific city.

   Example:
[city_weather city="Leeds" state="" use_geolocation="false" show_humidity="true" temp_type="Celsius"]

**Attributes**:
- `city`: (Optional) The city for which you want to display the weather. Default is `Leeds`.
- `state`: (Optional) The state or region for the city. Can be left empty for non-US locations.
- `use_geolocation`: (Optional) Set to `true` to use the visitor's geolocation to determine the city. Default is `false`.
- `show_humidity`: (Optional) Set to `true` to display the humidity in the weather report. Default is `false`.
- `temp_type`: (Optional) Set to `Fahrenheit`, `Celsius`, or `Both` to choose the temperature display format. Default is `Fahrenheit`.

== Frequently Asked Questions ==

= How do I display the weather for a specific city? =
Use the `[city_weather]` shortcode with the `city` and `state` attributes to specify the location. For example: `[city_weather city="Leeds" state=""]`.

= How do I configure the OpenWeatherMap API key? =
Navigate to the 'Settings' > 'General' page in the WordPress admin, where you'll find a field to enter your OpenWeatherMap API key.

= Can I display the weather based on the user's location? =
Yes, set the `use_geolocation` attribute to `true` in the shortcode to use the visitor's geolocation for determining the city.

= How do I display the temperature in Celsius? =
Set the `temp_type` attribute to `Celsius` in the shortcode. For example: `[city_weather temp_type="Celsius"]`.

= Is it possible to show both Fahrenheit and Celsius? =
Yes, set the `temp_type` attribute to `Both` in the shortcode to display both temperature units.

= Can I display the humidity in the weather report? =
Yes, set the `show_humidity` attribute to `true` in the shortcode to include humidity in the report.

== Changelog ==
= 1.0 =
* Initial release of City Weather Report plugin.

== Upgrade Notice ==
= 1.0 =
* First release.

== License ==
This plugin is licensed under the GPLv2 or later. See the [License URI](https://www.gnu.org/licenses/gpl-2.0.html) for details.
