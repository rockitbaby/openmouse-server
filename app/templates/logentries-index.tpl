<?php
if($theme == '2014') :
include('2014/logentries-index.tpl');
else :
?>
<?php include('header.tpl'); ?>

<p>Protokoll.</p>

<div class="examples">
	
<!-- <div style="width: 200px; overflow: hidden;"><img src="http://www.spiegel.de/images/image-183386-thumb-qffi.jpg" width="200px" style="position: relative; left: 200px; -webkit-box-reflect:left 0px
	    -webkit-gradient(linear, left top, left bottom, from(transparent),
	    color-stop(0, white), to(white)); "></div>
	background-size: cover
	<img src="http://www.spiegel.de/images/image-183386-thumb-qffi.jpg" width="200px" style="">
	<img src="http://www.spiegel.de/images/image-183386-thumb-qffi.jpg" width="200px" style="-webkit-transform: scaleX(-1);">
-->
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

$GLOBALS['lastdate'] = '';
$GLOBALS['lasthour'] = '';
function formatDate($time) {
	global $lastday, $lasthour;
	
	$date = date('Y-m-d', $time);
	$hour = date('H', $time);
	
	$minute = date('i', $time);
	
	$s = '';
	if($GLOBALS['lastdate'] != $date) {
		$s .= '<span class="date new">'.$date.'</span>';
		$GLOBALS['lastdate'] = $date;
	} else {
		$s .= '<span class="date">'.$date.'</span>';
	}
	$s .= ' ';
	if($GLOBALS['lasthour'] != $hour) {
		$s .= '<span class="hour new">'.$hour.':</span>';
		$GLOBALS['lasthour'] = $hour;
	} else {
		$s .= '<span class="hour">'.$hour.':</span>';
	}
	
	return $s.'<span class="minute">'.$minute.'</span>';
	
}


function dist($p1, $p2) {
	
	$x = (pow($p2[0] - $p1[0], 2));
	$y = (pow($p2[1] - $p1[1], 2));
	
	return round((sqrt($x + $y)), 2);
}


foreach($logentries as $minute => $logentry) :


?>
<div class="minute <?php echo ((count($logentry['entries']) == 0) ? 'empty' : ''); ?>">
	<h3 class="grid_2 alpha"><?php echo formatDate($end + $minute) ?></h3>
	
	<?php if(count($logentry['entries'])) : ?>
		
	<div class="entries grid_10 omega">
	<?php foreach($logentry['entries'] as $entry) :
		$entry['data'] = @unserialize($entry['data']);
		
		/*
		unset($entry['data']['mouselog']);
		pr($entry['data']);
		*/
		$highlight = (isset($entry['data']['highlight']) && ($entry['data']['highlight'] == "1"));
		
		$class = '';
		if($highlight) {
			$class .= ' is-highlight';
		}
		
		$time = 0;
		if(isset($entry['data']['time'])) {
			$time = $entry['data']['time'];
		}
		
		$timeInSec = $time / 1000;
		
		if($timeInSec > 10) {
			$class .=  ' time-gt-10';
		}
		
		if($timeInSec > 30) {
			$class .=  ' time-gt-30';
		}
		
		if($timeInSec > 60) {
			$class .=  ' time-gt-60';
		}
		
	?>
		
		<div class="entry <?php echo $class ?>">
			<div class="grid_1 alpha">
				<span class="second">:<?php echo date('s', strtotime($entry['created'])) ?></span>
			</div>
			<div class="entry-data grid_9 omega">
				<div class="event grid_7 alpha">
					<a href="<?php echo $entry['value'] ?>"><?php echo formatUrl($entry['value']) ?></a>
					<?php if(isset($entry['data']['mouselog']) &&  is_array($entry['data']['mouselog'])) : ?>
						<?php
							$xs = array();
							$ys = array();
							$dist = array();
							$lastCoords = null;
							foreach($entry['data']['mouselog'] as $coords) {
								$xs []= $coords[0];
								$ys []= $coords[1];
								if($lastCoords != null) {
									$dist []= dist($coords, $lastCoords);
								}
								$lastCoords = $coords;
							}
						?>
						<span class="inlinesparkline">
							<?php echo implode(',', array_slice($dist, 0, 40)); ?>
						</span>
					<?php endif; ?>
					<?php // TITLE
						if(isset($entry['data']['title']) && !empty($entry['data']['title'])) : ?>
						<h3 class="title"><?php echo $entry['data']['title'] ?></h3>
					<?php endif; ?>
					<?php // DESCRIPTION
						if(isset($entry['data']['description']) && !empty($entry['data']['description'])) : ?>
						<p class="description"><?php echo $entry['data']['description'] ?></p>
					<?php endif; ?>
					<?php // CAPTURE
						if(isset($entry['data']['capture']) && $entry['data']['capture'] > 0) : $i = 1 ?>
						<h1>XXX 
							<a href="/logentries/capture/<?php echo $entry['id'] ?>/<?php echo $i ?>.png">SCREENSHOT</a>
							XXX
						</h1>
					<?php endif; ?>
					<?php // IMAGES
						if(isset($entry['data']['imgs']) && is_array($entry['data']['imgs'])) : ?>
						<br />
						<?php foreach($entry['data']['imgs'] as $src) : ?>
							<img src="<?php echo $src ?>">
						<?php endforeach; ?>
					<?php endif; ?>
					<?php // QUOTES
						if(isset($entry['data']['words']) && is_array($entry['data']['words'])) : ?>
						<?php foreach($entry['data']['words'] as $word) : 
							$wclass = '';
							if(strlen($word) < 20) {
								$wclass = 'w-buzz';
							} elseif(strlen($word) < 60) {
								$wclass = 'w-statement';
							} elseif(strlen($word) < 160) {
								$wclass = 'w-tweet';
							} else {
								$wclass = 'w-quote';
							}
							?>
							<p class="word <?php echo $wclass ?>"><?php echo substr($word, 0, 320) ?></p>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class="grid_2 omega activity">
					<?php if(isset($entry['data']['time'])) : ?>
						<h1><?php echo date('i:s', $entry['data']['time'] / 1000) ?></h1>
					<?php endif; ?>
				</div>
			</div><?php /* .entry-data */?>
		</div><?php /* .entry */?>
	<?php endforeach; ?>
		</div><?php /* .entries */?>
	<?php else : ?>
		<div class="grid_10 omega">&nbsp;</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>

</div>

<?php include('footer.tpl'); ?>
<?php
endif; // themeswitcher
?>