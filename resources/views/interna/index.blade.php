@extends('layouts.plantilla')

@section('navbar')
@include('interna.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Inicio de Interna</h3>
                <h1>Gráficos con Canvas y Bootstrap</h1>

                <!-- Contenedor de los gráficos -->
                <div class="container">
                    <div class="row">
                        <!-- Gráfico de barras -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Gráfico de Usuarios Registrados por Mes</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Gráfico de pie -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Gráfico de Distribución de Usuarios</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cargar Chart.js desde el CDN -->

<script>
    $(document).ready(function() {
        $("#inicio_interna").addClass('active');
        $("#hinicio_interna").attr('aria-expanded', 'true');

        // Datos en crudo (directamente en JavaScript)
        var categories = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio']; // Meses
        var data = [10, 20, 15, 30, 25, 40]; // Número de usuarios

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Usuarios Registrados',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Meses' // Título del eje X
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Número de usuarios' // Título del eje Y
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Datos para el gráfico de pie
        var pieData = [10, 20, 15, 30, 25, 40]; // Distribución de usuarios
        var pieLabels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio']; // Meses

        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Distribución de Usuarios',
                    data: pieData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>

@endsection