<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-white space-y-10">

        <h1 class="text-3xl font-bold text-white mb-6">Statistiche Business</h1>

        {{-- Filtri --}}
        <div class="bg-gray-800 rounded p-4 shadow space-y-4">
            <h2 class="text-xl font-semibold">Filtra per Data</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Data Inizio</label>
                    <input type="date" id="start-date" class="w-full rounded bg-gray-800 border border-gray-600 text-white px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm text-gray-300 mb-1">Data Fine</label>
                    <input type="date" id="end-date" class="w-full rounded bg-gray-800 border border-gray-600 text-white px-3 py-2" />
                </div>
                <div class="flex items-end">
                    <button onclick="filterData()" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded">
                        Applica Filtri
                    </button>
                </div>
            </div>
        </div>

        {{-- Grafico --}}
        <div class="bg-gray-800 rounded p-6 shadow">
            <h2 class="text-xl font-semibold mb-4">Andamento Sconti (per mese)</h2>
            <canvas id="discountChart" height="100"></canvas>
            <p class="text-right text-lg font-semibold text-green-400 mt-4">
                Totale Punti Scontati: <span id="total-points">0</span>
            </p>
        </div>

        {{-- Tabella Sconti --}}
        <div class="bg-gray-800 rounded p-6 shadow">
            <h2 class="text-xl font-semibold mb-4">Tabella Sconti</h2>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-600 text-gray-300">
                    <tr>
                        <th class="py-2 px-3">Data</th>
                        <th class="py-2 px-3">Utente / Tessera</th>
                        <th class="py-2 px-3">Punti</th>
                    </tr>
                </thead>
                <tbody id="discount-table" class="divide-y divide-gray-600">
                    <!-- Popolamento dinamico -->
                </tbody>
            </table>
        </div>

        {{-- Blocco Acquisti (placeholder) --}}
        <div class="bg-gray-800 rounded p-6 shadow">
            <h2 class="text-xl font-semibold mb-4">Storico Acquisti (in arrivo)</h2>
            <p class="text-gray-300">Questa sezione sarà attivata prossimamente con i dati degli ultimi punti acquistati.</p>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const rawDiscounts = {!! json_encode($discounts) !!};
            const tableBody = document.getElementById('discount-table');
            const totalPointsEl = document.getElementById('total-points');

            const chartCtx = document.getElementById('discountChart').getContext('2d');
            let chart;

            function parseDate(dateStr) {
                return new Date(dateStr);
            }

            function formatDate(date) {
                return date.toISOString().split('T')[0];
            }

            function groupByMonth(data) {
                const grouped = {};
                let totalPoints = 0;

                data.forEach(item => {
                    const month = item.date.slice(0, 7);
                    grouped[month] = (grouped[month] || 0) + item.points;
                    totalPoints += item.points;
                });

                totalPointsEl.textContent = totalPoints;
                return grouped;
            }

            function renderTable(data) {
                tableBody.innerHTML = '';
                data.forEach(d => {
                    const row = `<tr>
                        <td class="py-2 px-3">${d.date}</td>
                        <td class="py-2 px-3">${d.user}</td>
                        <td class="py-2 px-3">${d.points}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            }

            function renderChart(data) {
                const grouped = groupByMonth(data);
                const labels = Object.keys(grouped).sort();
                const values = labels.map(key => grouped[key]);

                if (chart) chart.destroy();
                chart = new Chart(chartCtx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Punti Scontati',
                            data: values,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        }]
                    },
                    options: {
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            function filterData() {
                const start = parseDate(document.getElementById('start-date').value);
                const end = parseDate(document.getElementById('end-date').value);
                const filtered = rawDiscounts.filter(d => {
                    const date = parseDate(d.date);
                    return (!isNaN(start) ? date >= start : true) &&
                           (!isNaN(end) ? date <= end : true);
                });
                renderTable(filtered);
                renderChart(filtered);
            }

            // Imposta settimana corrente come default
            const today = new Date();
            const monday = new Date(today);
            monday.setDate(today.getDate() - today.getDay() + 1); // lunedì
            document.getElementById('start-date').value = formatDate(monday);
            document.getElementById('end-date').value = formatDate(today);

            // Inizializza
            filterData();
        </script>
    @endpush
</x-app-layout>
