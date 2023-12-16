const containerClasses = '.insights, .contenedor__clientes, .contenedor__pedidos, .contenedor__facturas, .contenedor__colegios, .contenedor__uniformes, .contenedor__producto__terminado, .contenedor__materia__prima, .contenedor__proveedores, .contenedor10-sidebar10';
const products = ['CAMISA HOMBRE', 'PANTALON HOMBRE', 'BUSO HOMBRE', 'SHORTS HOMBRE', 'CAMISA MUJER', 'PANTALON MUJER', 'VESTIDO', 'FALDA', 'CAMISA DIARIO HOMBRE', 'PANTALON DIARIO HOMBRE', 'CAMISA ED. FISICA HOMBRE', 'SUDADERA HOMBRE', 'CAMISA DIARIO MUJER', 'JARDINERA', 'FALDA ESCOLAR', 'CAMISA ED. FISICA MUJER', 'SUDADERA MUJER'];
const schoolProducts = ['CAMISA DIARIO HOMBRE', 'PANTALON DIARIO HOMBRE', 'CAMISA ED. FISICA HOMBRE', 'SUDADERA HOMBRE', 'CAMISA DIARIO MUJER', 'JARDINERA', 'FALDA ESCOLAR', 'CAMISA ED. FISICA MUJER', 'SUDADERA MUJER'];
const schools = ['Politecnico', 'Comfandi', 'Academico'];
const stateClasses = {
  'Encargado': 'primary',
  'Entregado': 'danger'
};

function createOption(value, text) {
  const option = document.createElement('option');
  option.value = value.toLowerCase().replace(' ', '');
  option.textContent = text;
  return option;
}

document.querySelectorAll('.sidebar a').forEach((item, index) => {
  item.addEventListener('click', event => {
    document.querySelectorAll('.sidebar a').forEach(link => link.classList.remove('active'));
    event.currentTarget.classList.add('active');
    let h3Text = event.currentTarget.querySelector('h3').textContent;
    document.querySelector('h1').textContent = h3Text;
    document.querySelectorAll(containerClasses).forEach(container => {
      container.style.display = 'none';
    });
    let container = document.querySelectorAll(containerClasses)[index];
    if (container) {
      container.style.display = 'grid';
    }
  });
});

document.getElementById('nuevoPedidoBoton').addEventListener('click', function() {
  var orderContainer = document.getElementById('pedidoid');
  var newOrder = document.createElement('div');
  newOrder.className = 'pedido';

  var productSelect = document.createElement('select');
  productSelect.className = 'productos';
  products.forEach(product => productSelect.appendChild(createOption(product, product)));

  productSelect.addEventListener('change', function() {
    var selectedProduct = this.options[this.selectedIndex].textContent;
    var schoolSelect = newOrder.querySelector('.schools');
    if (schoolSelect) {
      newOrder.removeChild(schoolSelect);
    }
    if (schoolProducts.includes(selectedProduct)) {
      schoolSelect = document.createElement('select');
      schoolSelect.className = 'schools';
      schools.forEach(school => schoolSelect.appendChild(createOption(school, school)));
      newOrder.insertBefore(schoolSelect, cancelButton);
    }
  });

  var medidaLargo = document.createElement('input');
  medidaLargo.type = 'text';
  medidaLargo.className = 'largo';
  medidaLargo.placeholder = 'Largo'; medidaLargo
  var medidaAncho = document.createElement('input');
  medidaAncho.type = 'text';
  medidaAncho.className = 'ancho';
  medidaAncho.placeholder = 'Ancho';

  var cancelButton = document.createElement('button');
  cancelButton.textContent = 'Cancelar Pedido';
  cancelButton.addEventListener('click', function() {
    orderContainer.removeChild(newOrder);
  });

  newOrder.appendChild(productSelect);
  newOrder.appendChild(medidaLargo);
  newOrder.appendChild(medidaAncho);
  newOrder.appendChild(cancelButton);
  orderContainer.appendChild(newOrder);
});

function updateClassesBasedOnState() {
  var stateCells = document.querySelectorAll('#tabla__facturas tbody tr td:last-child');
  stateCells.forEach(function(td) {
    var state = td.textContent.trim();
    td.className = '';
    if (stateClasses[state]) {
      td.classList.add(stateClasses[state]);
    }
  });
}
updateClassesBasedOnState();