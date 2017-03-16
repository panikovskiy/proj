<template>
  <section class="section">
    <div class="notification is-success" v-if="message">
      {{ message }}
    </div>
    <div class="notification is-danger" v-if="error">
      {{ error }}
    </div>
  </section>
</template>

<script>
  import '~plugins/axios'
  export default {
    created () {
      this.$axios.post('auth/check', {key: this.$route.query.key, email: this.$route.query.email})
        .then(({ data }) => {
          this.message = data.message
          this.$store.dispatch('auth/setKey', {serverKey: data.server_key, user: data.user})
        })
        .catch((error) => {
          this.error = error.response.data.error
        })
    },
    data () {
      return {
        message: '',
        error: ''
      }
    }
}
</script>
<style>
  .notification a {
    color: #f0f0f0;
  }
  .notification a:hover {
    color: #fff;
  }
</style>
