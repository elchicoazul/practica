let oroSeco = 0.0;
let plataSeco = 0.0;
let oroFino = 0.0;
let plataFina = 0.0;

function obtenerLiquidacionData(id) {
  $.ajax({
    url: 'http://localhost/practica/Liquidacion/buscarDatosCliente/' + id, // La URL de su nuevo método
    type: 'GET',
    dataType: 'json',
  }).done(function (datos) {
    $('#tablaDatos tbody').empty();
    datos.forEach(function (item, index) {
      var fila =
        '<tr>' +
        '<td>' +
        (index + 1) +
        '</td>' + // Asegúrese de que estos nombres coincidan
        '<td>' +
        'Guía #1' +
        '</td>' + // con los nombres de las propiedades en
        '<td>' +
        item.guide_code +
        '</td>' + // el objeto JSON que recibe del servidor
        '<td>' +
        item.wet_weight +
        '</td>' +
        '<td>' +
        item.moisture_percentage +
        '</td>' +
        '<td>' +
        item.dry_weight +
        '</td>';
      ('</tr>');
      $('#tablaDatos tbody').append(fila);
    });
    document.getElementById('btnGenerarAnalisis').onclick = () => generarAnalisisTemp(datos, id);
  });
}

function generarAnalisisTemp(datos, id) {
  const createAnalysis = (element, datos) => {
    return datos.map((e) => ({
      client_id: id,
      element,
      office_law: 0.0,
      client_law: 0.0,
      difference: 0.0,
      final_law: 0.0,
      net_kg: 0.0,
      dry_weight: e['dry_weight'],
    }));
  };

  const analisisAU = createAnalysis('AU', datos);
  const analisisAG = createAnalysis('AG', datos);

  swal
    .fire({
      title: 'Generar analisis',
      text: '¿Está seguro de generar el analisis de los datos?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Generar',
      cancelButtonText: 'No',
    })
    .then((result) => {
      if (result.value) {
        $.ajax({
          url: 'http://localhost/practica/Liquidacion/registrarAnalisisTemp', // Modifique la URL según su ruta
          type: 'POST',
          data: { analisisData: [analisisAU, analisisAG] },
          dataType: 'json',
        }).done(function (data) {
          if (data.estado == 200) {
            obtenerDatosAnalisis(id);
            swal.fire('Registrado!', data.mssg, 'success');
          } else {
            swal.fire('Error!', data.mssg, 'error');
          }
        });
      }
    });
}

function obtenerDatosAnalisis(id) {
  $.ajax({
    url: 'http://localhost/practica/Liquidacion/obtenerDatos/' + id,
    type: 'GET',
    dataType: 'json',
  }).done(function (datos) {
    $('#tablaAnalisisAU tbody').empty();
    $('#tablaAnalisisAG tbody').empty();
    const datosAU = datos.filter((e) => e.element === 'AU');
    const datosAG = datos.filter((e) => e.element === 'AG');

    const oroRes = renderElementsAnalisis(datosAU, 'tablaAnalisisAU');
    const plataRes = renderElementsAnalisis(datosAG, 'tablaAnalisisAG');
    oroSeco = Number(oroRes.elSecoTotal);
    plataSeco = Number(plataRes.elSecoTotal);
    oroFino = Number(oroRes.elNetoTotal);
    plataFina = Number(plataRes.elNetoTotal);
    mostrarTablaTotal();
  });
}

const renderElementsAnalisis = (data, tableId) => {
  const analisisResults = data.map((item, index) => {
    const fila = `
    <tr id="fila-${item.id}">
      <td>
        <span class="btn btn-icon text-primary" onclick="editarAnalisis(${item.id})">
          <i class="mdi mdi-pencil"></i>
        </span>
      </td>
      <td>${index + 1}</td>
      <td>${item.dry_weight}</td>
      <td>${item.office_law}</td>
      <td>${item.client_law}</td>
      <td>${item.difference}</td>
      <td>${item.final_law}</td>
      <td>${item.net_kg}</td>
    </tr>`;
    $('#' + tableId + ' tbody').append(fila);
    return {
      dryWeigth: Number(item.dry_weight),
      netKg: Number(item.net_kg),
    };
  });
  const total = `
    <tr>
      <th></th>
      <th>Totales</th>
      <th>${analisisResults.reduce((acc, curr) => acc + curr.dryWeigth, 0)}</th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th id="totalKgs">${analisisResults.reduce((acc, curr) => acc + curr.netKg, 0)}</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th colspan="2">Ley general de cola (grs/Kg.):</th>
      <th>0.10</th>
      <th>10.10</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>${(analisisResults.reduce((acc, curr) => acc + curr.netKg, 0) - 10.1).toFixed(2)}</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th colspan="2">Oro fino por entregar:</th>
      <th>98.50%</th>
      <th>${((analisisResults.reduce((acc, curr) => acc + curr.netKg, 0) - 10.1) * (98.5 / 100)).toFixed(2)}</th>
    </tr>
  `;
  $('#' + tableId + ' tbody').append(total);
  return {
    elSecoTotal: analisisResults.reduce((acc, curr) => acc + curr.dryWeigth, 0),
    elNetoTotal: ((analisisResults.reduce((acc, curr) => acc + curr.netKg, 0) - 10.1) * (98.5 / 100)).toFixed(2),
  };
};

function editarAnalisis(id) {
  var fila = document.getElementById('fila-' + id);

  if (fila) {
    var secoValor = fila.cells[2].innerText;
    var officeLawValor = fila.cells[3].innerText;
    var clientLawValor = fila.cells[4].innerText;
    var differenceValor = fila.cells[5].innerText;
    var finalValor = fila.cells[6].innerText;
    var netoValor = fila.cells[7].innerText;

    fila.cells[0].innerHTML = `
      <span class="btn btn-icon text-primary" onclick="guardarAnalisis(${id})">
        <i class="mdi mdi-archive text-primary"></i>
      </span>
    `;
    fila.cells[2].innerHTML = '<input disabled type="text" id="seco-' + id + '" value="' + secoValor + '" onkeyup="leyes(' + id + ')">';
    fila.cells[3].innerHTML = '<input type="text" id="officeLaw-' + id + '" value="' + officeLawValor + '" onkeyup="leyes(' + id + ')">';
    fila.cells[4].innerHTML = '<input type="text" id="clientLaw-' + id + '" value="' + clientLawValor + '" onkeyup="leyes(' + id + ')">';
    fila.cells[5].innerHTML = '<input type="text" id="difference-' + id + '" value="' + differenceValor + '" onkeyup="leyes(' + id + ')">';
    fila.cells[6].innerHTML = '<input disabled type="text" id="final-' + id + '" value="' + finalValor + '">';
    fila.cells[7].innerHTML = '<input disabled type="text" id="neto-' + id + '" value="' + netoValor + '">';
  }
}

const guardarAnalisis = async (id) => {
  var fila = document.getElementById('fila-' + id);
  if (fila) {
    const analisisData = {
      seco: parseFloat(fila.cells[2].getElementsByTagName('input')[0].value),
      officeLaw: parseFloat(fila.cells[3].getElementsByTagName('input')[0].value),
      clientLaw: parseFloat(fila.cells[4].getElementsByTagName('input')[0].value),
      difference: parseFloat(fila.cells[5].getElementsByTagName('input')[0].value),
      final: parseFloat(fila.cells[6].getElementsByTagName('input')[0].value),
      neto: parseFloat(fila.cells[7].getElementsByTagName('input')[0].value),
    };
    $.ajax({
      url: 'http://localhost/practica/Liquidacion/actualizarAnalisis/' + id,
      type: 'POST',
      data: { id: Number(id), analisisData: analisisData },
      dataType: 'json',
    });
    fila.cells[0].innerHTML = `
          <span class="btn btn-icon text-primary" onclick="editarAnalisis(${id})">
            <i class="mdi mdi-pencil"></i>
          </span>
        `;
    fila.cells[2].innerHTML = fila.cells[2].getElementsByTagName('input')[0].value;
    fila.cells[3].innerHTML = fila.cells[3].getElementsByTagName('input')[0].value;
    fila.cells[4].innerHTML = fila.cells[4].getElementsByTagName('input')[0].value;
    fila.cells[5].innerHTML = fila.cells[5].getElementsByTagName('input')[0].value;
    fila.cells[6].innerHTML = fila.cells[6].getElementsByTagName('input')[0].value;
    fila.cells[7].innerHTML = fila.cells[7].getElementsByTagName('input')[0].value;
  }
};

const mostrarTablaTotal = () => {
  const auOnza = (1979.7).toFixed(2);
  const auGrms = (auOnza / 31.1035).toFixed(2);
  const auValorMetalGrms = (auOnza * auGrms).toFixed(2);
  const auDescuento = (96.0 / 100).toFixed(2);
  const auNetoGrs = (auValorMetalGrms * auDescuento).toFixed(2);

  const agOnza = (23.885).toFixed(2);
  const agGrms = (agOnza / 31.1035).toFixed(2);
  const agValorMetalGrms = (agOnza * agGrms).toFixed(2);
  const agDescuento = (89.0 / 100).toFixed(2);
  const agNetoGrs = (agValorMetalGrms * agDescuento).toFixed(2);

  const totalMetal = (oroFino + plataFina).toFixed(2);
  const totalNeto = Number(auNetoGrs) + Number(agNetoGrs);
  const auRefinacionTotal = (oroFino * 0.045).toFixed(2);
  const agRefinacionTotal = (plataFina * 0.02).toFixed(2);
  const desorcion = (oroSeco * 1.3).toFixed(2);
  const transporte = (plataSeco * 0.8).toFixed(2);
  const IGV = 47.13;

  const pagoTotal = totalNeto - desorcion - auRefinacionTotal - agRefinacionTotal - transporte - IGV;

  const tablaTotalBody = `
    <tr>
    <td class="text-center">ORO</td>
    <td class="text-center">${oroFino}</td>
    <td class="text-center">${auOnza}</td>
    <td class="text-center">${auGrms}</td>
    <td class="text-center">${auValorMetalGrms}</td>
    <td class="text-center">${auDescuento}%</td>
    <td class="text-center">${auNetoGrs}</td>
  </tr>
  <tr>
    <td class="text-center">PLATA</td>
    <td class="text-center">${plataFina}</td>
    <td class="text-center">${agOnza}</td>
    <td class="text-center">${agGrms}</td>
    <td class="text-center">${agValorMetalGrms}</td>
    <td class="text-center">${agDescuento}%</td>
    <td class="text-center">${agNetoGrs}</td>
  </tr>
  <tr>
    <th class="text-center">Total</th>
    <th class="text-center">${totalMetal}</th>
    <th class="text-center"></th>
    <th class="text-center"></th>
    <th class="text-center"></th>
    <th class="text-center">Total</th>
    <th class="text-center">${totalNeto}</th>
  </tr>
  <tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="" colspan="2">Servico de Desorcion</td>
    <td class="text-center">${oroSeco}</td>
    <td class="text-center">1.30</td>
    <td class="text-center">${desorcion}</td>
  </tr>
  <tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="" colspan="2">Servicio de Refinación Au</td>
    <td class="text-center">${oroFino}</td>
    <td class="text-center">0.045</td>
    <td class="text-center">${auRefinacionTotal}</td>
  </tr>
  <tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="" colspan="2">Servicio de Refinación Ag</td>
    <td class="text-center">${plataFina}</td>
    <td class="text-center">0.020</td>
    <td class="text-center">${agRefinacionTotal}</td>
  </tr>
  <tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="" colspan="2">Servico de transporte de carbon</td>
    <td class="text-center">${plataSeco}</td>
    <td class="text-center">0.80</td>
    <td class="text-center">${transporte}</td>
  </tr>
  <tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="" colspan="2">IGV SERVICIOS</td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center">47.13</td>
  </tr>
  <tr>
    <th class="text-center"></th>
    <th class="text-center"></th>
    <th class="" colspan="2">TOTAL A PAGAR</th>
    <th class="text-center"></th>
    <th class="text-center">US$</th>
    <th class="text-center">${pagoTotal}</th>
  </tr>
  `;
  $('#tablaTotal tbody').append(tablaTotalBody);
};
