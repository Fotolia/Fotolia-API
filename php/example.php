#!/usr/bin/env php
<?php

require_once 'fotolia_api.php';

$api = new Fotolia_Api('your_api_key');

// searching for files
$results = $api->getSearchResults(
    array(
        'words' => 'car',
        'language_id' => Fotolia_Api::LANGUAGE_ID_EN_US,
        'limit' => 1,
    ));

printf("Found %d results", $results['nb_results']);

foreach ($results as $key => $value) {
    // iterating only over numeric keys and silently skip other keys
    if (is_numeric($key)) {
        printf("matching media ID: %d", $value['id']);
    }
}

// loggin in and retrieving user data
$api->loginUser('your_login', 'your_password');
print_r($api->getUserData());

// purchasing and downloading a file
$dl_data = $api->getMedia(35957426, 'XS');
$api->downloadMedia($dl_data['url'], '/tmp/' . $dl_data['name']);
