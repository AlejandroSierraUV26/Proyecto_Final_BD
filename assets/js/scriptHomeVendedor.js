const containerClasses = '.contenedor__menu, .contenedor__clientes, .contenedor__pedidos, .contenedor__facturas, .contenedor__colegios, .contenedor__uniformes, .contenedor__producto__terminado';
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

// counter.js
let seconds = 0;
let minutes = 0;
let hours = 0;

function pad(val) {
    return val > 9 ? val : "0" + val;
}

window.onload = function() {
    // Load saved time from localStorage if it exists
    if (localStorage.getItem('hours')) {
        hours = parseInt(localStorage.getItem('hours'));
        minutes = parseInt(localStorage.getItem('minutes'));
        seconds = parseInt(localStorage.getItem('seconds'));
    }

    setInterval(function() {
        seconds++;
        if (seconds >= 60) {
            minutes++;
            seconds = 0;
        }
        if (minutes >= 60) {
            hours++;
            minutes = 0;
        }
        document.getElementById('counter2').textContent = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);

        // Save time to localStorage every second
        localStorage.setItem('hours', hours);
        localStorage.setItem('minutes', minutes);
        localStorage.setItem('seconds', seconds);
    }, 1000);
};

// Get the logout link element
let logoutLink = document.getElementById('logout2');

// Add click event listener
logoutLink.addEventListener('click', function() {
    // Reset counter
    seconds = 0;
    minutes = 0;
    hours = 0;

    // Update counter display
    document.getElementById('counter2').textContent = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);

    // Save reset counter to localStorage
    localStorage.setItem('hours', hours);
    localStorage.setItem('minutes', minutes);
    localStorage.setItem('seconds', seconds);
});