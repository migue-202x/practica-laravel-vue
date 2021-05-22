<template>
    <div>
        <!-- Editar -->
        <form @submit.prevent="" class="my-3" v-if="modoEditar">
            <h3>EditarTarea</h3>
            <input type="text" placeholder="nombre" class="form-control mb-2" v-model="nota.nombre">
            <input type="text" placeholder="descripcion" class="form-control mb-2" v-model="nota.descripcion">
            <button class="btn btn-primary" type="submit" @click="editarTarea(nota)">Editar</button>
            <button class="btn btn-secondary" type="submit" @click="cancelarEdicion()">Cancelar</button>
        </form>
        <!-- crear -->
        <form @submit.prevent="agregar" v-else>
            <h3>Agregar tareas</h3>
            <input type="text" placeholder="nombre" class="form-control mb-2" v-model="nota.nombre">
            <input type="text" placeholder="descripcion" class="form-control mb-2" v-model="nota.descripcion">
            <button class="btn btn-primary" type="submit">Agregar tarea</button>
        </form>

        <!-- Pintamos en nustra vista las notas -->
        <hr class="mt-3">
        <h3>Listado de notas</h3>
        <ul class="list-group my-2">
            <li class="list-group-item" v-for="(nota, index) in notas" :key="index">
                 <span class="badge badge-primary float-right">
                    {{nota.updated_at}}
                </span>
                <p>{{ nota.nombre }}</p>
                <p>{{ nota.descripcion }}</p>
                <button class="btn btn-danger btn-sm" @click="eliminar(nota, index)">Eliminar</button>
                <button class="btn btn-warning btn-sm" @click="Abrireditar(nota, index)">Editar</button>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data(){
        return{
            notas: [], //en este array guardo los archivos temporales que se van guardando en nuestra bbdd
            nota: {nombre: '', descripcion:''}, //tarea.nombre
            modoEditar: false,
            index: null
        }
    },
    created(){ //Se ejecuta antes que se pinte toda nuestra vista
    //con el metodo INDEX desde el controlador se nos esta devolviendo todas las notas correspondiente al usuario
        axios.get('/notas')
            .then(res=>{
                this.notas = res.data;
            }),
        this.modoEditar = false
    },
    methods:{
        //vamos a enviar la informacion con axios. Axios sirve para enviar solicitudes http
        agregar(){
            if(this.nota.nombre.trim() === '' || this.nota.descripcion.trim() === ''){
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                nombre: this.nota.nombre,
                descripcion: this.nota.descripcion
            }
            this.nota.nombre = '';
            this.nota.descripcion = '';

            axios.post('/notas', params) //aca ya se guardo en la base de datos
                .then(res => { //.then porque es una promesa. Ahora podemos leer la respuesta que nos trae el controlador
                    this.notas.push(res.data) //empujamos la respuesta a nuestro array para visualizarlo en nustro sitio web
                })
        },
        eliminar(nota, index){
            axios.delete(`/notas/${nota.id}`)
                .then(()=> {
                    this.notas.splice(index, 1); //splice recibe el index a eliminar y la cantidad a eliminar
                })
        },
        Abrireditar(nota, index){
            this.modoEditar = true //muestro el formulario
            this.nota.nombre = nota.nombre
            this.nota.descripcion = nota.descripcion
            this.nota.id = nota.id
        },
        editarTarea(nota){
            const params = {nombre:nota.nombre, descripcion: nota.descripcion}
            axios.put(`/notas/${nota.id}`, params)
             .then(res=>{
                 this.modoEditar = false
                 this.nota = {nombre: '', descripcion:''}
                 //const index = this.notas.findIndex(item => item.id === nota.id);
                 const index = this.notas.findIndex(item => item.id === res.data.id); //item toma el valor de una posicion del array
                 this.notas[index] = res.data
             })
        },
        cancelarEdicion(){
            this.modoEditar = false,
            this.nota = {nombre: '', descripcion:''}
        }
    }
}
</script>
