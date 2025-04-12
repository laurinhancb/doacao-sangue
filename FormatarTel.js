document.getElementById('tel').addEventListener('input', function(e) {
    // 1. Remove todos os caracteres não numéricos
    let value = e.target.value.replace(/\D/g, '');
    
    // 2. Aplica a formatação
    if (value.length > 0) {
        value = value.replace(/^(\d{0,2})(\d{0,5})(\d{0,4})/, '($1) $2-$3');
    }
    
    // 3. Limita o comprimento máximo
    e.target.value = value.substring(0, 15);
});