<?php $this->layout('layout', ['title' => 'Estadísticas Globales']) ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/public/js/admin/estadisticas.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Panel de Estadísticas</h1>
        <p>Visión general de los datos de la plataforma</p>
    </div>
    
    <div class="divCentral">
        <div id="menu-izq"> 
            <h3>Panel de Navegación</h3>
            <div class="optLateral">Panel de Alumnos</div>
            <div class="optLateral">Panel de Empresas</div>
            <div class="optLateral actual">Estadísticas</div>
        </div>
        
        <div class="stats-container" style="width: 75%; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="card-chart" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="text-align: center; color: #333; margin-bottom: 15px;">Distribución de Usuarios</h3>
                <canvas id="chartUsuarios"></canvas>
            </div>

            <div class="card-chart" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="text-align: center; color: #333; margin-bottom: 15px;">Top 5 Ciclos Formativos</h3>
                <canvas id="chartCiclos"></canvas>
            </div>

            <div class="card-chart" style="grid-column: span 2; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="text-align: center; color: #333; margin-bottom: 15px;">Estado de las Ofertas</h3>
                <canvas id="chartOfertas" style="max-height: 300px;"></canvas>
            </div>

        </div>
    </div>
</div>