document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.EP-offert-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var postId = this.getAttribute('data-post-id');
            fetchContent(postId);
        });
    });

    document.addEventListener('click', function(event) {
        if (event.target && event.target.id === 'apply-button') {
            var postId = event.target.getAttribute('data-post-id');
            renderApplicationForm(postId);
        }
    });


    document.getElementById('application-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'el_pomar_submit_application'); 
        formData.append('post_id', document.querySelector('.EP-offert-link.active').getAttribute('data-post-id'));

        fetch(el_pomar_core.ajax_url, {
            method: 'POST',
            body: formData
        }).then(response => response.json()).then(data => {
            if (data.success) {
                alert('Postulación enviada correctamente.');
                document.getElementById('application-form-popup').style.display = 'none';
            } else {
                alert('Hubo un error al enviar la postulación.');
                console.error('Error:', data.message);
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al enviar la postulación.');
        });
    });

    document.querySelectorAll('.EP-accordion-header').forEach(function(header) {
        header.addEventListener('click', function() {
            var content = this.nextElementSibling;
            var toggleIcon = this.querySelector('.toggle-icon');
            if (content.style.display === 'block') {
                content.style.display = 'none';
                toggleIcon.src = el_pomar_core.plugin_url + 'assets/img/icons/plus.svg';
            } else {
                content.style.display = 'block';
                toggleIcon.src = el_pomar_core.plugin_url + 'assets/img/icons/minus.svg';
            }
        });
    });

    document.querySelector('.close_form').addEventListener('click', function() {
        document.getElementById('application-form-popup').style.display = 'none';
    });

    document.getElementById('application-form-popup').addEventListener('click', function(event) {
        if (event.target.id === 'application-form-popup') {
            this.style.display = 'none';
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('application-form-popup').style.display = 'none';
        }
    });
});

function fetchContent(postId) {
    fetch(el_pomar_core.ajax_url + '?action=el_pomar_fetch_post_content&post_id=' + postId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('dynamic-content').innerHTML = data.data.content + data.data.button;
            } else {
                alert('Error al cargar el contenido de la oferta.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el contenido de la oferta.');
        });
}

function renderApplicationForm(postId) {
    document.getElementById('desired_position').value = document.querySelector('.EP-offert-link[data-post-id="' + postId + '"]').textContent;
    document.getElementById('application-form-popup').style.display = 'flex';
}

document.addEventListener('DOMContentLoaded', function() {
    let salaryInput = document.getElementById('salary_expectation');
    let rawValue = '';

    salaryInput.addEventListener('input', function(e) {
        rawValue = e.target.value.replace(/\D/g, '');

        if (!rawValue) {
            e.target.value = '';
            return;
        }

        const formatter = new Intl.NumberFormat('es-CO', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });

        e.target.value = '$ ' + formatter.format(rawValue);
    });

    salaryInput.addEventListener('blur', function(e) {
        if (rawValue) {
            const formatter = new Intl.NumberFormat('es-CO', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            e.target.value = '$ ' + formatter.format(rawValue);
        }
    });

    salaryInput.addEventListener('focus', function(e) {
        e.target.value = rawValue;
    });
});