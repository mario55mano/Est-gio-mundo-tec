// Botão "Mostrar / Esconder" da senha.
document.querySelectorAll(".mostrar-senha").forEach(function (botao) {
  botao.addEventListener("click", function () {
    var campo = document.getElementById(botao.dataset.alvo);
    var visivel = campo.type === "text";
    campo.type = visivel ? "password" : "text";
    botao.textContent = visivel ? "Mostrar" : "Esconder";
    botao.setAttribute("aria-pressed", String(!visivel));
  });
});