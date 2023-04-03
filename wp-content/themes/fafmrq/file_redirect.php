<?php
global $post;
if($post->post_content == ''){
	$file = get_field('file');
	//print_r('-1,21-2,312' . get_the_content() . 'w1241231');
	//global $post;
	if($file)
		header('Location: ' . $file['url']);
}