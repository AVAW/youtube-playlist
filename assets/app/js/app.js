// Load the IFrame Player API code asynchronously.
let tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
let firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
let player;

function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
        height: '360',
        width: '640',
        // videoId: 'M7lc1UVf-VE',
        playerVars: {
            // autoplay: 1,
            controls: 1,
            showinfo: 0,
            rel: 0
        },
        events: {
            onReady: onPlayerReady,
            onStateChange: onPlayerStateChange,
            onError: onError
        }
    });
}

let loadingButton = null;
let playlistList = null;

let curIdx = 0;
let playlist = [];

document.addEventListener("DOMContentLoaded", function (event) {
    loadingButton = document.querySelector('.js-loading-play');
    playlistList = document.querySelector('.js-playlist-list');
    postData(document.querySelector('.js-get-playlist-data-url').value, {
        identifier: document.querySelector('.js-playlist-identifier').value,
    })
        .then(response => {
            playlist = response.videos;
            playNext();
            generatePlaylist(playlist);
            stopLoading();
        })
        .catch(error => {
            console.log(error);
        });

    playlistList.addEventListener('change', (event) => {
        let videoId = event.target.value;
        console.log(videoId);
        player.loadVideoById(videoId);
    });
});

function stopLoading() {
    loadingButton.classList.remove('is-loading');
}

function startLoading() {
    loadingButton.classList.add('is-loading');
}

function generatePlaylist(playlist) {

    let template = document.querySelector('.js-select-template');
    for (let i = 0; i < playlist.length; i++) {
        let video = playlist[i];
        let templateClone = template.cloneNode(true);

        templateClone.value = video.id;
        templateClone.text = video.title;
        templateClone.classList.remove('is-hidden');

        playlistList.appendChild(templateClone);
    }
}

function onPlayerReady(event) {
    // event.target.playVideo();
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.UNSTARTED) {
        console.log('UNSTARTED');
    }
    if (event.data === YT.PlayerState.ENDED) {
        console.log('ENDED');
        playNext();
    }
    if (event.data === YT.PlayerState.PLAYING) {
        console.log('PLAYING');
    }
    if (event.data === YT.PlayerState.PAUSED) {
        console.log('PAUSED');
    }
    if (event.data === YT.PlayerState.BUFFERING) {
        console.log('BUFFERING');
    }
    if (event.data === YT.PlayerState.CUED) {
        console.log('CUED');
    }
}

function startVideo() {
    console.log('startVideo');
    player.stopVideo();
}

function stopVideo() {
    console.log('stopVideo');
    player.stopVideo();
}

function playNext() {
    console.log('playNext');
    playVideo(curIdx + 1)
}

function playVideo(index) {
    console.log('playVideo');
    // curIdx = t >= 0 ? t % vids.length : t + vids.length;
    player.loadVideoById(playlist[curIdx].id);
    curIdx += 1;
    // $("#curv").html(pad(curIdx + 1)), $("#list").val("" + curIdx);
    // localStorage.setItem(ytplr.idx, curIdx + "");
}

function onError(t) {
    setTimeout(playNext, 2e3)
}

async function postData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        cache: 'no-cache',
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(data)
    });
    return response.json(); // parses JSON response into native JavaScript objects
}
