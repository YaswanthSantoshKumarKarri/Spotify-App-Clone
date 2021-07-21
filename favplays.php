<?php
    include("includes/includedFiles.php");
?>


  
<div class="tracklistContainer borderBottom">
	<h2 style="margin-top:30px;">YOUR FAVORITE SONGS</h2>
	<ul class="tracklist">
		<?php
        $songsQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY plays DESC");
        if(mysqli_num_rows($songsQuery)==0){
            echo "<span class='noResults'>NO songs found matching" . $term . "</span>";
        }
		$songIdArray = array();
		$i = 1;
		while($row = mysqli_fetch_array($songsQuery)) {
			if($i > 15) {
				break;
			}
            array_push($songIdArray, $row['id']);
			$albumSong = new Song($con, $row['id']);
			$albumArtist = $albumSong->getArtist();
			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>
					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>
					<div class='trackOptions'>
						<img class='optionsButton' src='assets/images/icons/more.png'>
					</div>
					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
					</div>
				</li>";
			$i = $i + 1;
		}
		?>
		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>
	</ul>
</div>
