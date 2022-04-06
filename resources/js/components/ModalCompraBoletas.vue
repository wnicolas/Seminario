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
            <div class="container">
              <div class="pantalla">Pantalla</div>
              <div class="row justify-content-center">
                <div
                  class="col col-4 d-flex justify-content-center"
                  v-for="silla in sillas"
                  :key="silla.K_ASIENTO"
                >
                  <button class="btn">Silla</button>
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
    };
  },
  props: {
    funcion: Object,
    asientos: [],
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
  },
};
</script>
