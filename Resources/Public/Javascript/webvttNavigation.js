$(document).ready(function(){

	var options = {};

	var player = videojs('player_video_js', options, function onPlayerReady() {

		//get player
		var myPlayer, arrayChapter = null, arrayTranscript = null;
		myPlayer = this;
		
		// init
		var init = function(){
			//find chapter and transcript tracks
			var tracks = player.textTracks();
			if(tracks.length > 0){
				for (i=0; i < tracks.length; i++) {
					var track = tracks[i];
					if(track.kind == 'captions'){
						arrayTranscript = track.cues;
					}
					if(track.kind == 'chapters'){
						arrayChapter = track.cues;
					}
				}
			}
			
			//display chapters
			if(arrayChapter == null){
				var chapters = document.getElementById('chapters');
				var span = document.createElement('span');
				span.innerHTML = "no chapters found!";
				chapters.appendChild(span);
			}else{
				
				displayChapters();
			}
			
			//display transcript
			if(arrayTranscript == null ){
				var transcript = document.getElementById('transcript');
				var span = document.createElement('span');
				span.innerHTML = "no transcript found!";
				transcript.appendChild(span);
			}else{
				displayTranscript();
			}
		};

		myPlayer.on("cuechange", init);
		myPlayer.on("loadedmetadata", init);

		// display chapter list on screen
		function displayChapters() {
			// create navigation list
			var chapters = document.getElementById('chapters');
			for (i=0; i < arrayChapter.length; i++) {
				var itemTr = document.createElement('tr');
				var itemTd = document.createElement('td');
				var link = document.createElement('a');
				var span = document.createElement('span');
				link.href = '#chapters';
				link.innerHTML = arrayChapter[i].text;
				link.setAttribute('from', arrayChapter[i].startTime);
				link.setAttribute('to', arrayChapter[i].endTime);
				link.onclick = function () {
					myPlayer.pause();
					myPlayer.currentTime(this.getAttribute('from'));
				}
				//span.innerHTML = arrayChapter[i].startTime+' - '+arrayChapter[i].endTime+'(sec): ';
				itemTd.appendChild(span);
				itemTd.appendChild(link);
				itemTr.appendChild(itemTd);
				chapters.appendChild(itemTr);
			}
		}
		
		// display transcript list on screen
		function displayTranscript() {
			// create navigation list
			var transcript = document.getElementById('transcript');
			for (i=0; i < arrayTranscript.length; i++) {
				var link = document.createElement('p');
				link.href = '#transcript';
				link.style.cursor = 'pointer';
				link.style.margin = '3px';
				link.innerHTML = arrayTranscript[i].text+"<br>";
				link.setAttribute('from', arrayTranscript[i].startTime);
				link.setAttribute('to', arrayTranscript[i].endTime);
				link.onclick = function () {
					myPlayer.pause();
					myPlayer.currentTime(this.getAttribute('from'));
				}
				transcript.appendChild(link);
			}
		}
	});
});