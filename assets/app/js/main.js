const OriginTitle = "Randomize/Shuffle YouTube Playlist of up to 10,000 videos";
let player = null;

function loadYTVideoFrame() {
    if (player) return player.loadVideoById(vids[0].id);
    let t = document.createElement("script");
    t.src = "https://www.youtube.com/iframe_api";
    let e = document.getElementsByTagName("script")[0];
    e.parentNode.insertBefore(t, e)
}

function onYouTubeIframeAPIReady() {
    let t = $("#videoSizeSel").val(),
        e = "" + 4 * parseInt(t, 10) / 3;
    player = new YT.Player("video-placeholder", {
        width: e,
        height: t,
        videoId: vids[curIdx].id,
        playerVars: {
            autoplay: 1,
            controls: 1,
            showinfo: 0,
            rel: 0
        },
        events: {
            onReady: onPlayerReady,
            onStateChange: onPlayerStateChange,
            onError: onError
        }
    })
}
setInterval(() => {
    if (!playing) return void(document.title = OriginTitle);
    const t = player.getCurrentTime();
    if (void 0 === t) return;
    const e = player.getDuration();
    if (void 0 === e || e < 1) return;
    const l = Math.floor(100 * t / e);
    let s = vids[curIdx].title;
    document.title = "YTPLR Progress: " + l + '% of "' + s + '" ~ (' + (curIdx + 1) + "/" + vids.length + ") of playlist."
}, 1e3);
let playing = !1,
    loaded = !1;

function onPlayerReady(t) {
    t.target.playVideo(), loaded = !0
}

function onPlayerStateChange(t) {
    let e = t.data;
    e == YT.PlayerState.ENDED && playNext(), playing = e == YT.PlayerState.PLAYING
}

function onError(t) {
    setTimeout(playNext, 2e3)
}

function playVideo(t) {
    curIdx = t >= 0 ? t % vids.length : t + vids.length;
    player.loadVideoById(vids[curIdx].id);
    $("#curv").html(pad(curIdx + 1)), $("#list").val("" + curIdx);
    localStorage.setItem(ytplr.idx, curIdx + "");
}

function playNext() {
    playVideo(curIdx + 1)
}

function playPrev() {
    playVideo(curIdx - 1)
}
const ytplr_hist = "ytplr-hist",
    ytplr_tMap = "ytplr-tMap";

function sel_pl_his(t) {
    const e = (JSON.parse(localStorage.getItem(ytplr_hist)) || [])[t];
    if ($("#mlists").is(":checked")) {
        let t = $("#pids").val().split("\n").map(t => t.trim()).filter(t => t.length > 0);
        const l = t.indexOf(e);
        l >= 0 ? t.splice(l, 1) : t.push(e), $("#pids").val(t.join("\n"))
    } else $("#pid").val(e);
    checkListStatus()
}

function show_pl_his() {
    $("#info").hide(), $("#plhis").empty();
    const t = JSON.parse(localStorage.getItem(ytplr_hist)) || [],
        e = JSON.parse(localStorage.getItem(ytplr_tMap)) || {};
    select = document.getElementById("plhis");
    for (let l = 0; l < t.length; l++) {
        const s = t[l];
        let i = document.createElement("option");
        i.value = l + "", i.innerHTML = e[s].substring(0, 60) + " ~~ " + s, select.appendChild(i)
    }
    $("#plhis").show(), $("#hisLabel").show(), $("#sph").hide()
}

function save_pl_his(t) {
    const e = JSON.parse(localStorage.getItem(ytplr_hist)) || [],
        l = JSON.parse(localStorage.getItem(ytplr_tMap)) || {};
    Object.entries(t).forEach(([t, s]) => {
        l[t] = s;
        const i = e.indexOf(t);
        i >= 0 && e.splice(i, 1), e.unshift(t)
    }), localStorage.setItem(ytplr_hist, JSON.stringify(e)), localStorage.setItem(ytplr_tMap, JSON.stringify(l))
}
let vids = [],
    curIdx = 0;
const ytplr = {
    pid: "ytplr-pid",
    vid: "ytplr-vid",
    idx: "ytplr-idx",
    ttl: "ytplr-ttl",
    zip: "ytplr-zip"
};

function chk_last_session() {
    return Object.values(ytplr).every(t => localStorage.hasOwnProperty(t))
}

function resume_last_session() {
    vids = JSON.parse(LZString.decompressFromUTF16(localStorage.getItem(ytplr.vid))), showVideoList(parseInt(localStorage.getItem(ytplr.idx))), $("#info").hide(), $("#title").html(localStorage.getItem(ytplr.ttl)), $("#rls").hide(), setListStatus(localStorage.getItem(ytplr.pid)), $("#search").toggle(vids.length > 0)
}

function checkListStatus() {
    const t = $("#mlists").is(":checked");
    $("#pid").toggle(!t), $("#pids").toggle(t), $("#id_label").html("Playlist ID" + (t ? "s" : ""))
}

function clear_last_session() {
    Object.values(ytplr).forEach(t => localStorage.removeItem(t))
}

function setListStatus(t) {
    const e = t.split("~:-").map(t => t.trim()).filter(t => t.length > 0);
    $("#pidVal").val(t), $("#mlists").prop("checked", e.length > 1), e.length > 1 ? $("#pids").val(e.join("\n")) : $("#pid").val(t), checkListStatus()
}

function ytplr_main() {
    $("#rls").hide(), $("#sph").hide(), $("#plhis").hide(), $("#hisLabel").hide(), $("#list").hide(), $("#prev").prop("disabled", !0).css("opacity", .5), $("#next").prop("disabled", !0).css("opacity", .5), $("#bookmark").prop("disabled", !0).css("opacity", .5), $("#autostart").prop("disabled", !0).css("opacity", .5);
    const t = new URLSearchParams(window.location.search),
        e = t.get("pid") || "";
    setListStatus(e), $("#mlists").on("change", () => checkListStatus()), $("#shuffle").click(() => getVids()), $("#prev").click(() => playPrev()), $("#next").click(() => playNext()), $("#bookmark").click(() => {
        let t = window.location.href.split("/").slice(0, 3).join("/");
        t += "/?pid=" + $("#pidVal").val(), $("#autostart").is(":checked") && (t += "&autostart"), window.open(t, "_blank")
    }), $("#list").on("change", function() {
        playVideo(parseInt($(this).val(), 10))
    }), $("#videoSizeSel").on("change", function() {
        if (loaded) {
            let t = $(this).val(),
                e = "" + 4 * parseInt(t, 10) / 3;
            player.setSize(width = e, height = t)
        }
    });
    let l = t.get("bgcolor");
    "string" == typeof l && (document.body.style.background = l), e.length > 20 && "string" == typeof t.get("autostart") && setTimeout(() => $("#shuffle").trigger("click"), 1e3), chk_last_session() && $("#rls").show(), $("#rls").click(() => resume_last_session()), localStorage.hasOwnProperty(ytplr_hist) && localStorage.hasOwnProperty(ytplr_tMap) && $("#sph").show(), $("#sph").click(() => show_pl_his()), $("#plhis").on("change", function() {
        sel_pl_his(parseInt($(this).val()))
    })
}

function checkPid(t) {
    if (t.length < 10) return alert("Playlist ID '" + t + "' is too short, please give a valid ID.") || !1;
    let e = t.indexOf("playlist?list=");
    const l = "Remove '" + t.slice(0, e + 14) + "' at the beginning, it is not part of ID.";
    return e < 0 || alert(l) || !1
}

function getVids() {
    $("#search").hide(), document.title = OriginTitle;
    let t = "";
    if ($("#mlists").is(":checked")) {
        let e = $("#pids").val().split("\n").map(t => t.trim()).filter(t => t.length > 0);
        if (e.length <= 0) return alert("Put in some valid playlist ID.");
        if (e.length > 10) return alert("Can't have more than 10 IDs.");
        if (!e.every(t => checkPid(t))) return;
        t = e.join("~:-")
    } else if (!checkPid(t = $("#pid").val())) return;
    $("#pidVal").val(t), $("#shuffle").prop("disabled", !0).css("opacity", .5);
    let e = 0,
        l = setInterval(() => $("#status").html("-\\|/" [e++ % 4]), 250);
    $.get("https://ytplr-srv.appspot.com/", {
        playlistId: t
    }, function(e) {
        clearInterval(l), $("#status").html("");
        let s = JSON.parse(e);
        if (200 !== s.status) return alert("Check you playlist ID, might be wrong.") || showShuffleBtn();
        if (s.response.length <= 0) return alert("No video returns.") || showShuffleBtn();
        clear_last_session(), vids = s.response, showVideoList(), $("#info").hide();
        let i = "<strong>" + s.title.substring(0, 30) + "</strong>";
        $("#title").html(i), localStorage.setItem(ytplr.pid, t), localStorage.setItem(ytplr.vid, LZString.compressToUTF16(JSON.stringify(vids))), localStorage.setItem(ytplr.zip, "true"), localStorage.setItem(ytplr.ttl, i), localStorage.setItem(ytplr.idx, curIdx + ""), save_pl_his(s.tMap)
    }).fail(function() {
        clearInterval(l), $("#status").html("Error"), alert("ytplr-srv not available!"), showShuffleBtn()
    })
}

function showShuffleBtn() {
    setTimeout(() => $("#shuffle").prop("disabled", !1).css("opacity", 1), 3e3), $("#search").toggle(vids.length > 0)
}

function showVideoList(t = 0) {
    for ($("#all").html(vids.length + " videos / "), $("#list").empty(), select = document.getElementById("list"), i = 0; i < vids.length; i++) {
        let t = document.createElement("option");
        t.value = "" + i, t.innerHTML = pad(i + 1) + " ~~ " + vids[i].title.substring(0, 60), select.appendChild(t)
    }
    curIdx = t, $("#list").show(), document.getElementById("list").size = vids.length > 10 ? 10 : vids.length;

    loadYTVideoFrame(), showShuffleBtn(), $("#prev").prop("disabled", !1).css("opacity", 1), $("#next").prop("disabled", !1).css("opacity", 1), $("#bookmark").prop("disabled", !1).css("opacity", 1), $("#autostart").prop("disabled", !1).css("opacity", 1), $("#curv").html(pad(curIdx + 1)), $("#list").val("" + t), $("#list").css("background-color", "Lavender"), $("#rls").hide(), $("#sph").hide(), $("#plhis").hide(), $("#hisLabel").hide(), $("#search").toggle(vids.length > 0)
}

function pad(t, e = 4) {
    return "0".repeat(Math.max(e - ("" + t).length, 0)) + t
}

function search_main() {
    $("#search_pan").hide(), $("#search_info").hide(), $("#search").toggle(vids.length > 0), $("#search-done").click(() => $("#search_pan").hide()), $("#search").click(() => {
        $("#search_info").show();
        const t = elasticlunr(function() {
            this.addField("title"), this.setRef("id")
        });
        $("#search_info").html("Indexing ..."), items = [], vids.forEach((t, e) => items.push({
            id: e + 1,
            title: t.title.substring(0, 60)
        })), items.forEach(e => t.addDoc(e)), $("#search_info").html("Indexed"), $("#search_pan").show(), $("#search-results").hide(), $("#count").html(""), $("#search-input").keyup(function() {
            const e = $("#search-input").val();
            if ($("#count").html(""), $("#search-results").empty(), e.length < 3) return $("#search-results").hide();
            const l = t.search(e, {
                bool: "AND",
                expand: !0
            }) || [];
            $("#count").html("" + l.length);
            for (const t of l.sort((t, e) => t.ref - e.ref)) {
                const e = pad(t.ref) + " ~~~ " + t.doc.title;
                $("#search-results").append(new Option(e, t.ref))
            }
            const s = Math.min(10, l.length);
            $("#search-results").attr("size", s), $("#search-results").toggle(s > 0)
        }), document.getElementById("search-input").addEventListener("search", function(t) {
            $("#search-results").hide()
        }), $("#search-results").on("click", function() {
            playVideo($(this).val() - 1)
        })
    })
}
$(document).ready(function() {
    ytplr_main(), search_main()
});
