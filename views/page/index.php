<?php

$this->title = $page->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);
$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
?>

<div class="container">
	<center><h1><?=$page->title?></h1></center>
	<?=$page->description?>
</div>