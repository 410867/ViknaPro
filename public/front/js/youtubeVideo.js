// https://developers.google.com/youtube/iframe_api_reference?hl=ru
init();

function init() {
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
    const videoBlocks = document.querySelectorAll('[data-video-id]')
    const players = [];

    videoBlocks.forEach((el) => {
        players.push(new YT.Player(el, {
                height: '100%',
                width: '100%',
                videoId: el.getAttribute('data-video-id'),
                events: {
                    'onStateChange': onPlayerStateChange
                }
            })
        );
    })

    function onPlayerStateChange(event) {
        if (!event.data === YT.PlayerState.PLAYING) {
            return;
        }

        players.forEach((el) => {
            if (event.target === el){

                return;
            }
            //alert()
            //el.stopVideo()
        })
    }
}