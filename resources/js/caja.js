document.addEventListener('DOMContentLoaded', () => {
    const tabCaja = document.querySelector('.tab-caja');
    const tabCierres = document.querySelector('.tab-cierres');
    const cajaDia = document.getElementById('caja-dia');
    const cajaCierres = document.getElementById('caja-cierres');
    const userName = document.getElementById('usuario-logueado')?.dataset.nombre ?? 'Sin Nombre';
    const userId = document.getElementById('usuario-logueado')?.dataset.id ?? null;

    const btnAgregarFila = document.getElementById('btn-agregar-fila');
    const btnCierre = document.getElementById('btn-cierre');
    const tbody = document.getElementById('tabla-transacciones');
    const mensajeError = document.getElementById('mensaje-error-validacion');

    function actualizarTotal() {
        const filas = document.querySelectorAll('#tabla-transacciones tr');
        let total = 0;

        filas.forEach(fila => {
            const input = fila.querySelector('input[type="number"]');
            if (input && input.value.trim() !== '') {
                const val = parseFloat(input.value);
                if (!isNaN(val)) total += val;
            }
        });

        const totalElement = document.getElementById('total-dia');
        totalElement.textContent = total.toFixed(2);
        totalElement.classList.remove('text-green-600', 'text-red-600');
        totalElement.classList.add(total >= 0 ? 'text-green-600' : 'text-red-600');
    }

    function validarFilas() {
        const filas = document.querySelectorAll('#tabla-transacciones tr');
        let todoValido = true;

        filas.forEach(fila => {
            fila.querySelectorAll('td').forEach(td => {
                td.classList.remove('ring-2', 'ring-red-500', 'ring-offset-1', 'rounded-md', 'bg-red-50');
            });

            const conceptoInput = fila.querySelector('input[type="text"]');
            const clienteInput = fila.querySelectorAll('input[type="text"]')[1];
            const montoInput = fila.querySelector('input[type="number"]');
            const metodoSelect = fila.querySelector('select');

            const concepto = conceptoInput?.value.trim();
            const cliente = clienteInput?.value.trim();
            const monto = montoInput?.value.trim();
            const metodo = metodoSelect?.value;

            if (!concepto) {
                conceptoInput.parentElement.classList.add('ring-2', 'ring-red-500', 'ring-offset-1', 'rounded-md', 'bg-red-50');
                todoValido = false;
            }

            if (!cliente) {
                clienteInput.parentElement.classList.add('ring-2', 'ring-red-500', 'ring-offset-1', 'rounded-md', 'bg-red-50');
                todoValido = false;
            }

            if (!monto || isNaN(monto)) {
                montoInput.parentElement.classList.add('ring-2', 'ring-red-500', 'ring-offset-1', 'rounded-md', 'bg-red-50');
                todoValido = false;
            }

            if (metodo === '') {
                metodoSelect.parentElement.classList.add('ring-2', 'ring-red-500', 'ring-offset-1', 'rounded-md', 'bg-red-50');
                todoValido = false;
            }
        });

        return todoValido;
    }

    function agregarFilaDesdeDatos(data) {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td class="border px-3 py-2">
                <input type="text" class="w-full" placeholder="Ej: Reserva #1" value="${data?.concepto || ''}">
            </td>
            <td class="border px-3 py-2">
                <input type="text" class="w-full" placeholder="Nombre Cliente" value="${data?.cliente || ''}">
            </td>
            <td class="border px-3 py-2">
                <input type="number" class="w-full" placeholder="0.00" value="${data?.monto || ''}">
            </td>
            <td class="border px-3 py-2">
                <select class="w-full">
                    <option value="">Método</option>
                    <option value="1" ${data?.metodo_pago_id == 1 ? 'selected' : ''}>Efectivo</option>
                    <option value="2" ${data?.metodo_pago_id == 2 ? 'selected' : ''}>Tarjeta Débito</option>
                    <option value="3" ${data?.metodo_pago_id == 3 ? 'selected' : ''}>Tarjeta Crédito</option>
                    <option value="4" ${data?.metodo_pago_id == 4 ? 'selected' : ''}>Transferencia Bancaria</option>
                </select>
            </td>
            <td class="border px-3 py-2">
                <input type="text" class="w-full" placeholder="Notas" value="${data?.comentario || ''}">
            </td>
            <td class="border px-3 py-2 text-center text-sm text-gray-600">
                ${userName}
            </td>
            <td class="border px-3 py-2 text-center">
                <button class="btn-eliminar-fila text-red-600 hover:underline text-sm">❌</button>
            </td>
        `;

        fila.querySelector('.btn-eliminar-fila').addEventListener('click', () => {
            fila.remove();
            guardarFilasEnLocalStorage();
            actualizarTotal();
        });

        fila.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('input', () => {
                actualizarTotal();
                guardarFilasEnLocalStorage();
            });
        });

        tbody.appendChild(fila);
        actualizarTotal();
    }

    function guardarFilasEnLocalStorage() {
        const filas = document.querySelectorAll('#tabla-transacciones tr');
        const datos = [];

        filas.forEach(fila => {
            const concepto = fila.querySelector('input[type="text"]')?.value.trim();
            const cliente = fila.querySelectorAll('input[type="text"]')[1]?.value.trim();
            const monto = fila.querySelector('input[type="number"]')?.value.trim();
            const metodo_pago_id = parseInt(fila.querySelector('select')?.value);
            const comentario = fila.querySelectorAll('input[type="text"]')[2]?.value.trim();

            datos.push({ concepto, cliente, monto, metodo_pago_id, comentario });
        });

        localStorage.setItem('transaccionesCaja', JSON.stringify(datos));
    }

    function cargarFilasDesdeLocalStorage() {
        const datos = JSON.parse(localStorage.getItem('transaccionesCaja') || '[]');
        datos.forEach(d => agregarFilaDesdeDatos(d));
    }

    cargarFilasDesdeLocalStorage();

    btnAgregarFila.addEventListener('click', () => {
        agregarFilaDesdeDatos({});
        guardarFilasEnLocalStorage();
    });

    btnCierre.addEventListener('click', () => {
        const esValido = validarFilas();

        if (!esValido) {
            console.log('❌ Validación fallida. No se puede cerrar caja.');
            mensajeError.classList.remove('hidden');
            return;
        }

        mensajeError.classList.add('hidden');

        const filas = document.querySelectorAll('#tabla-transacciones tr');
        const transacciones = [];

        filas.forEach(fila => {
            const concepto = fila.querySelector('input[type="text"]')?.value.trim();
            const cliente = fila.querySelectorAll('input[type="text"]')[1]?.value.trim();
            const monto = parseFloat(fila.querySelector('input[type="number"]')?.value.trim());
            const metodo_pago_id = parseInt(fila.querySelector('select')?.value);
            const comentario = fila.querySelectorAll('input[type="text"]')[2]?.value.trim();

            transacciones.push({
                concepto,
                cliente,
                monto,
                metodo_pago_id,
                comentario,
                usuario_id: parseInt(userId)
            });
        });

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const fechaSeleccionada = document.getElementById('fecha-cierre')?.value;

        fetch('/caja/cierre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                fecha: fechaSeleccionada,
                transacciones: transacciones
            })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error al hacer el cierre');
            }
        })
        .then(data => {
            console.log('✅ Cierre guardado correctamente', data);

            // 🧹 Limpiar tabla, localStorage y recargar lista de cierres
            localStorage.removeItem('transaccionesCaja');
            tbody.innerHTML = '';
            actualizarTotal();
            cargarCierresDesdeServidor();

            // ✅ Mostrar mensaje bonito si usás SweetAlert
            /*
            Swal.fire({
                title: '¡Cierre exitoso!',
                text: data.mensaje,
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
            */
        })
        .catch(error => {
            console.error('❌ Error al hacer el cierre:', error);
        });
    });

    if (tabCaja && tabCierres) {
        tabCaja.addEventListener('click', () => {
            tabCaja.classList.add('text-blue-600', 'font-bold', 'border-b-2', 'border-blue-600');
            tabCaja.classList.remove('text-gray-500');
            tabCierres.classList.remove('text-blue-600', 'font-bold', 'border-b-2', 'border-blue-600');
            tabCierres.classList.add('text-gray-500');

            cajaDia.classList.remove('hidden');
            cajaCierres.classList.add('hidden');
        });

        tabCierres.addEventListener('click', () => {
            tabCierres.classList.add('text-blue-600', 'font-bold', 'border-b-2', 'border-blue-600');
            tabCierres.classList.remove('text-gray-500');
            tabCaja.classList.remove('text-blue-600', 'font-bold', 'border-b-2', 'border-blue-600');
            tabCaja.classList.add('text-gray-500');

            cajaDia.classList.add('hidden');
            cajaCierres.classList.remove('hidden');

            // 🧾 Cargar cierres desde servidor
            cargarCierresDesdeServidor();
        });
    }

    function cargarCierresDesdeServidor() {
        fetch('/cierres-caja')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('tbody-cierres');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Todavía no existen cierres realizados.</td>
                        </tr>`;
                    return;
                }

                data.forEach(cierre => {
                    const fila = document.createElement('tr');
                    fila.classList.add('border-b');
                    const fecha = new Date(cierre.fecha).toLocaleDateString();
                    const total = parseFloat(cierre.total).toLocaleString('es-AR', {
                        style: 'currency',
                        currency: 'ARS'
                    });

                    fila.innerHTML = `
                        <td class="px-4 py-2 border text-center text-black">${fecha}</td>
                        <td class="px-4 py-2 border text-center text-black">${total}</td>
                        <td class="px-4 py-2 border text-center">
                            <button class="text-blue-600 hover:underline btn-ver-detalle" data-id="${cierre.id}">Ver detalle</button>
                        </td>
                    `;

                    tbody.appendChild(fila);
                });

               document.querySelectorAll('.btn-ver-detalle').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const id = e.target.dataset.id;
        const modal = document.getElementById('modal-detalle-cierre');
        const contenido = document.getElementById('contenido-detalle');

        // Mostrar modal y mensaje inicial
        modal.classList.remove('hidden');
        contenido.innerHTML = '<p class="text-sm text-gray-600 mb-2">Cargando transacciones...</p>';

        try {
            const response = await fetch(`/cierres/${id}/transacciones`);
            const data = await response.json();

            if (data.transacciones.length === 0) {
                contenido.innerHTML = '<p class="text-gray-500 text-center">No hay transacciones para este cierre.</p>';
                return;
            }

            // Construcción de tabla de transacciones
            const tabla = `
                <table class="w-full text-sm border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2 border">Concepto</th>
                            <th class="px-3 py-2 border">Cliente</th>
                            <th class="px-3 py-2 border">Monto</th>
                            <th class="px-3 py-2 border">Método de Pago</th>
                            <th class="px-3 py-2 border">Comentario</th>
                            <th class="px-3 py-2 border">Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.transacciones.map(t =>
                            `
                            <tr class="border-b">
                                <td class="px-3 py-2 border text-gray-800">${t.concepto}</td>
                                <td class="px-3 py-2 border text-gray-800">${t.cliente ?? '-'}</td>
                                <td class="px-3 py-2 border text-green-700">$${parseFloat(t.monto).toFixed(2)}</td>
                                <td class="px-3 py-2 border text-gray-800">${t.metodo_pago?.nombre ?? '—'}</td>
                                <td class="px-3 py-2 border text-gray-800">${t.comentario ?? '-'}</td>
                                <td class="px-3 py-2 border text-gray-800">${t.usuario?.name ?? '—'}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;

            contenido.innerHTML = tabla;
                        } catch (error) {
                            console.error('❌ Error al cargar detalle:', error);
                            contenido.innerHTML = '<p class="text-red-600">❌ Error al cargar los datos.</p>';
                        }
                    });
                });
            const btnCerrarModal = document.getElementById('btn-cerrar-modal');
            if (btnCerrarModal) {
                btnCerrarModal.addEventListener('click', () => {
                    document.getElementById('modal-detalle-cierre').classList.add('hidden');
                });
            }


            })
            .catch(err => {
                console.error('Error al cargar cierres:', err);
                document.getElementById('tbody-cierres').innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center py-4 text-red-500">Error al cargar cierres.</td>
                    </tr>`;
            });
    }
});
