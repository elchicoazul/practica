function exportarAPDF(idLiquidation) {
  $.ajax({
    url:
      "http://localhost/practica/Liquidacion/obtenerDetalleLiquidacion/" +
      idLiquidation,
    type: "GET",
    dataType: "json",
  }).done(async function (data) {
    var contenidoDatos = "";
    var contenidoAnalisisAU = "";
    var contenidoAnalisisAG = "";
    var contenidoDatosTotal = "";
    // DATOS DE GUIA
    data.guia.map(function (item, index) {
      const fila = `
        <tr>
          <td>${index + 1}</td>
          <td>Guía #1</td>
          <td>${item.guide_code}</td>
          <td>${item.wet_weight}</td>
          <td>${item.moisture_percentage}</td>
          <td>${item.dry_weight}</td>
        </tr>`;
      contenidoDatos += fila;
    });
    const totales = `
    <tr>
        <td>Tot</td>
        <td></td>
        <td></td>
        <td>${data.guia
          .reduce((acc, curr) => acc + Number(curr.wet_weight), 0)
          .toFixed(2)}</td>
        <td></td>
        <td>${data.guia
          .reduce((acc, curr) => acc + Number(curr.dry_weight), 0)
          .toFixed(2)}</td>
      </tr>`;
    contenidoDatos += totales;

    // DATOS DE ANALISIS AU
    const datosAU = data.detalle.filter((e) => e.element === "AU");
    var contenidoAnalisisAU = obtenerTablaDatos(datosAU, "tablaAnalisisAU");

    // DATOS DE ANALISIS AG
    const datosAG = data.detalle.filter((e) => e.element === "AG");
    var contenidoAnalisisAG = obtenerTablaDatos(datosAG, "tablaAnalisisAG");

    // DATOS DE ANALISIS TOTAL
    var contenidoDatosTotal = await obtenerTablaTotal({
      status: true,
      data: data,
      oroSeco: Number(contenidoAnalisisAU.elSecoTotal),
      plataSeco: Number(contenidoAnalisisAG.elSecoTotal),
      oroFino: Number(contenidoAnalisisAU.elNetoTotal),
      plataFina: Number(contenidoAnalisisAG.elNetoTotal),
    });
    var ventanaImpresion = window.open("", "_blank");

    // Escribe el contenido del div en la nueva ventana
    ventanaImpresion.document.write(
      '<html><head><title>Impresion de Liquidación</title><style>*{text-align:center;font-size:13px;}table , td , th{border-bottom:1px solid ;border-spacing: 0;border-collapse: collapse;}table{width: 100%;}</style></head><body style="margin:5%"><div style="height: 120px;width=100%;"></div>'
    );
    ventanaImpresion.document.write(
      '<h4 style="text-align:center;">Datos Cliente</h4><table class="table" id="tablaDatos"><thead><tr><th>Item</th><th>Guía</th><th>Código</th><th>Peso Hum (KG)</th><th>Humedad (%)</th><th>Peso Seco (KG)</th></tr></thead><tbody>' +
        contenidoDatos +
        "</tbody></table>"
    );
    ventanaImpresion.document.write(
      '<h4 style="text-align:center;">Tabla De Análisis Au</h4><table class="table" id="tablaAnalisisAU"><thead><tr><th>Item</th><th>Peso Seco (Kg.)</th><th>Ley Oroan (grs./Kg. Carbón)</th><th>Ley Cliente</th><th>Dirimencia</th><th>Ley Final</th><th>Neto (Kg.)</th></tr></thead><tbody>' +
        contenidoAnalisisAU.tablaTotal +
        "</tbody></table>"
    );

    ventanaImpresion.document.write(
      '<h4 style="text-align:center;">Tabla De Análisis Ag</h4><table class="table" id="tablaAnalisisAG"><thead><tr><th>Item</th><th>Peso Seco (Kg.)</th><th>Ley Oroan (grs./Kg. Carbón)</th><th>Ley Cliente</th><th>Dirimencia</th><th>Ley Final</th><th>Neto (Kg.)</th></tr></thead><tbody>' +
        contenidoAnalisisAG.tablaTotal +
        "</tbody></table>"
    );

    ventanaImpresion.document.write(
      '<h4 style="text-align:center;">Tabla De Análisis Total</h4><table class="table" id="tablaTotal"><thead><tr><th><div class="text-center">Tipo de</div><div class="text-center">Metal</div></th><th><div class="text-center">Peso de</div><div class="text-center">Metal grs</div></th><th><div class="text-center">Accion internacional</div><div class="text-center">USD$ onza</div></th><th><div class="text-center">Accion internacional</div><div class="text-center">USD$ grs</div></th><th><div class="text-center">Valor metal</div><div class="text-center">USD$ grs</div></th><th><div class="text-center">Descuento</div><div class="text-center">%</div></th><th><div class="text-center">Valor Neto</div><div class="text-center">USD$ grs</div></th></tr></thead><tbody>' +
        contenidoDatosTotal +
        "</tbody></table>"
    );
    ventanaImpresion.document.write("</body></html>");
    ventanaImpresion.document.close();
    ventanaImpresion.print();
    ventanaImpresion.close();
  });
}
const obtenerTablaDatos = (data, tableId) => {
  var totalTabla = "";
  const analisisResults = data.map((item, index) => {
    const fila = `
      <tr id="fila-${item.id}">
        <td>${index + 1}</td>
        <td>${item.dry_weight}</td>
        <td>${item.office_law}</td>
        <td>${item.client_law}</td>
        <td>${item.difference}</td>
        <td>${item.final_law}</td>
        <td>${item.net_kg}</td>
      </tr>`;
    totalTabla += fila;
    return {
      dryWeigth: Number(item.dry_weight),
      netKg: Number(item.net_kg),
    };
  });
  const ley = tableId === "tablaAnalisisAG" ? "leyGenAG" : "leyGenAU";
  const entregar =
    tableId === "tablaAnalisisAG" ? "porEntregarAG" : "porEntregarAU";
  const pesoNetoTotal = analisisResults
    .reduce((acc, curr) => acc + curr.netKg, 0)
    .toFixed(2);
  const pesoSecoTotal = analisisResults
    .reduce((acc, curr) => acc + curr.dryWeigth, 0)
    .toFixed(2);
  let leyGeneralCola = data[0].element_law;
  leyGeneralCola =
    leyGeneralCola === "0.0000"
      ? tableId === "tablaAnalisisAG"
        ? tailings_law
        : gold_law
      : parseFloat(leyGeneralCola);
  const leyGeneralColaTotal = (pesoSecoTotal * (leyGeneralCola / 100)).toFixed(
    2
  );
  const netoTotalMenosLey = (pesoNetoTotal - leyGeneralColaTotal).toFixed(2);
  let elementoPorEntregar = data[0].element_to_deliver;
  elementoPorEntregar =
    elementoPorEntregar === "0.0000"
      ? tableId === "tablaAnalisisAG"
        ? pine_silver_to_deliver
        : fine_gold_to_deliver
      : parseFloat(elementoPorEntregar);
  const elementoPorEntregarTotal = (
    netoTotalMenosLey *
    (elementoPorEntregar / 100)
  ).toFixed(2);

  const total = `
      <tr>

        <th>Totales</th>
        <th>${pesoSecoTotal}</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th id="totalKgs">${pesoNetoTotal}</th>
      </tr>
      <tr id="fila-${ley}">

        <th></th>
        <th></th>
        <th></th>
        <th colspan="2">Ley general de cola (grs/Kg.):</th>
        <th>${leyGeneralCola.toFixed(2)}%</th>
        <th>${leyGeneralColaTotal}</th>
      </tr>
      <tr>

        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>${netoTotalMenosLey}</th>
      </tr>
      <tr id="fila-${entregar}">

        <th></th>
        <th></th>
        <th></th>
        <th colspan="2">${
          tableId === "tablaAnalisisAG"
            ? "Plata Piña por entregar:"
            : "Oro fino por entregar:"
        }</th>
        <th>${elementoPorEntregar.toFixed(2)}%</th>
        <th>${elementoPorEntregarTotal}</th>
      </tr>
    `;
  totalTabla += total;
  return {
    elSecoTotal: pesoSecoTotal, // este no se si deba enviarlo a la tabla final, revisar esto
    elNetoTotal: elementoPorEntregarTotal,
    tablaTotal: totalTabla,
  };
};

const obtenerTablaTotal = async (edit) => {
  let oroSeco = 0.0;
  let plataSeco = 0.0;
  let oroFino = 0.0;
  let plataFina = 0.0;
  const datos = await obtenerTablaTotalValoresImpresion();
  var serviceData = datos[0];
  const configurationData = datos[1];
  if (edit?.status) {
    serviceData = edit.data.servicios;
    oroSeco = edit ? edit.oroSeco : 0.0;
    plataSeco = edit ? edit.plataSeco : 0.0;
    oroFino = edit ? edit.oroFino : 0.0;
    plataFina = edit ? edit.plataFina : 0.0;
  }
  let auOnza = parseFloat(configurationData[0].value).toFixed(2);
  if (edit?.status) {
    auOnza = edit.data.detalle.find(
      (element) => element.element === "AU"
    ).accion_inter_onza;
  } else {
    auOnza = accion_inter_onza_au === "0.00" ? auOnza : accion_inter_onza_au;
  }
  const auGrms = (auOnza / 31.1035).toFixed(2);
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
  const agGrms = (agOnza / 31.1035).toFixed(2);
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

      <td class="text-center">ORO</td>
      <td class="text-center">${oroFino}</td>
      <td class="text-center">${auOnza}</td>
      <td class="text-center">${auGrms}</td>
      <td class="text-center">${auValorMetalGrms}</td>
      <td class="text-center">${auDescuento}%</td>
      <td class="text-center">${auNetoGrs}</td>
    </tr>
    <tr id="analisisFinalAG">

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
      <td class="text-center">${parseFloat(serviceData[0].price).toFixed(
        3
      )}</td>
      <td class="text-center">${desorcion}</td>
    </tr>
    <tr>

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
      <th class="" colspan="2">TOTAL A PAGAR</th>
      <th class="text-center"></th>
      <th class="text-center">US$</th>
      <th class="text-center">${pagoTotal}</th>
    </tr>
    `;
  return tablaTotalBody;
};
const obtenerTablaTotalValoresImpresion = () => {
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

///exportar a pdf Guia
function exportarAPDFguia(idLiquidation) {
  window.open("http://localhost/practica/Liquidacion/obtenerDetalleGuia/" + idLiquidation, '_blank');
}

function exportarAPDFliquidacion(idLiquidation) {
  window.open("http://localhost/practica/Liquidacion/obtenerDetalleLiquidacion/" + idLiquidation, '_blank');
}