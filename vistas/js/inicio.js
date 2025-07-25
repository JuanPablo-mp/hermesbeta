
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
              suggestedMax: 10,
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

// Gráfica de Barras (usuarios por ficha) - Franco
document.getElementById('btnBuscarFicha').addEventListener('click', function (e) {
  e.preventDefault();
  const codigoFicha = document.getElementById('NumeroIdFicha').value;


  fetch('ajax/inicio.ajax.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'codigoFicha=' + encodeURIComponent(codigoFicha)


  })
    .then(res => res.json())
    .then(data => {
      const nombreFicha = data.nombre_ficha ?? 'Desconocida';
      const total = data.total ?? 'Desconocido';
      console.log(data);
      const ctx3 = document.getElementById('graficoUsuarios').getContext('2d');

      // Validar que el gráfico existe y se puede destruir
      if (window.graficoUsuarios instanceof Chart) {
        window.graficoUsuarios.destroy();
      }

      window.graficoUsuarios = new Chart(ctx3, {
        type: 'bar',
        data: {
          labels: ['Hombres', 'Mujeres', 'Otros'],
          datasets: [{
            label: 'Ficha: ' + nombreFicha,
            data: [data.hombres, data.mujeres, data.otros],
            backgroundColor: [
              'rgba(11, 0, 219, 0.6)',
              'rgba(234, 4, 242, 0.74)',
              'rgba(254, 20, 20, 0.6)'
            ],
            borderColor: [
              'rgba(0, 0, 0, 1)',
              'rgba(18, 18, 18, 1)',
              'rgba(10, 10, 10, 1)'
            ],
            borderWidth: 1
          }]
        },
         options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              ticks: { color: '#000' }
            },
            y: {
              beginAtZero: true,
              suggestedMin: 0,
              suggestedMax: 10,
              ticks: { color: '#000' }
            }
          },
          plugins: {
            legend: { labels: { color: '#000' } },
            title: {
              display: true,
              text: `Total Usuarios: ${total}`,
              color: '#000',
              font: {
                size: 16
              }
            }
          }
           }


      });
    })
    .catch(error => {
      console.error('Error al buscar la ficha:', error);
      alert('Error al buscar la ficha. Por favor, inténtelo de nuevo.');
    });
    });

document.getElementById('NumeroIdFicha').value = ''; // o cualquier valor por defecto
document.getElementById('btnBuscarFicha').click(); // simula clic para cargar el gráfico

  // Fin de grafica

// Obtenniendo los datos de los equipos
var datosGraficas = new FormData(); //No se estaba instanciando bien con el new
datosGraficas.append("datosGrafica", datosGraficas);

$.ajax({
  url: "ajax/inicio.ajax.php",
  method: "POST",
  data: datosGraficas,
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

