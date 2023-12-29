let oroSeco = 0.0;
let plataSeco = 0.0;
let oroFino = 0.0;
let plataFina = 0.0;

let gold_law = 0.0;
let tailings_law = 0.0;
let fine_gold_to_deliver = 0.0;
let pine_silver_to_deliver = 0.0;
let gold_discount = 0.0;
let silver_discount = 0.0;

let accion_inter_onza_au;
let accion_inter_onza_ag;
let descuento_au;
let descuento_ag;

function obtenerLiquidacionData(data) {
  gold_law = parseFloat(data.gold_law);
  tailings_law = parseFloat(data.tailings_law);
  fine_gold_to_deliver = parseFloat(data.fine_gold_to_deliver);
  pine_silver_to_deliver = parseFloat(data.pine_silver_to_deliver);
  gold_discount = parseFloat(data.gold_discount);
  silver_discount = parseFloat(data.silver_discount);

  $.ajax({
    url: 'http://localhost/practica/Liquidacion/buscarDatosCliente/' + data.id, // La URL de su nuevo método
    type: 'GET',
    dataType: 'json',
  }).done(function (datos) {
    const tablaDatosBody = $('#tablaDatos tbody');
    tablaDatosBody.empty();

    datos.map(function (item, index) {
      const fila = `
        <tr>
          <td>${index + 1}</td>
          <td>Guía #1</td>
          <td>${item.guide_code}</td>
          <td>${item.wet_weight}</td>
          <td>${item.moisture_percentage}</td>
          <td>${item.dry_weight}</td>
        </tr>`;
      tablaDatosBody.append(fila);
    });
    const totales = `
    <tr>
        <td>Totales</td>
        <td></td>
        <td></td>
        <td>${datos.reduce((acc, curr) => acc + Number(curr.wet_weight), 0).toFixed(2)}</td>
        <td></td>
        <td>${datos.reduce((acc, curr) => acc + Number(curr.dry_weight), 0).toFixed(2)}</td>
      </tr>`;
    tablaDatosBody.append(totales);

    document.getElementById('btnGenerarAnalisis').onclick = () => generarAnalisisTemp(datos, data.id);
  });
}

function generarAnalisisTemp(datos, id) {
  // Retorna los datos del elemento pasado como parametro
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

  $.ajax({
    url: 'http://localhost/practica/Liquidacion/registrarAnalisisTemp', // Modifique la URL según su ruta
    type: 'POST',
    data: { analisisData: [analisisAU, analisisAG] },
    dataType: 'json',
  }).done(function (data) {
    if (data.estado == 200) {
      mostrarTablasAnalisisById(id);
      swal.fire('Registrado!', data.mssg, 'success');
    } else {
      swal.fire('Error!', data.mssg, 'error');
    }
  });
}

function mostrarTablasAnalisisById(id) {
  $.ajax({
    url: 'http://localhost/practica/Liquidacion/obtenerDatos/' + id,
    type: 'GET',
    dataType: 'json',
  }).done(function (datos) {
    const res = datos.map((e) => {
      return {
        element: e.element,
        accion_inter_onza: e.accion_inter_onza,
        descuento: e.descuento,
      };
    });
    accion_inter_onza_au = res[0].accion_inter_onza;
    accion_inter_onza_ag = res[res.length - 1].accion_inter_onza;
    descuento_au = res[0].descuento;
    descuento_ag = res[res.length - 1].descuento;

    $('#tablaAnalisisAU tbody').empty();
    $('#tablaAnalisisAG tbody').empty();
    const datosAU = datos.filter((e) => e.element === 'AU');
    const datosAG = datos.filter((e) => e.element === 'AG');
    const btnGenerarAnalisis = document.getElementById('btnGenerarAnalisis');

    // TODO: btn deshabilitado todavia tiene evento de guardar
    if (datosAU.length === 0 || datosAG.length === 0) {
      document.getElementById('tablaAnalisOro').setAttribute('hidden', true);
      document.getElementById('tablaAnalisPlata').setAttribute('hidden', true);
      document.getElementById('tablaAnalisTotal').setAttribute('hidden', true);
      btnGenerarAnalisis.classList.remove('disabled');
      return;
    }

    btnGenerarAnalisis.onclick = null;
    if (!btnGenerarAnalisis.classList.contains('disabled')) {
      btnGenerarAnalisis.classList.add('disabled');
    }

    document.getElementById('tablaAnalisOro').removeAttribute('hidden');
    document.getElementById('tablaAnalisPlata').removeAttribute('hidden');
    document.getElementById('tablaAnalisTotal').removeAttribute('hidden');

    const oroRes = renderElementsAnalisis(datosAU, 'tablaAnalisisAU');
    const plataRes = renderElementsAnalisis(datosAG, 'tablaAnalisisAG');

    oroSeco = Number(oroRes.elSecoTotal);
    plataSeco = Number(plataRes.elSecoTotal);
    oroFino = Number(oroRes.elNetoTotal);
    plataFina = Number(plataRes.elNetoTotal);

    mostrarTablaTotal();
  });
}
