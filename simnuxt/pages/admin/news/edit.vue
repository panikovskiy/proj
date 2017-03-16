<template>
  <section class="section">
    <my-form :fields="fields" :title="title" button="Сохранить" :action="action" cancel="/admin/news" @onSuccess="afterSubmit"/>
  </section>
</template>

<script>
  import MyForm from '~components/Form.vue'
  import axios from '~plugins/axios'
  export default {
    data (context) {
      let action = 'news'
      let fields = [
        {name: 'title', placeholder: 'Заголовок', type: 'text', value: ''},
        {name: 'image', placeholder: 'Картинка', type: 'text', value: ''},
        {name: 'content', placeholder: 'Контент', type: 'textarea', value: ''},
        {name: 'keywords', placeholder: 'Теги', type: 'text', value: ''},
        {name: 'public', placeholder: 'Опубликовать', type: 'checkbox', value: ''}
      ]
      let title = 'Новая новость'
      if (typeof context.query.id !== 'undefined' && context.query.id) {
        title = 'Редактировать новость'
        action = 'news/' + context.query.id
        fields.push({name: 'id', placeholder: '', type: 'hidden', value: ''})
        return axios.get('news/' + context.query.id)
          .then(({data}) => {
            for (let key in data) {
              let fl = fields.length
              for (let i = 0; i < fl; ++i) {
                if (fields[i].name === key) {
                  fields[i].value = data[key]
                  break
                }
              }
            }
            return {
              fields: fields,
              title: title,
              action: action
            }
          })
      } else {
        return {
          fields,
          title: title,
          action: action
        }
      }
    },
    components: {
      MyForm
    },
    methods: {
      afterSubmit (data) {
        this.$router.push('/admin/news')
      }
    }
  }
</script>
