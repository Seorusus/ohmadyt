<?php
    $search = array("vidstoronennya", "info", "reestr", "perelik");
    $replace = array("release", "disciplinary", "intervention", "offense");
    $output = str_replace($search, $replace, $output);
?>
<?php print $output; ?>
