document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.querySelector('.calendario-scroll');
    const columnas = document.querySelectorAll('th.fecha-col');
    const mesActualDiv = document.getElementById('mes-actual');

    // Función para actualizar el mes visible en el encabezado
    function actualizarMesVisible() {
        if (!scrollContainer || columnas.length === 0 || !mesActualDiv) return;

        const contenedorRect = scrollContainer.getBoundingClientRect();
        const centroX = contenedorRect.left + contenedorRect.width / 2;

        for (const col of columnas) {
            const colRect = col.getBoundingClientRect();
            if (colRect.left <= centroX && colRect.right >= centroX) {
                const fecha = new Date(col.dataset.fecha);
                const mes = fecha.toLocaleDateString('es-ES', {
                    month: 'long',
                    year: 'numeric'
                });
                mesActualDiv.innerText = mes.toUpperCase();
                break;
            }
        }
    }

    // Detectar scroll y actualizar el mes
    scrollContainer?.addEventListener('scroll', actualizarMesVisible);

    // También actualizar el mes al cargar la vista
    actualizarMesVisible();
});
