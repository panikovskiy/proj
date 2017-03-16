<template>
  <section class="section">
    <div class="notification is-danger" v-show="error">
      <nuxt-link to="/login?back=admin/profile" class="delete"></nuxt-link>
      {{ error }}
    </div>
    <div v-show="!error">
      <my-form :fields="fields" title="Профиль" button="Сохранить" action="user/profile" cancel="/" @onSuccess="afterSubmit" :reset="false"/>
    </div>
  </section>
</template>

<script>
  import MyForm from '~components/Form.vue'
  import '~plugins/axios'
  export default {
    data () {
      return {
        error: '',
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
    mounted () {
      let skey = this.$store.state.auth.server_key ? '?server_key=' + this.$store.state.auth.server_key : ''
      this.$axios.get('user/profile' + skey)
        .then(({data}) => {
          for (let key in data) {
            let fl = this.fields.length
            for (let i = 0; i < fl; ++i) {
              if (this.fields[i].name === key) {
                this.fields[i].value = data[key]
                break
              }
            }
          }
        })
        .catch(error => {
          this.error = error.response.data.error
        })
    },
    methods: {
      afterSubmit (data) {
        console.log(data)
      }
    }
  }
</script>
