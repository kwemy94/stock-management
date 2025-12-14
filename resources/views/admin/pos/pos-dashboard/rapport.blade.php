@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Diagramme des ventes mensuelles</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="height:250px; width:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('dashboard-js')
    <script src="{{ asset('dashboard-template/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Exemple de données
            var barChartData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                        label: 'Sales',
                        backgroundColor: '#4CAF50',
                        borderColor: '#4CAF50',
                        borderWidth: 1,
                        data: [12, 19, 3, 5, 2, 3, 9]
                    },
                    {
                        label: 'Expenses',
                        backgroundColor: '#F44336',
                        borderColor: '#F44336',
                        borderWidth: 1,
                        data: [8, 11, 5, 6, 3, 2, 7]
                    }
                ]
            }

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        }
                    }
                }
            }

            var ctx = document.getElementById('barChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        });
    </script>
@endsection
