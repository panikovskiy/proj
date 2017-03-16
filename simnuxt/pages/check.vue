<template>
  <div>

    <div class="notification is-success" v-if="message">
      {{ message }}. Перейти к <nuxt-link to="/login" class="is-link is-success is-paddingless">авторизации</nuxt-link>
    </div>

    <div class="notification is-danger" v-if="error">
      {{ error }}
    </div>

  </div>
</template>

<script>
  import axios from '~plugins/axios'
  export default {
    created () {
      axios.post('auth/check', {key: this.$route.query.key, email: this.$route.query.email})
        .then(response => {
          this.message = response.data.message
          this.$store.dispatch('setKey', {serverKey: response.data.server_key})
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
