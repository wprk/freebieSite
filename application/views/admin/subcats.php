<?php
$options = '';
foreach ($sub_categories as $subcat) {
    $options .= $subcat['sub_category_id'].'|'.$subcat['sub_category_name'].',';
}
echo substr($options, 0, -1); ?>