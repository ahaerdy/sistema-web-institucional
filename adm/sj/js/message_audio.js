function sendMenssage()
{
	var msgInp  = jQuery('#message-description');
	var txt 		= msgInp.val();
	msgInp.val('');

	$.ajax( "/index.html" )
	.success(function() {
		msgInp.attr('placeholder', 'Aguarde enviando...');
	}).fail(function() {
		msgInp.val(txt);
	}).complete(function() {
		msgInp.attr('placeholder', 'Digite sua mensagem aqui ...');
	});
}

function __log(e, data) {
	console.log("\n" + e + " " + (data || ''));
}
function __logUser(data){
	jQuery('#response').html('<p class="help-block"><b>'+data+'</b></p>');
}

var audio_context;
var recorder;

function startUserMedia(stream) {
	var input = audio_context.createMediaStreamSource(stream);
	__log('Media stream created.' );
	__log("input sample rate " +input.context.sampleRate);

	$("#btn-rec, #btn-stop").show();
	
	input.connect(audio_context.destination);
	__log('Input connected to audio context destination.');
	
	recorder = new Recorder(input);
	__log('Recorder initialised.');
}

function startRecording(button) {
	recorder && recorder.record();
	button.disabled = true;
	button.nextElementSibling.disabled = false;
	__log('Recording...');
	__logUser('<img src="http://img.livrariacultura.com.br/imagem/comum/loading01.gif"> Gravando sua mensagem...');
}

function stopRecording(button) {
	$(recordingslist).html('<img src="http://img.livrariacultura.com.br/imagem/comum/loading01.gif"> Aguarde...');
	recorder && recorder.stop();
	button.disabled = true;
	button.previousElementSibling.disabled = false;
	__log('Stopped recording.');
	__logUser('Gravação finalizada pelo usuário.');
	
	// create WAV download link using audio data blob
	createDownloadLink();

	recorder.clear();
}

function createDownloadLink() {
	recorder && recorder.exportWAV(function(blob) {
		// var url = URL.createObjectURL(blob);
		// var li = document.createElement('li');
		// var au = document.createElement('audio');
		// var hf = document.createElement('a');
		
		// au.controls = true;
		// au.src = url;
		// hf.href = url;
		// hf.download = new Date().toISOString() + '.wav';
		// hf.innerHTML = hf.download;
		// li.appendChild(au);
		// li.appendChild(hf);
		// recordingslist.appendChild(li);
	});
}

window.onload = function init() {
	try {
		// webkit shim
		window.AudioContext = window.AudioContext || window.webkitAudioContext;
		navigator.getUserMedia = ( navigator.getUserMedia ||
		 navigator.webkitGetUserMedia ||
		 navigator.mozGetUserMedia ||
		 navigator.msGetUserMedia);
		window.URL = window.URL || window.webkitURL;
		
		audio_context = new AudioContext;
		__log('Audio context set up.');
		__log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
	} catch (e) {
		alert('Não há suporte a áudio web neste navegador!');
	}
	
	navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
		__log('No live audio input: ' + e);
	});
};