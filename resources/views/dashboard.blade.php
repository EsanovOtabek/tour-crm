@extends('layouts.dashboard')
@section('title', "Bosh sahifa")
@section('description', "Bosh sahifa")

@section('content')
    <div class="px-4 pt-6">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Dashboard Statistika</h3>
                    <span class="text-base font-normal text-gray-500 dark:text-gray-400">statistikalar</span>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">So‘nggi 6 oyda bron qilingan turlar</h4>
                <canvas id="bookingsChart" height="120"></canvas>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
        const bookingsChart = new Chart(bookingsCtx, {
            type: 'bar',
            data: {
                labels: ['Noyabr', 'Dekabr', 'Yanvar', 'Fevral', 'Mart', 'Aprel'],
                datasets: [{
                    label: 'Bronlar soni',
                    data: [12, 19, 8, 17, 14, 22],
                    backgroundColor: '#3B82F6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5 }
                    }
                }
            }
        });

        const tourTypeCtx = document.getElementById('tourTypeChart').getContext('2d');
        const tourTypeChart = new Chart(tourTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ekotur', 'Tarixiy', 'Dam olish', 'Ekstremal'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: ['#10B981', '#F59E0B', '#3B82F6', '#EF4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#ffffff'
                        }
                    }
                }
            }
        });
    </script>
@endsection
