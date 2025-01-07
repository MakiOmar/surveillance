<?php //phpcs:disable WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
/**
 * Prevent direct access to the file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Class DeviceTypeController
 *
 * Handles operations related to patient records.
 */
class DeviceTypeController extends BaseController {
	/**
	 * Fetch paginated patients for display in a Bootstrap table.
	 *
	 * The output is handled by a separate view file.
	 *
	 * @return mixed Outputs the rendered view with paginated patient data.
	 */
	public function fetchTypes() {
		$types = DeviceType::all();
		return $types;
	}
}
