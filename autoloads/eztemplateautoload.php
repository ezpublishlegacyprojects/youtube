<?php

// Operator autoloading

$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] =
  array( 'script' => 'extension/youtube/autoloads/youtube_tag_search.php',
         'class' => 'YoutubeTagSearch',
         'operator_names' => array( 'youtube_tag_search' ) );

?>