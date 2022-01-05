<template>
  <div>
    <span class="like-btn" @click="likeReceta" :class="{ 'like-active' : isActive }"></span>
    <p>{{ cantidadLikes }} Les gustó esta receta</p>
  </div>
  <!-- <p>{{ cantidadLikes }} Les gustó esta receta</p>// { 'like-active' : this.like }-->
</template>

<script>
  export default {
    props: ['recetaId', 'like', 'likes'],
    // mounted(){
    //   console.log(this.like);
    // },
    data: function() {
      return{
        isActive: this.like,
        totalLikes: this.likes
      }
    },
    methods: {
      likeReceta(){
        // console.log('Diste me gusta:', this.recetaId);
        axios.post('/recetas/' + this.recetaId)
          .then(respuesta =>{
            // console.log(respuesta)
            if (respuesta.data.attached.length > 0) {
              this.$data.totalLikes++;
            }else{
              this.$data.totalLikes--;
            }
            this.isActive = !this.isActive;
          })
          .catch(error => {
            // console.log(error)
            if (error.response.status === 401) {
              window.location = '/register';
            }
          });
      }
    },
    computed: {
      cantidadLikes: function() {
        // return this.likes;
        return this.totalLikes
      }
    }
  }
</script>