<?php 
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>$title - MusicApp</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="/public/js/duration_calc.js" crossorigin="anonymous" defer></script>
            <script src="/public/js/audioplayer.js" crossorigin="anonymous" defer></script>
            <link rel="stylesheet" href="/public/css/lagu-detail.css">
        </head>
        <body>
            <!-- Song detail section start -->
            <div class="song-detail">
                <div class="detail-cover">
                    <img id="big-cover" src="/public/image/<?= $song->image_path ?>" alt="" />
                </div>
                <div class="desc">
                    <h1 id="desc-title" class="desc-title"><?=$song->judul; ?></h1>
                    <h3 id="desc-artist" class="desc-artist"><?=$song->penyanyi; ?></h3>
                    <div class="additional">
                        <p id="desc-genre" class="desc-genre"><?=$song->genre; ?></p>
                        <p>•</p>
                        <p id="desc-date" class="desc-date"><?=$song->tanggal_terbit; ?></p>
                        <p>•</p>
                        <p id="desc-dur" class="desc-dur">Durasi</p>
                    </div>
                    <div class="buttons">
                        <button type="button" class="btn">Lihat Album</button>
                        <div class="show">
                            <input type="checkbox" id="show" />
                            <label for="show" class="btn">Edit Detail Lagu</label>
                            <div class="modal">
                                <label for="show" class="close-btn" title="Close"
                                    >X</label
                                >
                                <div class="text">Edit Detail Lagu</div>
                                <form id="form-edit" action="#" method="post">
                                    <div class="data">
                                        <label>Judul*</label>
                                        <input
                                            name="judul"
                                            type="text"
                                            value="<?=$song->judul; ?>"
                                            required
                                            autocomplete = "off"
                                        />
                                    </div>
                                    <div class="data">
                                        <label>Tanggal Terbit*</label>
                                        <input
                                            name="tanggal_terbit"
                                            type="date"
                                            value="<?=$song->tanggal_terbit; ?>"
                                            required
                                            autocomplete = "off"
                                        />
                                    </div>
                                    <div class="data">
                                        <label>Genre</label>
                                        <input
                                            name="genre"
                                            type="text"
                                            value="<?=$song->genre; ?>"
                                            autocomplete = "off"
                                        />
                                    </div>
                                    <div class="data">
                                        <label>File Lagu*</label>
                                        <input
                                            type="file"
                                            id="audio_path"
                                            autocomplete="off"
                                            name="audio_path"
                                            accept="audio/*"
                                            required
                                            onchange= "audioPreview()"
                                        />
                                        <input
                                            type="hidden"
                                            id="duration-helper"
                                            name="duration"
                                        />  
                                    </div>
                                    <div class="data">
                                        <label>File Cover Photo</label>
                                        <input
                                            name="image_path"
                                            type="file"
                                            accept="image/*"
                                            value=""
                                            autocomplete = "off"
                                        />
                                    </div>
                                    <button id="save-btn" type="submit" class="btn">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Song detail section end -->

            <!-- Music player section start -->
            <div class="music-player">
                <!-- Now playing widget section start -->
                <div class="now-playing">
                    <div class="mini-info">
                        <div class="mini-cover">
                            <img id="mini-cover" src="/public/image/<?= $song->image_path ?>" alt="" />
                        </div>
                        <div class="mini-desc">
                            <p id="mini-title" class="mini-title"><?=$song->judul; ?></p>
                            <p id="mini-artist" class="mini-artist"><?=$song->penyanyi; ?></p>
                        </div>
                    </div>
                    <div class="mini-add">
                        <!-- <i class="far fa-heart"></i> -->
                    </div>
                </div>
                <!-- Now playing widget section end -->

                <!-- Player control section start -->
                <div class="player-control">
                    <div class="control-button">
                        <i class="shuffle-button"></i>
                        <i id="prev" class="prev"></i>
                        <div id="play-pause" class="play-pause">
                            <i class="play-button"></i>
                        </div>
                        <i id="next" class="next"></i>
                        <i class="repeat-button"></i>
                    </div>
                    <div class="progress-container">
                        <span id="current-time" class="current-time">0:00</span>
                        <div class="progress-area">
                            <div id="progress-bar" class="progress-bar">
                                <audio id="main-audio" src="/public/audio/<?= $song->audio_path ?>"></audio>
                            </div>
                        </div>

                        <span id="max-duration" class="max-duration">0:00</span>
                    </div>
                </div>
            </div>
            <!-- Music player section end -->
        </body>
    </html>
