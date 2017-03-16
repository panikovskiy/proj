<template>
  <section class="section">
    <my-form :fields="fields" title="Авторизация" action="auth/auth" @onSuccess="afterSubmit"/>
  </section>
</template>

<script>
  import MyForm from '~components/Form.vue'
  export default {
    data (ctx) {
      return {
        back: ctx.query.back ? ctx.query.back : '',
        fields: [
          {name: 'username', placeholder: 'Логин', type: 'text', value: '', icon: 'fa-user-o'},
          {name: 'password', placeholder: 'Пароль', type: 'password', value: '', icon: 'fa-lock'}
        ]
      }
    },
    components: {
      MyForm
    },
    methods: {
      afterSubmit (data) {
        this.$store.dispatch('auth/setKey', {serverKey: data.server_key, user: data.user})
        this.$router.push('/' + this.back)
      }
    }
  }
</script>
