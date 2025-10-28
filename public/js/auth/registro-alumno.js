// Esperar a que cargue el DOM
document.addEventListener('DOMContentLoaded', function() {
    
    const modal = document.getElementById('modalRegistroAlumno');
    const btnAbrir = document.getElementById('btnAbrirModalAlumno');
    const btnCerrar = document.querySelector('.modal-close');
    const btnCancelar = document.getElementById('btnCancelarModal');
    const form = document.getElementById('formRegistroAlumno');
    
    // ========== ABRIR/CERRAR MODAL ==========
    
    btnAbrir.addEventListener('click', function() {
        modal.style.display = 'block';
    });
    
    btnCerrar.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    btnCancelar.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Cerrar al hacer clic fuera del modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // ========== VALIDACIONES EN TIEMPO REAL ==========
    
    const campos = form.querySelectorAll('input[required]');
    
    campos.forEach(campo => {
        campo.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        // Limpiar validación al empezar a escribir
        campo.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                this.classList.remove('invalid');
                this.nextElementSibling.textContent = '';
            }
        });
    });
    
    // ========== FUNCIÓN DE VALIDACIÓN ==========
    
    function validarCampo(campo) {
        const valor = campo.value.trim();
        const nombre = campo.name;
        const errorSpan = campo.nextElementSibling;
        
        // Limpiar estados previos
        campo.classList.remove('valid', 'invalid');
        errorSpan.textContent = '';
        
        // Validar si está vacío
        if (valor === '') {
            if (campo.required) {
                campo.classList.add('invalid');
                errorSpan.textContent = 'Este campo es obligatorio';
                return false;
            }
            return true;
        }
        
        // Validaciones específicas por tipo de campo
        switch(nombre) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Email inválido';
                    return false;
                }
                // Verificar si el email ya existe (AJAX)
                verificarEmailExistente(campo, errorSpan);
                break;
                
            case 'telefono':
                const telRegex = /^[0-9]{9,15}$/;
                if (!telRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Teléfono inválido (9-15 dígitos)';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'codigoPostal':
                const cpRegex = /^[0-9]{5}$/;
                if (!cpRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Código postal inválido (5 dígitos)';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'password':
                if (valor.length < 6) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Mínimo 6 caracteres';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'fechaNacimiento':
                const hoy = new Date();
                const fechaNac = new Date(valor);
                const edad = hoy.getFullYear() - fechaNac.getFullYear();
                if (edad < 16 || edad > 100) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Edad debe estar entre 16 y 100 años';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'subirCV':
                const archivo = campo.files[0];
                if (archivo) {
                    const extensiones = ['pdf', 'docx'];
                    const ext = archivo.name.split('.').pop().toLowerCase();
                    if (!extensiones.includes(ext)) {
                        campo.classList.add('invalid');
                        errorSpan.textContent = 'Solo PDF o DOCX';
                        return false;
                    }
                    if (archivo.size > 5 * 1024 * 1024) { // 5MB
                        campo.classList.add('invalid');
                        errorSpan.textContent = 'Máximo 5MB';
                        return false;
                    }
                    campo.classList.add('valid');
                }
                break;
                
            default:
                // Validación genérica (no vacío y mínimo 2 caracteres)
                if (valor.length < 2) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Mínimo 2 caracteres';
                    return false;
                }
                campo.classList.add('valid');
        }
        
        return true;
    }
    
    // ========== VERIFICAR EMAIL EXISTENTE ==========
    
    function verificarEmailExistente(campo, errorSpan) {
        const email = campo.value.trim();
        
        fetch('/api/auth/email_exists.php?email=' + encodeURIComponent(email))
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Este email ya está registrado';
                } else {
                    campo.classList.add('valid');
                }
            })
            .catch(error => {
                console.error('Error al verificar email:', error);
            });
    }
    
    // ========== ENVÍO DEL FORMULARIO ==========
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar todos los campos
        let todosValidos = true;
        campos.forEach(campo => {
            if (!validarCampo(campo)) {
                todosValidos = false;
            }
        });
        
        if (!todosValidos) {
            alert('Por favor, corrige los errores en el formulario');
            return;
        }
        
        // Preparar datos del formulario (con archivo)
        const formData = new FormData(form);
        
        // Deshabilitar botón de envío
        const btnSubmit = form.querySelector('button[type="submit"]');
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Registrando...';
        
        // Enviar con Fetch
        fetch('/api/auth/procesar-alumno.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('¡Registro exitoso! Redirigiendo al login...');
                modal.style.display = 'none';
                form.reset();
                // Redireccionar al login
                window.location.href = '/public/index.php?page=login&success=registro_exitoso';
            } else {
                // Mostrar errores
                if (data.errors) {
                    alert('Errores: ' + data.errors.join(', '));
                } else if (data.error) {
                    alert('Error: ' + data.error);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar el registro. Inténtalo de nuevo.');
        })
        .finally(() => {
            // Rehabilitar botón
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Registrarse';
        });
    });
});
