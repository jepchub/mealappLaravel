<template>
  <span>{{ formatearFecha }}</span>
  <!-- <span v-text="formatearFecha" ></span> -->
</template>

<script>
  export default {
    props: ['fecha'],
    // cuando el componente esta listo y se puede ver
    // mounted() {
    //   console.log('la fecha es ', this.fecha);
    // },
    // aqui se puede escribir la logica se, si un valor cambia en el computed se puede pasar una dependencia, y cunado el valor cambie compued va estar reaccionando a los cambios en el codigo
    computed: {
      formatearFecha() {
        return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY')
      }
    }
  }
</script>