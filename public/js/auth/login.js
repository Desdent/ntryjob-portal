window.addEventListener("load", function(){
        document.getElementById('formLogin').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this); //captura todos los datos del form al que hace referencia
        
        fetch('/api/auth/procesar-login.php', {
            method: 'POST',
            body: formData
            //al iniciar la conexion con la ruta le hace peticion post y le mete en el body los datos del form que ha cogido y lo envia al php
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.setItem('token', data.token);
                localStorage.setItem('user_id', data.user_id);
                localStorage.setItem('rol', data.rol);
                
                if (data.rol == 1) {
                document.location = '/public/index.php?page=dashboard-admin';
            } else if (data.rol == 2) {
                document.location = '/public/index.php?page=dashboard-empresario';
            } else if (data.rol == 3) {
                document.location = '/public/index.php?page=dashboard-alumno';
            }
        } else {
            alert('Error: ' + (data.error || 'Error desconocido'));
        }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
});

})