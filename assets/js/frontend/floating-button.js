// assets/js/frontend/floating-button.js

document.addEventListener('DOMContentLoaded', function() {
    let floatingButton = document.getElementById('el-pomar-floating-button');
    let floatingOptions = document.getElementById('el-pomar-floating-options');
    let phoneNumber = floatingButton.getAttribute('data-phone');
    let whatsappNumber = floatingButton.getAttribute('data-whatsapp');

    floatingButton.addEventListener('mouseenter', function() {
        floatingOptions.style.display = 'flex';
        floatingOptions.style.animation = 'expandUp 0.3s ease-out';
    });

    floatingButton.addEventListener('mouseleave', function() {
        floatingOptions.style.animation = 'collapseDown 0.3s ease-out';
        setTimeout(function() {
            floatingOptions.style.display = 'none';
        }, 300);
    });

    let callUsLink = document.getElementById('el-pomar-call-us');
    callUsLink.addEventListener('click', function(event) {
        if (navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|IEMobile|Opera Mini)/)) {
            window.location.href = 'tel:' + phoneNumber;
        } else {
            alert('Número de teléfono: ' + phoneNumber);
        }
    });

    let messageUsLink = document.getElementById('el-pomar-message-us');
    messageUsLink.addEventListener('click', function() {
        window.open('https://wa.me/' + whatsappNumber, '_blank');
    });
});