'use strict'

function save_entrada(id_producto) {

  let id_entrada = document.getElementById(`id_entrada`).value;
  let cantidad = document.getElementById(`cantidad${id_producto}`).value;
  let observacion = document.getElementById(`observacion${id_producto}`).value;

  let cantidadValue = validate_numberInt(cantidad);

  if (cantidadValue === undefined || validate_numberInt(id_entrada) === undefined ) {
    alert("Insertar datos correctos");
    return false;
  }

  let url = "http://localhost/micafe/app/entradaproducto.php";
  fetch(url, {
    method: 'post',
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: `cantidad=${cantidad}&observacion=${observacion}&id_entrada=${id_entrada}&id_producto=${id_producto}`
  }).then(response => {
    return response.text();
  }).then(text => {
      alert(text);
      location.reload(true);
  }).catch(error => {
      alert('Not connect');
  });
}

function save_salida(id_producto) {

  let id_salida = document.getElementById(`id_salida`).value;
  let cantidad = document.getElementById(`cantidad${id_producto}`).value;
  let observacion = document.getElementById(`observacion${id_producto}`).value;

  let cantidadValue = validate_numberInt(cantidad);

  if (cantidadValue === undefined || validate_numberInt(id_salida) === undefined ) {
    alert("Insertar datos correctos");
    return false;
  }

  let url = "http://localhost/micafe/app/salidaproducto.php";
  fetch(url, {
    method: 'post',
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: `cantidad=${cantidad}&observacion=${observacion}&id_salida=${id_salida}&id_producto=${id_producto}`
  }).then(response => {
    return response.text();
  }).then(text => {
    alert(text);
    location.reload(true);
  }).catch(error => {
    alert('Not connect');
  });
}

function save_orden(id_producto, precio) {

  let id_pedido = document.getElementById(`id_pedido`).value;
  let cantidad = document.getElementById(`cantidad${id_producto}`).value;

  let cantidadValue = validate_numberInt(cantidad);
  let precio_total = validate_numberFloat(precio);

  if (cantidadValue === undefined || validate_numberInt(id_pedido) === undefined || precio_total === undefined) {
    alert("Insertar datos incorrectos");
    return false;
  }

  precio_total = cantidadValue * precio_total;

  let url = "http://localhost/micafe/app/orden.php";
  fetch(url, {
    method: 'post',
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
    },
    body: `cantidad=${cantidad}&id_pedido=${id_pedido}&id_producto=${id_producto}&precio=${precio_total}`
  }).then(response => {
    return response.text();
  }).then(text => {
    alert(text);
    location.reload(true);
  }).catch(error => {
    alert('Not connect');
  });
}

function validate_numberInt(number) {
  return number !== '' ? parseInt(number): undefined;
}

function validate_numberFloat(number) {
  return number !== '' ? parseFloat(number): undefined;
}

function cleanSelected () {
  let elements = document.getElementsByClassName('custom-select');
  for (let indexElement=0; indexElement < elements.length; indexElement++) {
    let select = elements[indexElement];

    for (let indexSelect=0 ; indexSelect < select.length; indexSelect++) {
      select[indexSelect].removeAttribute('selected');
    }
  }
  alert('ok');
}