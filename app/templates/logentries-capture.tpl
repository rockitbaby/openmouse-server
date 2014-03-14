<?php
$bodyclass = 'captures';
include('header.tpl'); ?>

<?php
$GLOBALS['lastdomain'] = '';
function formatUrl($url) {
	$matches = array();
	preg_match('@^(?:http://)?(www\.)?([^/]+)@i', $url, $matches);
	
	$domain = $matches[2];
	if($GLOBALS['lastdomain'] != $domain) {
		$replace = '<strong class="new">'.$domain.'</strong>';
		$GLOBALS['lastdomain'] = $domain;
	} else {
		$replace = '<strong>'.$domain.'</strong>';
	}
	$search = '/'.$domain.'/';
	
	$lastdomain = $search;
	
	return preg_replace($search, $replace, $url, 1);
}

$entry['data'] = @unserialize($entry['data']);

?>

<div class="grid_12 alpha omega entry entry-data">
	<a href="<?php echo $entry['value'] ?>"><?php echo formatUrl($entry['value']) ?></a>
<?php // TITLE
	if(isset($entry['data']['title']) && !empty($entry['data']['title'])) : ?>
	<h3 class="title"><?php echo $entry['data']['title'] ?></h3>
<?php endif; ?>
<?php // DESCRIPTION
	if(isset($entry['data']['description']) && !empty($entry['data']['description'])) : ?>
	<p class="description"><?php echo $entry['data']['description'] ?></p>
<?php endif; ?>
</div>
<div class="grid_12 alpha omega captures">

<div class="capture original">
<img src="/public/openmouse/captures/<?php echo $id ?>-<?php echo $version ?>-org.png">
</div>
<div class="capture mix">
<img src="/public/openmouse/captures/<?php echo $id ?>-<?php echo $version ?>-mix.png">
</div>

<script type="text/javascript">

$(window).load(function() {


var auto = true;
var $captures = $('.captures');
var $mix = $('.mix');
var $mixImg = $('.mix img');
var $org = $('.orginal').hide();
var mix = true;

	
$captures.css('width', $mix.width());
$captures.css('height', $mix.height());
$captures.css('overflow', 'hidden');
	
function toggle() {
	if(!auto) {
		return;
	}
	if(mix == true) {
		$org.show();
		$mix.hide();
	} else {
		$org.hide();
		$mix.show();
	}
	mix = !mix;
}

$captures.mouseenter(function() {
	auto = false;
	
	$mix.css('width', $mix.width());
	$mix.css('height', $mix.height());
	$mixImg.css('position', 'absolute');
	$mix.css('overflow', 'hidden');
	$mix.show();
});

$captures.mouseleave(function() {
	auto = true;
	$mix.css('left', '-4px');
	$mixImg.css('left', 0);
	toggle();
});

$captures.mousemove(function(e) {
	var offset = $captures.offset();
	var clientCoords = "( " + (e.clientX - offset.left) + ", " + e.clientY + " )";
	
	var l = (e.clientX - offset.left);
	$mix.css('left', l);
	$mixImg.css('left', -l - 4);
});

window.setInterval(toggle, 500);
});

</script>

</div>
<?php include('footer.tpl'); ?>