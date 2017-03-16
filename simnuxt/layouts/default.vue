<template>
  <div class="container is-fluid">
    <div class="container">
      <my-menu/>
      <nuxt/>
    </div>
    <my-footer/>
  </div>
</template>

<script>
import MyMenu from '~components/Menu.vue'
import MyFooter from '~components/Footer.vue'

export default {
  components: {
    MyMenu,
    MyFooter
  },
  created () {
    this.$store.dispatch('initKey')
  }
}
</script>

<style>
  footer {
    margin-top: 33px;
  }
</style>
