// Verifique se palavrasAleatorias já foi definida para evitar múltiplas declarações
if (typeof palavrasAleatorias === "undefined") {
  // Lista de palavras aleatórias
  const palavrasAleatorias = [
    "inteligência artificial", "redes neurais", "aprendizado profundo", "visão computacional",
    "reconhecimento facial", "processamento de linguagem", "dados estruturados", "computação quântica",
    "sistema distribuído", "interface gráfica", "ciência de dados", "análise estatística",
    "modelagem preditiva", "algoritmos genéticos", "técnicas heurísticas", "compilador de código",
    "ambiente virtual", "armazenamento em nuvem", "redes sociais", "linguagem natural",
    "busca binária", "otimização contínua", "aprendizado supervisionado", "cluster de dados",
    "variável global", "inteligência coletiva", "visão artificial", "arquitetura modular",
    "teste de unidade", "interface interativa", "ferramentas digitais", "manutenção preventiva",
    "controle remoto", "sistema híbrido", "comando de voz", "linguagem funcional",
    "controle de versão", "banco de dados", "processamento paralelo", "repositório digital",
    "navegação privada", "sistema de segurança", "dados compartilhados", "informação sigilosa",
    "arquivo temporário", "gerenciamento de risco", "segurança de rede", "modelagem gráfica",
    "depuração remota", "autenticação segura", "linguagem interpretada", "banco de memória",
    "ponto de acesso", "armazenamento local", "manutenção corretiva", "modelagem tridimensional",
    "registro de dados", "compartilhamento seguro", "operação automática", "compressão de dados",
    "sistema embarcado", "tela de login", "rede sem fio", "reconhecimento de voz",
    "função recursiva", "estrutura de dados", "computação móvel", "controle de fluxo",
    "monitoramento remoto", "depuração avançada", "desempenho ótimo", "computação cognitiva",
    "inteligência distribuída", "identidade digital", "armazenamento remoto", "protocolo de rede",
    "dados históricos", "armazenamento rápido", "sistema de monitoramento", "computação em nuvem",
    "rede privada", "estrutura hierárquica", "controle dinâmico", "segurança digital",
    "conexão criptografada", "processamento visual", "inteligência embarcada", "dados em tempo real",
    "interface do usuário", "rede descentralizada", "operação automatizada", "dados analíticos",
    "linguagem declarativa", "sistema de recomendação", "armazenamento seguro", "visualização gráfica",
    "computação gráfica", "código de acesso", "programação visual", "conectividade móvel",
    "navegação segura", "teste automático", "processamento sequencial", "rede de comunicação"
];


  const palavraAleatoria = palavrasAleatorias[Math.floor(Math.random() * palavrasAleatorias.length)];

  // Insere a palavra no campo de busca
  const campoBusca = document.querySelector("input[name='q']"); // Substitua 'q' pelo seletor correto do campo de busca

  if (campoBusca) {
      campoBusca.value = palavraAleatoria; // Insere a palavra aleatória no campo de busca
      console.log(`Palavra "${palavraAleatoria}" inserida no campo de busca.`);

      // Simula o pressionamento da tecla Enter
      const eventoEnter = new KeyboardEvent('keydown', { key: 'Enter', code: 'Enter', keyCode: 13, which: 13 });
      campoBusca.dispatchEvent(eventoEnter);
  } else {
      console.log("Campo de busca não encontrado!");
  }
}
