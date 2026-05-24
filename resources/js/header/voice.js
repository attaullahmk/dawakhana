const voiceBtn = document.querySelector('.voice-btn');
const searchInput = document.getElementById('liveSearchInput');

if (voiceBtn && searchInput) {

    const SpeechRecognition =
        window.SpeechRecognition ||
        window.webkitSpeechRecognition;

    if (SpeechRecognition) {

        const recognition = new SpeechRecognition();

        recognition.lang = 'en-US';
        recognition.interimResults = false;

        voiceBtn.addEventListener('click', () => {

            voiceBtn.classList.add('listening');

            recognition.start();

        });

        recognition.onresult = (event) => {

            const transcript = event.results[0][0].transcript;

            searchInput.value = transcript;

            document.getElementById('header-search-form').submit();

        };

        recognition.onend = () => {

            voiceBtn.classList.remove('listening');

        };

        recognition.onerror = () => {

            voiceBtn.classList.remove('listening');

        };

    } else {

        alert('Voice search is not supported in this browser.');

    }

}