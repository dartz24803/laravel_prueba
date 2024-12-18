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

                <!-- Contenedor del gráfico -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Gráfico de Usuarios Registrados por Mes</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Canvas para el gráfico -->
                                    <canvas id="myChart" width="400" height="200"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        $("#inicio_interna").addClass('active');
        $("#hinicio_interna").attr('aria-expanded', 'true');

        // Datos en crudo (directamente en JavaScript)
        var categories = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio']; // Meses
        var data = [10, 20, 15, 30, 25, 40]; // Número de usuarios

        // Crear el gráfico utilizando Chart.js en el canvas
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico (puedes cambiarlo por 'line', 'pie', etc.)
            data: {
                labels: categories, // Meses
                datasets: [{
                    label: 'Usuarios Registrados', // Nombre de la serie
                    data: data, // Datos de usuarios
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
                    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                    borderWidth: 1 // Ancho del borde
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
    });
</script>

@endsection