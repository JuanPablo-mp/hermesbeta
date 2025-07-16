
// Gráfica de Línea (Préstamos por día) - SE MANTIENE IGUAL - Alonso
const ctx = document.getElementById('line-chart-prestamos').getContext('2d');

let chart;

function cargarGrafico(tipo = 'actual') {
  fetch('ajax/inicio.ajax.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `accion=obtenerPrestamosPorDia&tipo=${tipo}`
  })
    .then(res => res.json())
    .then(data => {
      console.log(data); 
      const dias = data.map(d => d.dia);
      const cantidades = data.map(d => d.cantidad);

      if (chart) chart.destroy(); // limpiar gráfico anterior

      chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: dias,
          datasets: [{
            label: 'Préstamos por día',
            data: cantidades,
            borderColor: '#17a2b8',
            backgroundColor: 'rgba(23, 162, 184, 0.2)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#17a2b8'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { labels: { color: '#000' } }
          },
          scales: {
            x: { ticks: { color: '#000' } },
            y: {
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: 5,
              ticks: { color: '#000' }
            }
          }
        }
      });
    });
}

// Eventos para los botones
document.getElementById('semana-actual').addEventListener('click', () => cargarGrafico('actual'));
document.getElementById('semana-anterior').addEventListener('click', () => cargarGrafico('anterior'));

// Cargar gráfico por defecto
cargarGrafico();

// Fin de grafica

  // Fin de grafica
// Obtenniendo los datos de los equipos
var datos = FormData();
datos.append("datosGrafica", datosGraficas);

$.ajax({
  url: "ajax/inicio.ajax.php",
  method: "POST",
  data: datos,
  cache: false,
  contentType: false,
  processData: false,
  dataType: "json",
  success: function (respuesta) {
    console.log("respuesta", respuesta);
    // Graficas de equipos por estado (Gràfica pastel)- David
    const graficasPastelEquipos = new Chart(document.getElementById('pie-chart-equipos'), {
      type: 'pie',
      data: {
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { labels: { color: '#000' } }
          }
        },
        labels: [],
        datasets: [{
          data: [],
          backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
        }]
      }
    });
  }
})







