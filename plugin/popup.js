document.addEventListener("DOMContentLoaded", () => {
    const startButton = document.getElementById("start");
    const stopButton = document.getElementById("stop");
    let buscaIntervalo;

    if (startButton && stopButton) {
        // Inicia o intervalo de busca ao clicar em "Start"
        startButton.addEventListener("click", () => {
            if (!buscaIntervalo) { // Evita múltiplos intervalos
                chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
                    buscaIntervalo = setInterval(() => {
                        chrome.scripting.executeScript({
                            target: { tabId: tabs[0].id },
                            files: ["content.js"]
                        });
                    }, 10000); // 10 segundos
                });
            }
        });

        // Para o intervalo de busca ao clicar em "Stop"
        stopButton.addEventListener("click", () => {
            if (buscaIntervalo) {
                clearInterval(buscaIntervalo);
                buscaIntervalo = null; // Reseta o intervalo
                console.log("Busca aleatória interrompida.");
            }
        });
    } else {
        console.log("Botões 'Start' ou 'Stop' não encontrados no popup.");
    }
});
