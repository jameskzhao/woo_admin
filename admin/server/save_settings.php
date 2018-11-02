<?php
require_once '../auth-header.php';
require_once '../functions.php';
$logo_url = $_POST['logo_url'];
$banner_url = $_POST['banner_url'];
if ($logo_url) {
    save_store_settings('logo_url', $logo_url);
}
if ($banner_url) {
    save_store_settings('banner_url', $banner_url);
}
echo json_encode(get_store_settings());
