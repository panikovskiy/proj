<template>
  <section class="section">
    <div class="notification is-primary has-text-centered">
      Вы вышли, чтобы войти, перейдите по ссылке <nuxt-link to="/login">Авторизация</nuxt-link>
    </div>
  </section>
</template>

<script>
  export default {
    mounted () {
      this.$store.dispatch('auth/removeKey')
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
