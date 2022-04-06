<template>
  <div>
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-primary"
      data-bs-toggle="modal"
      :data-bs-target="'#' + funcion.K_PELICULA + funcion.K_PROYECCION"
    >
      ¡Compra tus boletas ahora!
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      :id="funcion.K_PELICULA + funcion.K_PROYECCION"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Compra boletas para <b>{{ funcion.N_PELICULA }}</b> ({{
                funcion.F_PROYECCION
              }})
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div v-if="!usuario_valido" class="container">
              <div class="row my-3">
                <div class="col d-flex justify-content-center">
                  <label>
                    Ingresa tu ID:
                    <input
                      type="text"
                      class="form-control"
                      placeholder="ID de usuario"
                      v-model="usuario.K_CLIENTE"
                    />
                  </label>
                </div>
                <div class="col d-flex align-items-end justify-content-center">
                  <button class="btn btn-warning" @click="validarUsuario()">
                    Siguiente
                  </button>
                </div>
              </div>
            </div>
            <div v-if="crear_nuevo_usuario">
              <div class="alert alert-warning my-2">
                El usuario no existe, debes crear uno antes de continuar.
              </div>
              <div class="row">
                <div class="col">
                  <input
                    type="text"
                    placeholder="Nombre(s)"
                    class="form-control"
                    v-model="usuario.N1_CLIENTE"
                  />
                </div>
                <div class="col">
                  <input
                    type="text"
                    placeholder="Apellido(s)"
                    class="form-control"
                    v-model="usuario.A1_CLIENTE"
                  />
                </div>
                <div class="col">
                  <input
                    type="text"
                    placeholder="Email"
                    class="form-control"
                    v-model="usuario.E_CLIENTE"
                  />
                </div>
              </div>
              <div class="row my-2">
                <div class="col">
                  <button class="btn btn-success" @click="guardarUsuario()">
                    Guardar
                  </button>
                </div>
              </div>
            </div>
            <div v-if="usuario_valido" class="container">
              <div class="row">
                <div class="col d-flex justify-content-center">
                  <button class="btn btn-outline-success">Silla</button>
                  Disponible
                </div>
                <div class="col d-flex justify-content-center">
                  <button class="btn btn-primary" disabled>Silla</button>
                  Reservado
                </div>
                <div class="col d-flex justify-content-center">
                  <button class="btn btn-danger" disabled>Silla</button> Ocupado
                </div>
              </div>

              <div class="pantalla my-3">Pantalla</div>
              <div class="row justify-content-center">
                <div
                  class="col col-4 d-flex justify-content-center"
                  v-for="silla in sillas"
                  :key="silla.K_ASIENTO"
                >
                  <button
                    :disabled="silla.ESTADO == 'D' ? false : true"
                    :class="[
                      silla.ESTADO == 'D'
                        ? 'btn my-2 btn-outline-success'
                        : silla.ESTADO == 'R'
                        ? 'btn my-2 btn-primary'
                        : 'btn my-2 btn-danger',
                    ]"
                  >
                    Silla
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sillas: [],
      usuario: {
        K_CLIENTE: "",
        A1_CLIENTE: "",
        N1_CLIENTE: "",
        E_CLIENTE: "",
      },
      usuario_valido: false,
      crear_nuevo_usuario: false,
    };
  },
  props: {
    funcion: Object,
    asientos: [],
    clientes: [],
  },
  mounted() {
    this.filtrarAsientos();
  },
  methods: {
    filtrarAsientos() {
      this.sillas = this.asientos.filter((asiento) => {
        return asiento.K_PROYECCION === this.funcion.K_PROYECCION;
      });
    },
    validarUsuario() {
      var usuario = this.clientes.find(
        (cliente) => cliente.K_CLIENTE == this.usuario.K_CLIENTE
      );
      if (usuario) {
        this.usuario = usuario;
        this.usuario_valido = true;
        this.crear_nuevo_usuario = false;
      } else {
        this.crear_nuevo_usuario = true;
      }
    },
    guardarUsuario() {
      var formData = new FormData();

      for (const key in this.usuario) {
        formData.append(key, this.usuario[key]);
      }

      axios.post("cliente", formData).then((response) => {
        if (response.data.respuesta == "exitoso") {
          alert("Usuario creado satisfactoriamente.");
          this.usuario_valido = true;
          this.crear_nuevo_usuario = false;
        } else {
          alert("No se pudo crear el usuario.");
          console.log(response.data.respuesta);
        }
      });
    },
  },
};
</script>
