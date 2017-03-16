<template>
  <section class="section">
    <div class="notification is-success" v-show="message">
      {{ message }}
    </div>  
    <my-form v-show="!message" :fields="fields" title="Регистрация" action="auth/registration" @onSuccess="afterSubmit"/>
  </section>
</template>

<script>
  import MyForm from '~components/Form.vue'
  export default {
    data () {
      return {
        message: '',
        fields: [
          {name: 'name', placeholder: 'Имя пользователя', type: 'text', value: '', icon: 'fa-user'},
          {name: 'username', placeholder: 'Логин', type: 'text', value: '', icon: 'fa-user-o'},
          {name: 'email', placeholder: 'Email', type: 'email', value: '', icon: 'fa-envelope'},
          {name: 'password', placeholder: 'Пароль', type: 'password', value: '', icon: 'fa-lock'},
          {name: 'password_confirmation', placeholder: 'Подтвердите пароль', type: 'password', value: '', icon: 'fa-unlock-alt'}
        ]
      }
    },
    components: {
      MyForm
    },
    methods: {
      afterSubmit () {
        this.message = 'Вам отправлено письмо'
      }
    }
  }
</script>
