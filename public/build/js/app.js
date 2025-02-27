let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),idCliente(),nombreCliente(),seleccionaFecha(),seleccionarHora(),mostrarResumen()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");const t=`#paso_${paso}`;document.querySelector(t).classList.add("mostrar");const o=document.querySelector(".actual");o&&o.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){const e=document.querySelectorAll(".tabs button");e.forEach((e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})),console.log(e)}function botonesPaginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach((e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre_servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio_servicio"),c.textContent=a;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)}))}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio="${t}"]`);o.some((e=>e.id===t))?(cita.servicios=o.filter((e=>e.id!==t)),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado"))}function idCliente(){cita.id=document.querySelector("#id").value}function nombreCliente(){cita.nombre=document.querySelector("#nombre").value}function seleccionaFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Fines de semana no permitimos","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":");t[0]>18||t[0]<9?(e.target.value="",mostrarAlerta("Horario valido solo entre 9 y 18 hrs","error",".formulario")):cita.hora=e.target.value}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),a&&setTimeout((()=>{c.remove()}),3e3)}function mostrarResumen(){const e=document.querySelector(".contenido_resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Debes elegir por lo menos un servicio, fecha u hora","error",".contenido_resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Resumen de Servicios",e.appendChild(c),n.forEach((t=>{const{id:o,nombre:a,precio:n}=t,c=document.createElement("DIV");c.classList.add("contenedor_servicio");const r=document.createElement("P");r.textContent=a;const i=document.createElement("P");i.innerHTML=`<span>Precio:</span> $${n}`,c.appendChild(r),c.appendChild(i),e.appendChild(c)}));const r=document.createElement("H3");r.textContent="Resumen de Cita",e.appendChild(r);const i=document.createElement("P");i.innerHTML=`<span>Nombre:</span> ${t}`;const s=new Date(o),d=s.getMonth(),l=s.getDate()+2,u=s.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-CO",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML=`<span>Fecha:</span> ${m}`;const h=document.createElement("P");h.innerHTML=`<span>Hora:</span> ${a} hrs`;const v=document.createElement("BUTTON");v.classList.add("boton"),v.textContent="Reservar Cita",v.onclick=reservarCita,e.appendChild(i),e.appendChild(p),e.appendChild(h),e.appendChild(v)}async function reservarCita(){const{fecha:e,hora:t,servicios:o,id:a}=cita,n=o.map((e=>e.id)),c=new FormData;c.append("fecha",e),c.append("hora",t),c.append("usuarioid",a),c.append("servicios",n);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:c});(await t.json()).resultado&&alerta("success","Cita Creada","Tu cita fue creada con exito")}catch(e){console.log(e),alerta("error","Error..","Se ha generado un error al crear tu cita")}}function alerta(e,t,o){Swal.fire({icon:e,title:t,text:o,button:"OK"}).then((()=>{window.location.reload()}))}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));