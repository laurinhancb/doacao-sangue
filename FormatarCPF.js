document.getElementById('cpf').addEventListener('input', function(e) {
    // 1. Remove todos os caracteres não numéricos
    let value = e.target.value.replace(/\D/g, '');
    
    // 2. Aplica formatação progressiva
    if (value.length > 3) value = value.replace(/^(\d{3})(\d)/g, '$1.$2');
    if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/g, '$1.$2.$3');
    if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/g, '$1.$2.$3-$4');
    
    // 3. Limita o comprimento máximo
    e.target.value = value.substring(0, 14);
});