/**
 * admin/js/script.js
 * Scripts pour l'interface d'administration
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Fermeture automatique des messages d'alerte après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // 2. Gestion de l'état actif du menu latéral
    const currentLocation = window.location.href;
    const menuItems = document.querySelectorAll('.admin-sidebar ul li a');
    
    menuItems.forEach(item => {
        if (item.href === currentLocation) {
            item.style.backgroundColor = 'var(--secondary-color)';
            item.style.borderLeft = '4px solid var(--accent-color)';
        }
    });

    console.log("Interface Admin chargée avec succès.");
});