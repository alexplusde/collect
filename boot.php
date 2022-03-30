<?php

include "vendor/autoload.php"; 

if (rex_addon::get('media_manager')->isAvailable()) {
    rex_media_manager::addEffect(rex_effect_collect::class);
}

/* 
TODO

if (rex_addon::get('watson')->isAvailable()) {
 
    function feedsearch(rex_extension_point $ep){
      $subject = $ep->getSubject();
      $subject[] = 'Watson\Workflows\Feeds\FeedProvider';
      return $subject;
    }

 rex_extension::register('WATSON_PROVIDER', 'feedsearch', rex_extension::LATE); 


 */
