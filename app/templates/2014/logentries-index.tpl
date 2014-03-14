<?php include('header.tpl'); ?>

<div class="examples">

<?php
$GLOBALS['lastdomain'] = '';
function formatUrl($url) {
	$matches = array();
	preg_match('@^(?:https?://)?(www\.)?([^/]+)@i', $url, $matches);
	
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
<div class="row minute <?php echo ((count($logentry['entries']) == 0) ? 'empty' : ''); ?>">
	<h3 class="grid_1 alpha"><?php echo formatDate($end + $minute) ?></h3>
	
	<?php if(count($logentry['entries'])) : ?>
		
	<div class="entries grid_11">
	<?php foreach($logentry['entries'] as $entry) :

		if($entry['value'] == 'https://www.google.de/_/chrome/newtab?espv=210&ie=UTF-8') {
			continue;
		}
		$entry['data'] = @unserialize($entry['data']);
		
		$class = '';
		
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
			<div class="entry-data grid_10 omega">
				<?php if($entry['event'] == 'website') : ?>
					<div class="event grid_8 alpha">
						<a href="<?php echo $entry['value'] ?>"><?php echo formatUrl($entry['value']) ?></a>
						<?php // TITLE
							if(isset($entry['data']['title']) && !empty($entry['data']['title'])) : ?>
							<h3 class="title"><?php echo $entry['data']['title'] ?></h3>
						<?php endif; ?>
						<?php // DESCRIPTION
							if(isset($entry['data']['description']) && !empty($entry['data']['description'])) : ?>
							<p class="description"><?php echo $entry['data']['description'] ?></p>
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
								<p class="word <?php echo $wclass ?>"><span><?php echo substr($word, 0, 640) ?></span></p>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php elseif($entry['event'] == 'quote') : ?>
					<div class="event grid_8 alpha quote">
						<p class="word">
							<?php if(isset($entry['data']['bgcolor']) && isset($entry['data']['color'])) : ?>
								<span style="background-color: <?php echo $entry['data']['bgcolor'] ?>; color: <?php echo $entry['data']['color'] ?>">
							<?php else :  ?>
								<span>
							<?php endif;  ?>
								<?php echo $entry['value'] ?>
							</span>
						</p>
							<?php if(isset($entry['data']['url'])) : ?>
								<p class="source">
								<a href="<?php echo $entry['data']['url'] ?>"><?php echo $entry['data']['url'] ?></a>
								</p>
							<?php endif; ?>
					</div>
				<?php endif; ?>
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