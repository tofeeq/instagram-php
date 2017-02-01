<?php
include_once('instagram.php');
$instagram = new Instagram('auth.php');

//$posts = $instagram->get('tags/nofilter/media/recent');
//$instagram->setScope('public_content');
try {
	$response = $instagram->get('users/self/media/liked');
} catch (Exception $e) {
	echo $e->getMessage();
}
?>

<!-- code ends here, view starts -->

<?php if (isset($response)) { ?>
<ul>
	<?php foreach ($response->data as $post) { ?>
	<li>
		<img src="<?php echo $post->images->standard_resolution->url; ?>">
		<h2><img src="<?php echo $post->user->profile_picture; ?>"> <?php echo $post->user->full_name; ?></h2>
		<div>Likes: <?php echo $post->likes->count; ?></div>
		<div>Comments: <?php echo $post->comments->count; ?></div>
		<div>Link: <?php echo $post->link; ?></div>
		<div>Create Time: <?php echo $post->created_time; ?></div>
	</li>
	<?php } ?>
</ul>
<?php }