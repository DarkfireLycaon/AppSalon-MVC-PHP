let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita ={
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Configura los eventos de los tabs
    botonesPaginador(); // Maneja los botones de paginación
    paginaSiguiente();
    paginaAnterior();
    
//consulta la api en el back de php
    consultarAPI();
    idCliente();
    nombreCliente(); //añade el nombre del cliente al objeto de cita
    seleccionarFecha(); //añade fecha
    seleccionarHora(); //añade la hora de la cita en el objeto
    mostrarResumen(); // muestra el resumen de la cita
}

function mostrarSeccion() {
    // Ocultar la sección que tenga la clase 'mostrar'
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la sección con el paso actual
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    
    // Verificar que la sección existe antes de agregar la clase 'mostrar'
    if (seccion) {
        seccion.classList.add('mostrar');
    } else {
        console.warn(`No se encontró la sección con el selector: ${pasoSelector}`);
    }

    // Quitar la clase 'actual' del tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resaltar el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    if (tab) {
        tab.classList.add('actual');
    }
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso); // Actualiza el paso
            mostrarSeccion(); // Muestra la sección correspondiente
            botonesPaginador(); // Actualiza los botones de paginación

            if(paso===3){
                mostrarResumen();
            }
        });
    });
}

// Función independiente para manejar la visibilidad de los botones de paginación
function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    // Verifica que los elementos existan
        if (paso === 1) {
            paginaAnterior.classList.add('ocultar');
            paginaSiguiente.classList.remove('ocultar');
        } else if (paso === 3) {
            paginaAnterior.classList.remove('ocultar');
            paginaSiguiente.classList.add('ocultar');
           mostrarResumen();
        } else {
            paginaAnterior.classList.remove('ocultar');
            paginaSiguiente.classList.remove('ocultar');
        }
        mostrarSeccion();
    } 

    function paginaSiguiente(){
        const paginaSiguiente = document.querySelector('#siguiente');
        paginaSiguiente.addEventListener('click', function(){
            if (paso >= pasoFinal) return;
            paso++;
            mostrarSeccion();
            botonesPaginador();
        });
    }
    
    function paginaAnterior(){
        const paginaAnterior = document.querySelector('#anterior');
        paginaAnterior.addEventListener('click', function(){
            if (paso <= pasoInicial) return;
            paso--;
            mostrarSeccion();
            botonesPaginador();
        });
    }
   async function consultarAPI(){
try{
    const url = '/api/servicios';
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);

  
} catch (error) {
    console.log(error);

}
    }
    function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick= function(){
            seleccionarServicio(servicio);

        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Agregar el div de servicio al contenedor de servicios
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}
function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;
    //identificar el elimento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    //comprobar si un servicio ya fue agregado o quitarlo
    if(servicios.some(agregado => agregado.id === id)){
           //eliminarlo
            cita.servicios = servicios.filter(agregado => agregado.id !== id);
            divServicio.classList.remove('seleccionado');
    } else{
          //agregarlo
          cita.servicios = [...servicios, servicio];
          divServicio.classList.add('seleccionado');
    }
    

   
   

    console.log(servicio);

}
function idCliente(){
    cita.id = document.querySelector('#id').value;

}
function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
    
}
function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes (dia)){
            e.target.value = '';
            mostrarAlerta('Weekends not allowed', 'error', '.formulario');

        } else{
            cita.fecha = e.target.value
        }

    });
}
function mostrarAlerta(mensaje, tipo, elemento,desaparece = true){
    const alertaPrevia = document.querySelector('.alerta');
    if ( alertaPrevia) {
        alertaPrevia.remove();
    }
    //scripting para acrear alerta
 const alerta = document.createElement('DIV');
 alerta.textContent = mensaje;
 alerta.classList.add('alerta');
 alerta.classList.add(tipo);

 const referencia = document.querySelector (elemento);
 referencia.appendChild(alerta);
 if(desaparece){
    setTimeout(() => {
        alerta.remove();
     }, 3000);
    //eliminar alerta
 }

 
}
function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora. addEventListener('input', function(e){
        const horaCita = e.target.value
        const hora = horaCita.split(':')[0];
        if(hora<10  || hora>18 ){
            e.target.value = '';
            mostrarAlerta('Invalid hour', 'error', '.formulario');
        } else{
            cita.hora = e.target.value;
            console.log(cita);
        }

    })
}
function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');
    //limpiar contenido resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }
    if (Object.values(cita).includes('') || cita.servicios.length === 0){
       mostrarAlerta('Error information date or time missing', 'error', '.contenido-resumen', false);
       return;
    } 
    // formatear el div de resumen
    const{nombre, fecha, hora, servicios } = cita;



    //heading para los servicios
const headingServicios = document.createElement('h3');
headingServicios.textContent = 'Summary of the services';
resumen.appendChild(headingServicios);

// iterando y mostrando los servicios
    servicios.forEach(servicio =>{
        const {id, precio, nombre} = servicio;
      const contenedorServicio = document.createElement('DIV');
      contenedorServicio.classList.add('contenedor-servicio');
      const textoServicio = document.createElement('P');
      textoServicio.textContent = nombre;

      const precioServicio = document.createElement('P');
       precioServicio .innerHTML = `<span>Price: </span> $${precio}`;

       contenedorServicio.appendChild(textoServicio);
       contenedorServicio.appendChild(precioServicio);

       resumen.appendChild(contenedorServicio);

    });

    //para cita resumen
    const headingCita = document.createElement('H3');
headingCita.textContent = 'Summary of the appointment';
resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Name:</span> ${nombre}`;

    //manipular la fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() +2 ;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
const fechaFormateada = fechaUTC.toLocaleDateString('en-GB', opciones)

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Date:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Time:</span> ${hora}`;

    //boton para crear cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = ('Book Appointment');
    botonReservar.onclick = reservarCita;


    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
    
    }
    async function reservarCita(){

        const {nombre, fecha, hora, servicios, id} = cita; 

        const idServicios = servicios.map(servicio=>servicio.id);
        const datos = new FormData();
        datos.append('fecha', fecha);
        datos.append('hora', hora);
        datos.append('usuarioId', id);
        datos.append('servicios', idServicios);

       // console.log([...datos]);
  try {
    const url = '/api/citas'

    const respuesta = await fetch(url, {
        method: 'POST',
         body: datos
    });
    const resultado = await respuesta.json();
    console.log(resultado);
    
    if(resultado.resultado){
        Swal.fire({
            icon: "success",
            title: "Appointed created",
            text: "Your appointment was created successfully",
            button:'Ok'
          }).then(() => {
            setTimeout(() => {
                window.location.reload();
            }, 3000);
            
          })
    }
  } catch (error) {
    Swal.fire({
        icon: "error",
        title: "Error",
        text: "Something went wrong!",
        
      });
  }

        // peticion hacia la api
      
      


        // console.log([...datos])
    }
