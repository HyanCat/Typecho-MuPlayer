jQuery(function() {
    var player = new _mu.Player({
        mode: 'loop',
        engines: [{
            constructor: 'FlashMP3Core',
            args: {
                swf: 'usr/plugins/MuPlayer/lib/muplayer/muplayer_mp3.swf'
            }
        }, {
            constructor: 'AudioCore'
        }]
    }),
        $pl = $('#playlist'),
        reset = function() {
            $pl.find('> li').removeClass('playing pause').find('.time').remove();
        },
        findCurrItem = function() {
            return $pl.find('[data-link="' + player.getCur() + '"]');
        },
        $time = $('<span class="time"></span>');
    $pl.on('click', '> li', function() {
        if ($(this).hasClass('playing')) {
            player.pause();
        } else {
            var link = $(this).data('link');
            player.reset().add(link).play();
        }
    });
    player.on('playing pause', function() {
        reset();
        findCurrItem().addClass(player.getState()).append($time);
    }).on('ended', function() {
        player.stop();
        reset();
    }).on('timeupdate', function() {
        $time.text(player.curPos(true) + ' / ' + player.duration(true));
    });
});