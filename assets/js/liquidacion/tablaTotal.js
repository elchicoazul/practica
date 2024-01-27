const mostrarTablaTotal = async (edit) => {
  const datos = await obtenerTablaTotalValores();
  var serviceData = datos[0];
  const configurationData = datos[1];
  document.getElementById("liquidacion").removeAttribute("hidden");
  if (edit?.status) {
    document.getElementById("liquidacion").setAttribute("hidden", "true");
    document
      .getElementById("btnGenerarAnalisis")
      .setAttribute("hidden", "true");
    //obtener todos los elementos que tengan un id llamado editButtonTable y eliminarlos
    serviceData = edit.data.servicios;
  }
  $("#tablaTotal tbody").empty();
  let auOnza = parseFloat(configurationData[0].value).toFixed(2);

  if (edit?.status) {
    auOnza = edit.data.detalle.find(
      (element) => element.element === "AU"
    ).accion_inter_onza;
  } else {
    auOnza = accion_inter_onza_au === "0.00" ? auOnza : accion_inter_onza_au;
  }
  const auGrms = (auOnza / 31.1035).toFixed(2); // 31.1035 ???
  const auValorMetalGrms = (oroFino * auGrms).toFixed(2);
  let auDescuento = gold_discount;
  auDescuento = descuento_au === "0.00" ? auDescuento : descuento_au;
  if (edit?.status) {
    auDescuento = edit.data.detalle.find(
      (element) => element.element === "AU"
    ).descuento;
  } else {
    auDescuento = descuento_au === "0.00" ? auDescuento : descuento_au;
  }
  const auNetoGrs = (
    auValorMetalGrms -
    auValorMetalGrms * (auDescuento / 100)
  ).toFixed(2);

  let agOnza = parseFloat(configurationData[1].value).toFixed(2);
  if (edit?.status) {
    agOnza = edit.data.detalle.find(
      (element) => element.element === "AG"
    ).accion_inter_onza;
  } else {
    agOnza = accion_inter_onza_ag === "0.00" ? agOnza : accion_inter_onza_ag;
  }
  const agGrms = (agOnza / 31.1035).toFixed(2); // 31.1035 ???
  const agValorMetalGrms = (plataFina * agGrms).toFixed(2);
  let agDescuento = silver_discount;

  if (edit?.status) {
    agDescuento = edit.data.detalle.find(
      (element) => element.element === "AG"
    ).descuento;
  } else {
    agDescuento = descuento_ag === "0.00" ? agDescuento : descuento_ag;
  }
  const agNetoGrs = (
    agValorMetalGrms -
    agValorMetalGrms * (agDescuento / 100)
  ).toFixed(2);

  const totalMetal = (oroFino + plataFina).toFixed(2);
  const totalNeto = (Number(auNetoGrs) + Number(agNetoGrs)).toFixed(2);

  const desorcion = (oroSeco * parseFloat(serviceData[0].price)).toFixed(2);
  const auRefinacionTotal = (
    oroFino * parseFloat(serviceData[1].price)
  ).toFixed(2);
  const agRefinacionTotal = (
    plataFina * parseFloat(serviceData[2].price)
  ).toFixed(2);
  const transporte = (plataSeco * parseFloat(serviceData[3].price)).toFixed(2);
  const IGV = 47.13;

  const pagoTotal = (
    totalNeto -
    desorcion -
    auRefinacionTotal -
    agRefinacionTotal -
    transporte -
    IGV
  ).toFixed(2);

  const tablaTotalBody = `
    <tr id="analisisFinalAU">
      <td class="text-center">
        <span class="btn btn-icon text-primary" onclick="editarAnalisisFinal('AU')" id='editButtonTable'>
          <i class="mdi mdi-pencil"></i>
        </span>
      </td>
      <td class="text-center">ORO</td>
      <td class="text-center">${oroFino}</td>
      <td class="text-center">${auOnza}</td>
      <td class="text-center">${auGrms}</td>
      <td class="text-center">${auValorMetalGrms}</td>
      <td class="text-center">${auDescuento}%</td>
      <td class="text-center">${auNetoGrs}</td>
    </tr>
    <tr id="analisisFinalAG">
      <td class="text-center">
        <span class="btn btn-icon text-primary" onclick="editarAnalisisFinal('AG')" id='editButtonTable'>
          <i class="mdi mdi-pencil"></i>
        </span>
      </td>
      <td class="text-center">PLATA</td>
      <td class="text-center">${plataFina}</td>
      <td class="text-center">${agOnza}</td>
      <td class="text-center">${agGrms}</td>
      <td class="text-center">${agValorMetalGrms}</td>
      <td class="text-center">${agDescuento}%</td>
      <td class="text-center">${agNetoGrs}</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <th class="text-center">Total</th>
      <th class="text-center">${totalMetal}</th>
      <th class="text-center"></th>
      <th class="text-center"></th>
      <th class="text-center"></th>
      <th class="text-center">Total</th>
      <th class="text-center">${totalNeto}</th>
    </tr>
    <tr>
      <th class="text-center"></th>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="" colspan="2">Servico de Desorcion</td>
      <td class="text-center">${oroSeco}</td>
      <td class="text-center">${parseFloat(serviceData[0].price).toFixed(
        3
      )}</td>
      <td class="text-center">${desorcion}</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="" colspan="2">Servicio de Refinación Au</td>
      <td class="text-center">${oroFino}</td>
      <td class="text-center">${parseFloat(serviceData[1].price).toFixed(
        3
      )}</td>
      <td class="text-center">${auRefinacionTotal}</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="" colspan="2">Servicio de Refinación Ag</td>
      <td class="text-center">${plataFina}</td>
      <td class="text-center">${parseFloat(serviceData[2].price).toFixed(
        3
      )}</td>
      <td class="text-center">${agRefinacionTotal}</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="" colspan="2">Servico de transporte de carbon</td>
      <td class="text-center">${plataSeco}</td>
      <td class="text-center">${parseFloat(serviceData[3].price).toFixed(
        3
      )}</td>
      <td class="text-center">${transporte}</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <td class="text-center"></td>
      <td class="text-center"></td>
      <td class="" colspan="2">IGV SERVICIOS</td>
      <td class="text-center"></td>
      <td class="text-center">${parseFloat(serviceData[4].price).toFixed(
        3
      )}</td>
      <td class="text-center">47.13</td>
    </tr>
    <tr>
      <th class="text-center"></th>
      <th class="text-center"></th>
      <th class="text-center"></th>
      <th class="" colspan="2">TOTAL A PAGAR</th>
      <th class="text-center"></th>
      <th class="text-center">US$</th>
      <th class="text-center" id="totalLiquidacion">${pagoTotal}</th>
    </tr>
    `;
  $("#tablaTotal tbody").append(tablaTotalBody);
  if (edit?.status) {
    var elements = document.querySelectorAll("#editButtonTable");
    elements.forEach((element) => {
      element.parentNode.removeChild(element);
    });
  }
};

const obtenerTablaTotalValores = () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "http://localhost/practica/Liquidacion/obtenerTotalValores",
      type: "POST",
      dataType: "json",
    })
      .done(function (datos) {
        resolve(datos); // Resuelve la promesa con los datos recibidos
      })
      .fail(function (xhr, textStatus, errorThrown) {
        reject(xhr.responseText); // Rechaza la promesa con el mensaje de error
      });
  });
};

const editarAnalisisFinal = (id) => {
  const fila = document.getElementById("analisisFinal" + id);

  if (fila) {
    var pesoGrs = fila.cells[2].innerText;
    var accion_inter_onza = fila.cells[3].innerText;
    var accion_inter_grs = fila.cells[4].innerText;
    var valorGrs = fila.cells[5].innerText;
    var descuento = fila.cells[6].innerText.split("%")[0];
    var netoGrs = fila.cells[7].innerText;

    fila.cells[0].innerHTML = `
        <span class="btn btn-icon text-primary" onclick="guardarAnalisisFinal('${id}')">
          <i class="mdi mdi-check text-primary"></i>
        </span>
      `;
    fila.cells[2].innerHTML =
      '<input disabled type="text" id="seco-' +
      id +
      '" value="' +
      pesoGrs +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[3].innerHTML =
      '<input type="text" id="officeLaw-' +
      id +
      '" value="' +
      accion_inter_onza +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[4].innerHTML =
      '<input disabled type="text" id="clientLaw-' +
      id +
      '" value="' +
      accion_inter_grs +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[5].innerHTML =
      '<input disabled type="text" id="difference-' +
      id +
      '" value="' +
      valorGrs +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[6].innerHTML =
      '<input type="text" id="final-' + id + '" value="' + descuento + '">';
    fila.cells[7].innerHTML =
      '<input disabled type="text" id="neto-' +
      id +
      '" value="' +
      netoGrs +
      '">';
  }
};

const guardarAnalisisFinal = async (id) => {
  const userId = $("#cliente").val();
  var fila = document.getElementById("analisisFinal" + id);
  if (fila) {
    const analisisData = {
      element: id,
      accion_inter_onza: parseFloat(
        fila.cells[3].getElementsByTagName("input")[0].value
      ),
      descuento: parseFloat(
        fila.cells[6].getElementsByTagName("input")[0].value
      ),
    };

    $.ajax({
      url: "http://localhost/practica/Liquidacion/actualizarAnalisis/" + userId,
      type: "POST",
      data: { id: Number(userId), analisisData: analisisData },
      dataType: "json",
    })
      .done(function (datos) {
        fila.cells[0].innerHTML = `
            <span class="btn btn-icon text-primary" onclick="editarAnalisisFinal('${id}')" id='editButtonTable'>
              <i class="mdi mdi-pencil"></i>
            </span>
          `;
        fila.cells[2].innerHTML =
          fila.cells[2].getElementsByTagName("input")[0].value;
        fila.cells[3].innerHTML =
          fila.cells[3].getElementsByTagName("input")[0].value;
        fila.cells[4].innerHTML =
          fila.cells[4].getElementsByTagName("input")[0].value;
        fila.cells[5].innerHTML =
          fila.cells[5].getElementsByTagName("input")[0].value;
        fila.cells[6].innerHTML =
          fila.cells[6].getElementsByTagName("input")[0].value;
        fila.cells[7].innerHTML =
          fila.cells[7].getElementsByTagName("input")[0].value;
        mostrarTablasAnalisisById(userId);
      })
      .fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
      });
  }
};
