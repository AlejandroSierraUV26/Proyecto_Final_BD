document.querySelectorAll('.sidebar a').forEach((item, index) => {
    item.addEventListener('click', event => {
      document.querySelectorAll('.sidebar a').forEach(link => link.classList.remove('active'));
      event.currentTarget.classList.add('active');
      let h3Text = event.currentTarget.querySelector('h3').textContent;
      document.querySelector('h1').textContent = h3Text;
      document.querySelectorAll('.insights, .contenedor__clientes, .contenerdor3-sidebar3, .contenedor4-sidebar4, .contenerdor5-sidebar5, .contenedor6-sidebar6, .contenerdor7-sidebar7, .contenedor8-sidebar8, .contenerdor9-sidebar9, .contenedor10-sidebar10').forEach(container => {
        container.style.display = 'none';
      });
      let container = document.querySelectorAll('.insights, .contenedor__clientes, .contenerdor3-sidebar3, .contenedor4-sidebar4, .contenerdor5-sidebar5, .contenedor6-sidebar6, .contenerdor7-sidebar7, .contenedor8-sidebar8, .contenerdor9-sidebar9, .contenedor10-sidebar10')[index];
      if (container) {
        container.style.display = 'grid';
      }
    });
  });