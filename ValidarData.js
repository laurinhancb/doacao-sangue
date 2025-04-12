// Validação adicional no cliente
document.getElementById('data_agendamento').addEventListener('change', function() {
    const selectedDate = new Date(this.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
        alert('Por favor, selecione uma data futura!');
        this.value = '';
    }
});