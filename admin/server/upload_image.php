<?php
require_once(__DIR__ . '/../../wp-load.php');
header('Content-Type: application/json');

$uploadedfile = $_FILES['myFile'];
$error = $uploadedfile['error'];
$photo_size = $uploadedfile['size'];

if (isset($error) && $error != '') {
	$error_code = 10;
	$error_message = $error;
} else {
	if ($photo_size > 20000 * 1024) {
		$error_code = 1;
		$error_message = "Image size is greater than 2 MB";
	} else {
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		$movefile = wp_handle_upload($uploadedfile, array('test_form' => false));
		if ($movefile && !isset($movefile['error'])) {
			$filename = $movefile['file'];
			$attachment = array(
				'post_mime_type' => $movefile['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				'post_content' => '',
				'post_status' => 'inherit',
				'guid' => $movefile['url']
			);
			$attachment_id = wp_insert_attachment($attachment, $movefile['url']);
			$attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
			wp_update_attachment_metadata($attachment_id, $attachment_data);
			if (0 < intval($attachment_id)) {
				$success = 'Y';
				$error_code = 0;
				$error_message = "Upload complete";
			}else{
				$success = 'N';
				$error_code = 1;
				$error_message = "An error occured. Attachment_id is $attachment_id";
			}
		} else {
			$error_code = 3;
			$error_message = "An error occured:" . $movefile['error'];
		}
	}
}
$return_array = array('success' => $success, 'error_code' => $error_code, 'error_message' => $error_message, 'file' => $movefile, 'request_data' => $_POST);

echo json_encode($return_array);
?>