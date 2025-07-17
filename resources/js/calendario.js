let isDraggingCalendario = false;
let isDraggingPill = false;
let menuContextualVisible = false;

document.addEventListener('DOMContentLoaded', () => {
    console.log('🐞 DEBUG: JS cargado correctamente');

    const scrollContainer = document.querySelector('.calendario-scroll');
    let lastX = 0;

    if (scrollContainer) {
        scrollContainer.addEventListener('mousedown', (e) => {
            if (e.target.closest('.pill-reserva')) return;
            isDraggingCalendario = true;
            lastX = e.pageX;
            scrollContainer.classList.add('dragging');
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDraggingCalendario || isDraggingPill) return;
            const deltaX = e.pageX - lastX;
            scrollContainer.scrollLeft -= deltaX * 80;
            lastX = e.pageX;
        });

        document.addEventListener('mouseup', () => {
            isDraggingCalendario = false;
            scrollContainer.classList.remove('dragging');
        });

        scrollContainer.addEventListener('mouseleave', () => {
            isDraggingCalendario = false;
            scrollContainer.classList.remove('dragging');
        });

        window.mostrarFormularioCalendario = () => {
            document.getElementById('modalCalendario').classList.remove('hidden');
        };

        window.cerrarFormularioCalendario = () => {
            document.getElementById('modalCalendario').classList.add('hidden');
        };
    }

    const renderPills = () => {
        const pillElements = document.querySelectorAll('.pill-reserva');
        const cellWidth = 152;
        const offsetX = 150; // Separación inicial desde la primera columna visible

        const offsetBase = parseInt(document.querySelector('meta[name="offset-base"]')?.content ?? 0);
        console.log('🐞 DEBUG: Total de pills encontradas:', pillElements.length);

        // ═══════════════════════════════════════════════════════════════
        // 📌 POSICIONAMIENTO VISUAL DE CADA PILL EN EL CALENDARIO
        // ═══════════════════════════════════════════════════════════════
        pillElements.forEach(pill => {

            const start = parseInt(pill.dataset.start); // posición horizontal inicial (en días)
            const span = parseInt(pill.dataset.span);   // cantidad de días de duración
            const habitacionId = pill.dataset.habitacionId;
            const estado = pill.dataset.color;

            const filaElemento = document.querySelector(`tr[data-habitacion-id="${habitacionId}"]`);
            const tabla = document.querySelector('#tabla-calendario');

            if (!filaElemento || !tabla) return;

            const filaRect = filaElemento.getBoundingClientRect();
            const tablaRect = tabla.getBoundingClientRect();
            const offsetY = filaRect.top - tablaRect.top;
            const filaHeight = filaRect.height;

            // 📍 Posición vertical (alineada a la mitad inferior de la celda)
            pill.style.top = `${offsetY + (filaHeight / 2) + 2}px`;

            // 📍 Posición horizontal basada en `start` y ancho de columna
            pill.style.left = `${offsetX + (start * cellWidth)}px`;

            // 📏 Ancho proporcional a la duración de la reserva
            pill.style.width = `${Math.max(span, 1) * cellWidth - 4}px`;

            // 🎨 Color según estado
            pill.style.removeProperty('background-color'); // Limpieza previa opcional
            switch (estado) {
                case 'Activa':     pill.style.setProperty('background-color', '#22c55e', 'important'); break;
                case 'Finalizada': pill.style.setProperty('background-color', '#6b7280', 'important'); break;
                case 'Cancelada':  pill.style.setProperty('background-color', '#f87171', 'important'); break;
                case 'Pendiente':  pill.style.setProperty('background-color', '#7bb7fcff', 'important'); break;
                default:           pill.style.setProperty('background-color', '#ff01ffff', 'important'); break;
            }

            // ═══════════════════════════════════════════════════════════════
            // 🖱️ CLICK DERECHO: Mostrar menú contextual personalizado
            // ═══════════════════════════════════════════════════════════════
            pill.addEventListener('contextmenu', function (e) {
                e.preventDefault();

                const menu = document.getElementById('menu-contextual-reserva');
                reservaSeleccionadaId = this.dataset.id;
                reservaPillActiva = this;
                const estado = this.dataset.color;

                document.getElementById('btn-checkin').style.display = estado === 'Pendiente' ? 'block' : 'none';
                document.getElementById('btn-checkout').style.display = estado === 'Activa' ? 'block' : 'none';
                document.getElementById('btn-cancelar').style.display = (estado !== 'Cancelada' && estado !== 'Finalizada') ? 'block' : 'none';
                document.getElementById('btn-dejar-pendiente').style.display = estado === 'Activa' ? 'block' : 'none';

                menu.style.left = `${e.pageX}px`;
                menu.style.top = `${e.pageY}px`;
                menu.style.display = 'block';

                menuContextualVisible = true; // 🚫 Para bloquear drag mientras esté abierto
                e.stopPropagation();
            });
        });
        // ═══════════════════════════════════════════════════════════════
// 🖱️ DRAG & DROP: Solo se activa si el menú contextual NO está visible
// ═══════════════════════════════════════════════════════════════
pillElements.forEach(pill => {
    pill.addEventListener('mousedown', (e) => {
        // Evitamos conflicto con el menú contextual
        if (menuContextualVisible) return;

        e.preventDefault();
        pillInicial = pill;
        isDraggingPill = true;
        pillInicial.classList.add('dragging');

        posicionOriginal.left = pill.offsetLeft;
        posicionOriginal.top = pill.offsetTop;
        offsetXInicial = e.clientX - pill.offsetLeft;
        offsetYInicial = e.clientY - pill.offsetTop;

        document.addEventListener('mousemove', moverPill);
        document.addEventListener('mouseup', soltarPill);
    });
});


        // ═══════════════════════════════════════════════════════════════
        // ❌ CLICK FUERA DEL MENÚ: Ocultar menú contextual
        // ═══════════════════════════════════════════════════════════════
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('menu-contextual-reserva');
            if (!menu.contains(e.target)) {
                menu.style.display = 'none';
                menuContextualVisible = false;
            }
        });

        // ═══════════════════════════════════════════════════════════════
        // 🎯 DRAG & DROP: Preparación y control (solo si menú no está abierto)
        // ═══════════════════════════════════════════════════════════════

        // 🔄 Eliminamos eventos previos clonando los nodos


        // 🔁 Asignamos nuevamente los eventos mousedown con validación
        document.querySelectorAll('.pill-reserva').forEach(pill => {
            pill.addEventListener('mousedown', (e) => {
                e.preventDefault();
                if (menuContextualVisible) return; // 🚫 No permitir drag si el menú contextual está abierto

                pillInicial = pill;
                isDraggingPill = true;
                pillInicial.classList.add('dragging');

                posicionOriginal.left = pill.offsetLeft;
                posicionOriginal.top = pill.offsetTop;
                offsetXInicial = e.clientX - pill.offsetLeft;
                offsetYInicial = e.clientY - pill.offsetTop;

                document.addEventListener('mousemove', moverPill);
                document.addEventListener('mouseup', soltarPill);
            });
        });
    };


    renderPills();

    let reservaSeleccionadaId = null;
    let reservaPillActiva = null;

   document.getElementById('btn-detalle')?.addEventListener('click', () => {
    if (reservaSeleccionadaId) {
        window.location.href = `/reserva/detalle/${reservaSeleccionadaId}`;
        }
    });




    document.getElementById('btn-checkin')?.addEventListener('click', () => {
        enviarAccionAjax(`/reserva/${reservaSeleccionadaId}/checkin`, reservaPillActiva, 'Activa');
    });

    document.getElementById('btn-checkout')?.addEventListener('click', () => {
        enviarAccionAjax(`/reserva/${reservaSeleccionadaId}/checkout`, reservaPillActiva, 'Finalizada');
    });

    document.getElementById('btn-cancelar')?.addEventListener('click', () => {
        enviarAccionAjax(`/reserva/${reservaSeleccionadaId}/cancelar`, reservaPillActiva, 'Cancelada');
    });

    document.getElementById('btn-dejar-pendiente')?.addEventListener('click', () => {
        enviarAccionAjax(`/reserva/${reservaSeleccionadaId}/dejar-pendiente`, reservaPillActiva, 'Pendiente');
    });

    function enviarAccionAjax(url, pillElemento, nuevoEstadoEsperado) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                pillElemento.dataset.color = nuevoEstadoEsperado;
                pillElemento.classList.remove('bg-green-500', 'bg-gray-500', 'bg-red-400', 'bg-blue-300');
                switch (nuevoEstadoEsperado) {
                    case 'Activa': pillElemento.classList.add('bg-green-500'); break;
                    case 'Finalizada': pillElemento.classList.add('bg-gray-500'); break;
                    case 'Cancelada': pillElemento.classList.add('bg-red-400'); break;
                    case 'Pendiente': pillElemento.classList.add('bg-blue-300'); break;
                    default: pillElemento.classList.add('bg-blue-300'); break;
                }
                renderPills();
                document.getElementById('menu-contextual-reserva').style.display = 'none';
            } else {
                alert(data.message || 'Error al actualizar la reserva.');
            }
        }).catch(err => {
            console.error('Error en la petición AJAX:', err);
            alert('Error de conexión con el servidor.');
        });
    }

    document.getElementById('btnIrFecha')?.addEventListener('click', () => {

        const input = document.getElementById('inputFechaIr');
        const fechaSeleccionada = input.value;
        const fechaMin = document.querySelector('meta[name="fecha-min-calendario"]').content;
        const fechaMax = document.querySelector('meta[name="fecha-max-calendario"]').content;

        if (!fechaSeleccionada || fechaSeleccionada < fechaMin || fechaSeleccionada > fechaMax) {
            alert('⚠️ La fecha seleccionada está fuera del rango del calendario.');
            return;
        }

        const columna = document.querySelector(`.fecha-col[data-fecha="${fechaSeleccionada}"]`);
        if (!columna) {
            alert('⚠️ La fecha no se encuentra visible.');
            return;
        }

        document.querySelector('.calendario-scroll').scrollTo({
            left: columna.offsetLeft - 150,
            behavior: 'smooth'
        });
    });

    let pillInicial = null;
    let offsetXInicial = 0;
    let offsetYInicial = 0;
    let posicionOriginal = { left: 0, top: 0 };



    function moverPill(e) {
    if (!pillInicial || menuContextualVisible) return; // ⛔ bloqueamos si el menú está abierto
    pillInicial.style.left = `${e.clientX - offsetXInicial}px`;
    pillInicial.style.top = `${e.clientY - offsetYInicial}px`;
}


function resetDrag() {
    pillInicial.classList.remove('dragging');
    pillInicial = null;
    isDraggingPill = false;
    document.removeEventListener('mousemove', moverPill);
    document.removeEventListener('mouseup', soltarPill);
}


    function soltarPill(e) {
    if (!pillInicial) return;

    console.log('📌 Soltando pill:', pillInicial.dataset);

    const contenedor = document.querySelector('.calendario-scroll');
    const bounds = contenedor.getBoundingClientRect();
    const pillBounds = pillInicial.getBoundingClientRect();

    const dentroDeContenedor =
        pillBounds.left >= bounds.left &&
        pillBounds.right <= bounds.right &&
        pillBounds.top >= bounds.top &&
        pillBounds.bottom <= bounds.bottom;

    const cellWidth = 152;
    const nuevaCol = Math.round((pillInicial.offsetLeft - 150) / cellWidth);
    const nuevaSpan = parseInt(pillInicial.dataset.span);

    console.log('📅 Nueva columna:', nuevaCol);
    console.log('📏 Nueva duración (span):', nuevaSpan);

    let nuevaHabId = null;
    let filaElemento = null;
    const filas = document.querySelectorAll('tr[data-habitacion-id]');
    for (const fila of filas) {
        const rect = fila.getBoundingClientRect();
        if (e.clientY >= rect.top && e.clientY <= rect.bottom) {
            nuevaHabId = fila.dataset.habitacionId;
            filaElemento = fila;
            break;
        }
    }

    const tabla = document.querySelector('#tabla-calendario');

    if (!dentroDeContenedor || !nuevaHabId || haySolapamiento(pillInicial, nuevaCol, nuevaHabId, nuevaSpan)) {
        console.warn('🚫 Movimiento inválido: fuera del contenedor, sin habitación o con solapamiento');
        pillInicial.style.left = `${posicionOriginal.left}px`;
        pillInicial.style.top = `${posicionOriginal.top}px`;
        resetDrag();
        return;
    }

    const fechaCols = document.querySelectorAll('.fecha-col');
    const fechaCol = fechaCols[nuevaCol];

    if (!fechaCol) {
        console.error('❌ Error: Índice de columna inválido. No se encontró la fecha.');
        alert('❌ Error: No se pudo determinar la nueva fecha de ingreso.');
        pillInicial.style.left = `${posicionOriginal.left}px`;
        pillInicial.style.top = `${posicionOriginal.top}px`;
        resetDrag();
        return;
    }

    const fechaInicio = fechaCol.dataset.fecha;
    const fechaEgreso = new Date(fechaInicio);
    fechaEgreso.setDate(fechaEgreso.getDate() + nuevaSpan);
    const fechaEgresoStr = fechaEgreso.toISOString().split('T')[0];

    const datos = {
        id: pillInicial.dataset.id,
        nueva_fecha_ingreso: fechaInicio,
        nueva_fecha_egreso: fechaEgresoStr,
        nueva_id_habitacion: nuevaHabId
    };

    console.log('📤 Enviando datos al servidor:', datos);

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/reserva/actualizar-posicion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            console.error('❌ Error en respuesta del servidor:', data.message);
            alert('❌ Error al actualizar: ' + data.message);
            pillInicial.style.left = `${posicionOriginal.left}px`;
            pillInicial.style.top = `${posicionOriginal.top}px`;
            resetDrag();
            return;
        }

        console.log('✅ Reserva actualizada exitosamente');

        // Actualizamos visualmente
        pillInicial.dataset.start = nuevaCol;
        pillInicial.dataset.habitacionId = nuevaHabId;

        if (filaElemento && tabla) {
            const filaRect = filaElemento.getBoundingClientRect();
            const tablaRect = tabla.getBoundingClientRect();
            const offsetY = filaRect.top - tablaRect.top;
            const filaHeight = filaRect.height;
            pillInicial.style.top = `${offsetY + (filaHeight / 2) + 2}px`;
        }

        resetDrag();
    })
    .catch(err => {
        console.error('❌ Error de red al comunicar con el servidor:', err);
        alert('Error de red al actualizar reserva.');
        pillInicial.style.left = `${posicionOriginal.left}px`;
        pillInicial.style.top = `${posicionOriginal.top}px`;
        resetDrag();
    });
}




    function haySolapamiento(pillActual, nuevaCol, nuevaHabId, nuevaSpan) {
        const todasLasPills = document.querySelectorAll('.pill-reserva');
        for (const pill of todasLasPills) {
            if (pill === pillActual) continue;
            const habitacion = pill.dataset.habitacionId;
            const start = parseInt(pill.dataset.start);
            const span = parseInt(pill.dataset.span);
            const end = start + span;
            const nuevoEnd = nuevaCol + nuevaSpan;
            if (habitacion === nuevaHabId && nuevaCol < end && nuevoEnd > start) {
                return true;
            }
        }
        return false;
    }
});
