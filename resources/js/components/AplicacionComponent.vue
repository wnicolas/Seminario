<template>
  <div>
    <div
      v-if="vista_home"
      class="cover d-flex justify-content-center align-items-center"
    >
      <button class="btn btn-primary" @click="comenzarCompra()">
        ¡Realiza tu compra!
      </button>
    </div>
    <div v-if="vista_seleccionar_funcion" class="cover">
      <div class="container catalogo">
        <div v-for="funcion in funciones" :key="funcion.K_PROYECCION">
          <div class="card my-5 mx-5">
            <div class="card-content">
              <div class="card-header">
                <b> {{ funcion.N_PELICULA }}</b>
              </div>
              <div class="card-body">
                <div class="row">
                  <div
                    class="col col-12 col-md-3 d-flex justify-content-center"
                  >
                    <img
                      :src="funcion.I_PELICULA"
                      alt="Imágen de película"
                      class="img-fluid img-pelicula-catalogo"
                    />
                  </div>
                  <div class="col col-12 col-md-9">
                    <div class="descripcion">
                      {{ funcion.DESC_PELICULA }}
                    </div>
                    <div class="horario">
                      Fecha y hora: <b> {{ funcion.F_PROYECCION }}</b>
                    </div>
                    <div class="valor_boleta">
                      Valor: <b>USD {{ funcion.V_PELICULA }}</b>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <modal-compra-boletas
                  :funcion="funcion"
                  :asientos="asientos"
                  :clientes="clientes"
                  :snacks="snacks"
                ></modal-compra-boletas>
              </div>
            </div>
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
      //Banderas de vistas
      vista_home: false,
      vista_seleccionar_funcion: true,
      //Data
      funciones: [],
      asientos: [],
      clientes: [],
      snacks: [],
    };
  },
  mounted() {
    this.getFunciones();
    this.getClientes();
    this.getSnacks();
  },
  methods: {
    getFunciones() {
      axios.get("ver-funciones").then((response) => {
        this.funciones = response.data.funciones;
        this.asientos = response.data.asientos;
      });
    },
    getClientes() {
      axios.get("cliente").then((response) => {
        this.clientes = response.data;
      });
    },
    getSnacks() {
      axios.get("ver-snacks").then((response) => {
        this.snacks = response.data.snacks;
      });
    },
    comenzarCompra() {
      this.vista_home = !this.vista_home;
      this.vista_seleccionar_funcion = true;
    },
  },
};
</script>
