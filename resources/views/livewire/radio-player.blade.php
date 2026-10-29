<div class="radio-container premium-player">
    <div class="radio-content d-flex align-items-center justify-content-between flex-wrap">
        <div class="radio-info d-flex align-items-center gap-3">
            <div class="radio-icon play-pulse" style="width: 46px; height: 46px; min-width: 46px; border-radius: 50%; overflow: hidden; border: 2px solid var(--rpp-yellow); box-shadow: 0 0 16px rgba(250,204,21,0.4);">
                <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Logo" width="100%" height="100%" style="object-fit: cover;">
            </div>
            <div class="now-playing">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge rounded-pill px-2.5 py-0.5" style="background: #ef4444; color: white; font-family: 'Oswald', sans-serif; font-size: 0.72rem; letter-spacing: 0.08em;">
                        🔴 EN VIVO
                    </span>
                    <span class="text-warning small fw-bold" style="font-family: 'Oswald', sans-serif; letter-spacing: 0.05em;">DIAL 98.5 FM</span>
                    <div class="sound-equalizer ms-1 d-none d-sm-inline-flex">
                        <span class="eq-bar"></span>
                        <span class="eq-bar"></span>
                        <span class="eq-bar"></span>
                        <span class="eq-bar"></span>
                        <span class="eq-bar"></span>
                    </div>
                </div>
                <h4 class="song-title m-0 h6 text-white fw-bold" id="song-title" style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.02em;">Stereo Umachiri 98.5 FM — La Voz del Altiplano</h4>
            </div>
        </div>
        
        <div class="player-controls d-flex align-items-center gap-4 mt-3 mt-md-0">
            <div class="audio-controls d-flex align-items-center gap-3">
                <button class="btn-premium-play shadow" id="btn-play" title="Reproducir/Pausar Radio en Vivo">
                    <i class="fas fa-play"></i>
                </button>
            </div>
            
            <div class="volume-control-wrap d-none d-sm-flex align-items-center gap-2">
                <i class="fas fa-volume-up text-warning"></i>
                <input type="range" class="premium-slider" id="volume-slider" min="0" max="1" step="0.01" value="0.7">
            </div>
        </div>
    </div>

    <audio id="radio-player">
        <!-- Reemplazar 'http://streaming.tdiradio.com:8000/stream' con la URL REAL de Stereo Umachiri -->
        <source src="http://streaming.tdiradio.com:8000/stream" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const player = document.getElementById('radio-player');
            const playButton = document.getElementById('btn-play');
            const playIcon = playButton ? playButton.querySelector('i') : null;
            const volumeSlider = document.getElementById('volume-slider');
            const songTitle = document.getElementById('song-title');
            
            if (player) player.volume = 0.7;

            if (playButton && player) {
                playButton.addEventListener('click', function() {
                    if (player.paused) {
                        player.play()
                            .then(() => {
                                if(playIcon) playIcon.className = 'fas fa-pause';
                                if(songTitle) songTitle.textContent = 'En Vivo';
                                playButton.classList.add('playing');
                            })
                            .catch(error => {
                                console.error('Error al reproducir:', error);
                                if(songTitle) songTitle.textContent = 'Error de conexión';
                            });
                    } else {
                        player.pause();
                        if(playIcon) playIcon.className = 'fas fa-play';
                        if(songTitle) songTitle.textContent = '98.5 FM - Stereo Umachiri';
                        playButton.classList.remove('playing');
                    }
                });
            }
            
            if (volumeSlider && player) {
                volumeSlider.addEventListener('input', function() {
                    player.volume = this.value;
                    const volumeIcon = volumeSlider.previousElementSibling;
                    if (volumeIcon) {
                        if (this.value == 0) {
                            volumeIcon.className = 'fas fa-volume-mute text-white-50';
                        } else if (this.value < 0.5) {
                            volumeIcon.className = 'fas fa-volume-down text-white-50';
                        } else {
                            volumeIcon.className = 'fas fa-volume-up text-white-50';
                        }
                    }
                });
            }
            
            if (player) {
                player.addEventListener('play', () => {
                    if(playIcon) playIcon.className = 'fas fa-pause';
                    playButton?.classList.add('playing');
                });
                player.addEventListener('pause', () => {
                    if(playIcon) playIcon.className = 'fas fa-play';
                    playButton?.classList.remove('playing');
                });
                player.addEventListener('error', function() {
                    if(playIcon) playIcon.className = 'fas fa-play';
                    if(songTitle) songTitle.textContent = 'Error de conexión';
                    playButton?.classList.remove('playing');
                });
            }
            
            player.addEventListener('waiting', function() {
                if(songTitle) songTitle.textContent = 'Conectando...';
            });
            
            player.addEventListener('playing', function() {
                if(songTitle) songTitle.textContent = 'Reproduciendo...';
                // Agregar animación de reproducción
                playButton.classList.add('playing');
            });
        });
    </script>
</div>
