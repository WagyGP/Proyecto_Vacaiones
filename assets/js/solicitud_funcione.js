document.getElementById('vacationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Aquí se podría integrar la lógica para guardar en base de datos
    
    document.getElementById('confirmationMessage').style.display = 'block';
});