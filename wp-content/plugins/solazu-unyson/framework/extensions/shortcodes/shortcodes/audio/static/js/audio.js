jQuery(function($) {
    "use strict";

    var SLZ = window.SLZ || {};

    var player;

    SLZ.audio_multiplayer = function() {
    	$('audio.sc-audio-default').mediaelementplayer();
        $('.sc_audio audio.slz-playlist-container').each(function() {
            player = new MediaElementPlayer( $(this),
                {
                    audioWidth: '100%',
                    audioHeight: '100%',
                    startVolume: 0.5,
                    loop: true,
                    shuffle: true,
                    playlist: true,
                    playlistposition: 'bottom',
                    features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'current', 'progress', 'duration', 'volume'],
                }
            );
            
            // Switch Position Mejs Controls and Mejs Layers
            $(this).parents('.sc_audio').find('.mejs-controls').insertBefore( $(this).parents('.sc_audio').find('.mejs-layers') );
            
            // Custom Scrollbar List Item
            $(this).parents('.sc_audio').find('.mejs-playlist ul.mejs').mCustomScrollbar({
                axis: 'y',
                theme: 'dark'
            });
        });
    };

    SLZ.oscilloscope = function() {

        var AudioContext = window.AudioContext || window.webkitAudioContext;

        var audioCtx = new AudioContext();
        var oscillator = audioCtx.createOscillator();
        var gainNode = audioCtx.createGain();
        var analyser = audioCtx.createAnalyser();
        var distortion = audioCtx.createWaveShaper();
        var biquadFilter = audioCtx.createBiquadFilter();
        var convolver = audioCtx.createConvolver();

        // var myMediaElement = $('#current-audio');
        var myMediaElement = document.getElementById('current-audio');
        var source = audioCtx.createMediaElementSource(myMediaElement);

        source.connect(gainNode);
        source.connect(analyser);
        analyser.connect(distortion);
        distortion.connect(biquadFilter);
        biquadFilter.connect(convolver);
        convolver.connect(gainNode);
        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);

        // Get a canvas defined with ID "oscilloscope"
        var canvas = document.getElementById("oscilloscope");
        var canvasCtx = canvas.getContext("2d");

        var intendedWidth = document.querySelector('.oscilloscope-wrapper').clientWidth;
        canvas.setAttribute('width',intendedWidth);

        var drawVisual;

        var canvasWidth = canvas.width;
        var canvasHeight = canvas.height;

        analyser.fftSize = 256;
        var bufferLength = analyser.frequencyBinCount;
        var dataArray = new Uint8Array(bufferLength);

        canvasCtx.clearRect(0, 0, canvasWidth, canvasHeight);

        function draw() {
            drawVisual = requestAnimationFrame(draw);

            analyser.getByteFrequencyData(dataArray);

            canvasCtx.fillStyle = '#f7f7f7';
            canvasCtx.fillRect(0, 0, canvasWidth, canvasHeight);

            var barWidth = (canvasWidth / bufferLength) * 2.5;
            var barHeight;
            var x = 0;
            for(var i = 0; i < bufferLength; i++) {
                canvasCtx.fillStyle = '#ebebeb';
                canvasCtx.fillRect(x, 0, barWidth / 1.2, canvasHeight);
                x += barWidth + 1;
            }

            x = 0;
            for(var i = 0; i < bufferLength; i++) {
                barHeight = dataArray[i];
                canvasCtx.fillStyle = 'rgb(' + ( barHeight + -10 ) + ', 46, 178)';
                canvasCtx.fillRect(x, canvasHeight - barHeight / 2, barWidth / 1.2, barHeight / 2);
                x += barWidth + 1;
            }
        };
        draw();
    }

    $(document).ready(function() {
		SLZ.audio_multiplayer();
        var canvas = document.getElementById("oscilloscope");
        if (canvas != null) {
            SLZ.oscilloscope();
        }
    });
    
    $(window).on('resize', function() {
    	$('audio.sc-audio-default').mediaelementplayer();
        $('.sc_audio audio.slz-playlist-container').each(function() {
            player = new MediaElementPlayer( $(this),
                {
                    audioWidth: '100%',
                    audioHeight: '100%',
                    startVolume: 0.5,
                    loop: true,
                    shuffle: true,
                    playlist: true,
                    playlistposition: 'bottom',
                    features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'current', 'progress', 'duration', 'volume'],
                }
            );
        });
    });
    
});
