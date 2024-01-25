const renderElementsAnalisis = (data, tableId) => {
  const analisisResults = data.map((item, index) => {
    const fila = `
      <tr id="fila-${item.id}">
        <td>
          <span class="btn btn-icon text-primary" onclick="editarAnalisis(${
            item.id
          })" id="editButtonTable">
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
    $("#" + tableId + " tbody").append(fila);
    return {
      dryWeigth: Number(item.dry_weight),
      netKg: Number(item.net_kg),
    };
  });
  const ley = tableId === "tablaAnalisisAG" ? "leyGenAG" : "leyGenAU";
  const entregar =
    tableId === "tablaAnalisisAG" ? "porEntregarAG" : "porEntregarAU";

  // primera fila
  const pesoNetoTotal = analisisResults
    .reduce((acc, curr) => acc + curr.netKg, 0)
    .toFixed(2);
  const pesoSecoTotal = analisisResults
    .reduce((acc, curr) => acc + curr.dryWeigth, 0)
    .toFixed(2);

  // segunda fila
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

  // tercera fila
  const netoTotalMenosLey = (pesoNetoTotal - leyGeneralColaTotal).toFixed(2);

  // cuarta fila
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
        <th></th>
        <th>Totales</th>
        <th>${pesoSecoTotal}</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th id="totalKgs">${pesoNetoTotal}</th>
      </tr>
      <tr id="fila-${ley}">
        <th>
          <span class="btn btn-icon text-primary"  onclick="editarAnalisisTotal('${ley}')" id='editButtonTable'>
            <i class="mdi mdi-pencil"></i>
          </span>
        </th>
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
        <th></th>
        <th>${netoTotalMenosLey}</th>
      </tr>
      <tr id="fila-${entregar}">
        <th>
        <span class="btn btn-icon text-primary" onclick="editarAnalisisTotal('${entregar}')" id='editButtonTable'>
            <i class="mdi mdi-pencil"></i>
          </span>
        </th>
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
  $("#" + tableId + " tbody").append(total);

  return {
    elSecoTotal: pesoSecoTotal, // este no se si deba enviarlo a la tabla final, revisar esto
    elNetoTotal: elementoPorEntregarTotal,
  };
};

function editarAnalisis(id) {
  var fila = document.getElementById("fila-" + id);

  if (fila) {
    var secoValor = fila.cells[2].innerText;
    var officeLawValor = fila.cells[3].innerText;
    var clientLawValor = fila.cells[4].innerText;
    var differenceValor = fila.cells[5].innerText;
    var finalValor = fila.cells[6].innerText;
    var netoValor = fila.cells[7].innerText;

    fila.cells[0].innerHTML = `
        <span class="btn btn-icon text-primary" onclick="guardarAnalisis(${id})">
          <i class="mdi mdi-check text-primary"></i>
        </span>
      `;
    fila.cells[2].innerHTML =
      '<input disabled type="text" id="seco-' +
      id +
      '" value="' +
      secoValor +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[3].innerHTML =
      '<input type="text" id="officeLaw-' +
      id +
      '" value="' +
      officeLawValor +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[4].innerHTML =
      '<input type="text" id="clientLaw-' +
      id +
      '" value="' +
      clientLawValor +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[5].innerHTML =
      '<input type="text" id="difference-' +
      id +
      '" value="' +
      differenceValor +
      '" onkeyup="leyes(' +
      id +
      ')">';
    fila.cells[6].innerHTML =
      '<input disabled type="text" id="final-' +
      id +
      '" value="' +
      finalValor +
      '">';
    fila.cells[7].innerHTML =
      '<input disabled type="text" id="neto-' +
      id +
      '" value="' +
      netoValor +
      '">';
  }
}

const guardarAnalisis = async (id) => {
  var fila = document.getElementById("fila-" + id);
  if (fila) {
    const analisisData = {
      seco: parseFloat(fila.cells[2].getElementsByTagName("input")[0].value),
      officeLaw: parseFloat(
        fila.cells[3].getElementsByTagName("input")[0].value
      ),
      clientLaw: parseFloat(
        fila.cells[4].getElementsByTagName("input")[0].value
      ),
      difference: parseFloat(
        fila.cells[5].getElementsByTagName("input")[0].value
      ),
      final: parseFloat(fila.cells[6].getElementsByTagName("input")[0].value),
      neto: parseFloat(fila.cells[7].getElementsByTagName("input")[0].value),
    };

    $.ajax({
      url: "http://localhost/practica/Liquidacion/actualizarAnalisis/" + id,
      type: "POST",
      data: { id: Number(id), analisisData: analisisData },
      dataType: "json",
    })
      .done(function (datos) {
        fila.cells[0].innerHTML = `
          <span class="btn btn-icon text-primary" onclick="editarAnalisis(${id})" id='editButtonTable'>
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
        const userId = $("#cliente").val();
        mostrarTablasAnalisisById(userId);
      })
      .fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
      });
  }
};

function editarAnalisisTotal(filaId) {
  var fila = document.getElementById("fila-" + filaId);
  if (fila) {
    fila.cells[0].innerHTML = `
      <span class="btn btn-icon text-primary" onclick="guardarAnalisisTotal('${filaId}')">
        <i class="mdi mdi-check text-primary"></i>
      </span>
      `;
    var finalValor = fila.cells[5].innerText.split("%")[0];
    fila.cells[5].innerHTML =
      '<input type="text" id="final-' +
      filaId +
      '" value="' +
      finalValor +
      '">';
  }
}

const guardarAnalisisTotal = async (filaId) => {
  const userId = $("#cliente").val();
  var fila = document.getElementById("fila-" + filaId);
  const tipoLey =
    filaId === "leyGenAG" || filaId === "leyGenAU"
      ? parseFloat(fila.cells[5].getElementsByTagName("input")[0].value)
      : null;
  const tipoEntrega =
    filaId === "porEntregarAG" || filaId === "porEntregarAU"
      ? parseFloat(fila.cells[5].getElementsByTagName("input")[0].value)
      : null;

  const porcentajeValor = [];
  if (filaId === "porEntregarAU") {
    porcentajeValor[0] =
      document.getElementById("fila-leyGenAU").cells[5].innerText;
    porcentajeValor[0] = parseFloat(porcentajeValor[0]);
  }
  if (filaId === "leyGenAU") {
    porcentajeValor[1] =
      document.getElementById("fila-porEntregarAU").cells[5].innerText;
    porcentajeValor[1] = parseFloat(porcentajeValor[1]);
  }
  if (filaId === "porEntregarAG") {
    porcentajeValor[2] =
      document.getElementById("fila-leyGenAG").cells[5].innerText;
    porcentajeValor[2] = parseFloat(porcentajeValor[2]);
  }
  if (filaId === "leyGenAG") {
    porcentajeValor[3] =
      document.getElementById("fila-porEntregarAG").cells[5].innerText;
    porcentajeValor[3] = parseFloat(porcentajeValor[3]);
  }

  if (fila) {
    const analisisData = {
      element:
        filaId === "leyGenAG" || filaId === "porEntregarAG" ? "AG" : "AU",
      element_law:
        tipoLey === null ? porcentajeValor.filter((e) => e > 0)[0] : tipoLey,
      element_to_deliver:
        tipoEntrega === null
          ? porcentajeValor.filter((e) => e > 0)[0]
          : tipoEntrega,
    };

    $.ajax({
      url: "http://localhost/practica/Liquidacion/actualizarAnalisis/" + userId,
      type: "POST",
      data: { id: Number(userId), analisisData: analisisData },
      dataType: "json",
    })
      .done(function (datos) {
        fila.cells[0].innerHTML = `
            <span class="btn btn-icon text-primary" onclick="editarAnalisisTotal(${filaId})" id='editButtonTable'>
              <i class="mdi mdi-pencil"></i>
            </span>
          `;
        fila.cells[5].innerHTML =
          fila.cells[5].getElementsByTagName("input")[0].value;
        mostrarTablasAnalisisById(userId);
      })
      .fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
      });
  }
};
