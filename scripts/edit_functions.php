<?php
function save_updated_info($id, $title, $width, $height, $month, $day, $year, $categories, $sold) {

    $file_path = 'uploads/generated_list.json';

    if (!file_exists($file_path)) {
        return;
    }

    $json_data = json_decode(file_get_contents($file_path), true);
    if (!is_array($json_data) || !isset($json_data['paintings'])) {
        error_log('save_updated_info: uploads/generated_list.json is not valid JSON; aborting save to avoid data loss.');
        return;
    }

    foreach ($json_data['paintings'] as &$artwork) {
        if ($artwork['id'] === $id) {
            $artwork['title'] = $title;
            $artwork['width'] = $width;
            $artwork['height'] = $height;
            $artwork['month'] = $month;
            $artwork['day'] = $day;
            $artwork['year'] = $year ? $year : '2023';
            $artwork['categories'] = array_values($categories);
            $artwork['sold'] = ($sold === 'true' || $sold === true);
            break;
        }
    }
    unset($artwork);

    file_put_contents($file_path, json_encode($json_data, JSON_PRETTY_PRINT));
}

function remove_this_painting($id) {

    $file_path = 'uploads/generated_list.json';

    if (!file_exists($file_path)) {
        return 'File does not exist.';
    }

    $json_data = json_decode(file_get_contents($file_path), true);
    if (!is_array($json_data) || !isset($json_data['paintings'])) {
        return 'Error: uploads/generated_list.json is not valid JSON.';
    }

    $json_data['paintings'] = array_values(array_filter($json_data['paintings'], function ($artwork) use ($id) {
        return $artwork['id'] !== $id;
    }));

    file_put_contents($file_path, json_encode($json_data, JSON_PRETTY_PRINT));

    $fileToDelete = 'uploads/artwork/' . $id . '.jpg';

    $message = 'Success';
    if (file_exists($fileToDelete)) {
        if (unlink($fileToDelete)) {
            $message = 'Success';
        } else {
            $message = 'Error deleting file.';
        }
    } else {
        $message = 'File does not exist.';
    }

    return $message;
}