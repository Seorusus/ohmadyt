<?php

    $addonStyle = isset($row->field_field_youtube[0]['raw']['video_id']) ?
        "background-position: center -28px;" : "";

    $imageUrl = isset($row->field_field_youtube[0]['raw']['video_id']) ?
        "https://img.youtube.com/vi/" . $row->field_field_youtube[0]['raw']['video_id'] . "/0.jpg" :
        (strlen($output) > 0 ? image_style_url('222x222', $output) : "");

    $background = strlen($imageUrl) > 0 ? 
        "background-image: url(" . $imageUrl . ");" : 
        "background: #d9d9d9;";
?>
<div style="<?php print $background.$addonStyle ?>"></div>
