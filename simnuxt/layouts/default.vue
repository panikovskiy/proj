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
import '~plugins/axios'
export default {
  components: {
    MyMenu,
    MyFooter
  },
  created () {
    this.$store.dispatch('auth/initKey')
    let key = this.$store.state.auth.server_key
    if (typeof key !== 'undefined' && key) {
      this.$axios.get('auth/auth?server_key=' + key)
        .then(({ data }) => {
          this.$store.dispatch('auth/setAuthUser', data)
        })
    }
  }
}
</script>

<style>
  footer {
    margin-top: 33px;
  }
</style>
