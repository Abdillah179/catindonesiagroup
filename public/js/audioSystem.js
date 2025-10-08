// Simpan sebagai public/js/audioSystem.js
class AudioSystem {
    constructor() {
        // Inisialisasi audio untuk login success
        this.loginSuccess = new Audio('/voice/BotikaTTS.mp3'); // Sesuaikan path dengan lokasi file audio Anda
    }

    playLoginSuccess() {
        this.loginSuccess.play()
            .catch(error => console.log('Error Playing Sounds:', error));
    }
}

// Inisialisasi sistem audio
const audioSystem = new AudioSystem();

