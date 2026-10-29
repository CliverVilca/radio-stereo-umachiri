<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class RadioPlayer extends Component
{
    use WithFileUploads;
    
    public $isPlaying = false;
    public $volume = 50;
    public $streamUrl = 'https://stream.zenolive.com/f3wvbbqszwzuv'; // URL alternativa de Zeno.fm
    public $backupStreamUrl = 'http://ec1.yesstreaming.net:3770/stream'; // URL de respaldo
    public $fallbackStreamUrl = 'https://stream.radiojar.com/exrd1tp5mceuv'; // URL de respaldo adicional
    public $radioVidaUrl = 'https://tunein.com/radio/Radio-Vida-Cusco---680-AM-s292682/'; // URL de Radio Vida Cusco
    public $currentSong = 'Transmisión en vivo';
    public $currentArtist = 'Radio Stereo Umachiri';
    public $currentShow = 'Programación actual';
    public $listenerCount = 0;
    public $isFavorite = false;
    public $showPlaylist = false;
    public $localAudio = null;
    public $isLocalAudio = false;
    public $localAudioName = '';

    public function togglePlay()
    {
        $this->isPlaying = !$this->isPlaying;
        
        if ($this->isPlaying) {
            if ($this->isLocalAudio) {
                // Reproducir audio local
                $this->dispatch('play-local-audio');
            } else {
                // Reiniciar la reproducción con la URL principal
                $this->dispatch('radio-play');
                $this->updateListenerCount();
            }
        } else {
            if ($this->isLocalAudio) {
                $this->dispatch('pause-local-audio');
            } else {
                $this->dispatch('radio-pause');
            }
        }
    }
    
    public function retryPlay()
    {
        // Método para reintentar la reproducción cuando hay problemas
        if (!$this->isPlaying) {
            $this->isPlaying = true;
        }
        $this->dispatch('radio-retry');
        $this->updateListenerCount();
    }

    public function setVolume($value)
    {
        $this->volume = $value;
        $this->dispatch('radio-volume-change', volume: $value);
    }

    public function toggleFavorite()
    {
        $this->isFavorite = !$this->isFavorite;
        // Aquí podrías guardar en base de datos
    }

    public function shareOnSocial()
    {
        // Compartir en redes sociales
        $this->dispatch('share-radio');
    }

    public function updateListenerCount()
    {
        // Simular actualización de oyentes
        $this->listenerCount = rand(50, 200);
        
        // Simular actualización de información de la canción
        $songs = [
            ['title' => 'Corazón Andino', 'artist' => 'Los Kjarkas'],
            ['title' => 'Cariñito', 'artist' => 'Los Hijos del Sol'],
            ['title' => 'Llorando se fue', 'artist' => 'Los Kjarkas'],
            ['title' => 'Viva Puno', 'artist' => 'Grupo Proyección'],
            ['title' => 'El Cóndor Pasa', 'artist' => 'Daniel Alomía Robles'],
            ['title' => 'Ojos Azules', 'artist' => 'Música Tradicional'],
            ['title' => 'Virgenes del Sol', 'artist' => 'Jorge Bravo'],
            ['title' => 'Cholo Soy', 'artist' => 'Luis Abanto Morales']
        ];
        
        $randomSong = $songs[array_rand($songs)];
        $this->currentSong = $randomSong['title'];
        $this->currentArtist = $randomSong['artist'];
        
        $shows = [
            'Amanecer Andino',
            'Música del Altiplano',
            'Voces de mi Tierra',
            'Tarde Cultural',
            'Conexión Juvenil',
            'Ritmos de la Noche'
        ];
        
        $this->currentShow = $shows[array_rand($shows)];
    }

    public function togglePlaylist()
    {
        $this->showPlaylist = !$this->showPlaylist;
    }

    public function uploadLocalAudio($file)
    {
        $this->localAudio = $file;
        $this->localAudioName = $file->getClientOriginalName();
        $this->isLocalAudio = true;
        $this->currentSong = $this->localAudioName;
        $this->currentArtist = 'Archivo local';
        $this->currentShow = 'Reproductor local';
        
        // Pausar la transmisión en vivo si está activa
        if ($this->isPlaying) {
            $this->isPlaying = false;
            $this->dispatch('radio-pause');
        }
        
        // Notificar al frontend que hay un nuevo archivo local
        $this->dispatch('local-audio-uploaded');
    }
    
    public function playLocalAudio()
    {
        if ($this->localAudio) {
            $this->isPlaying = true;
            $this->dispatch('play-local-audio');
        }
    }
    
    public function switchToStream()
    {
        $this->isLocalAudio = false;
        $this->localAudio = null;
        $this->localAudioName = '';
        $this->currentSong = 'Transmisión en vivo';
        $this->currentArtist = 'Radio Stereo Umachiri';
        $this->currentShow = 'Programación actual';
        $this->dispatch('switch-to-stream');
    }
    
    public function render()
    {
        // Si está reproduciendo, asegurarse de que haya información actualizada
        if ($this->isPlaying && $this->currentSong === 'Transmisión en vivo' && $this->listenerCount === 0) {
            $this->updateListenerCount();
        }
        
        return view('livewire.radio-player');
    }
}