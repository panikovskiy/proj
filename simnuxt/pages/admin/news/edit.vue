<template>
  <section class="section">
    <my-form :fields="fields" :title="title" button="Сохранить" :action="action" cancel="/admin/news" @onSuccess="afterSubmit"/>
  </section>
</template>

<script>
  import MyForm from '~components/Form.vue'
  import '~plugins/axios'
  export default {
    data (context) {
      return {
        fields: [
          {name: 'title', placeholder: 'Заголовок', type: 'text', value: ''},
          {name: 'image', placeholder: 'Картинка', type: 'text', value: ''},
          {name: 'content', placeholder: 'Контент', type: 'textarea', value: ''},
          {name: 'keywords', placeholder: 'Теги', type: 'text', value: ''},
          {name: 'public', placeholder: 'Опубликовать', type: 'checkbox', value: ''}
        ],
        action: 'news',
        title: 'Новая новость',
        newsId: context.query.id
      }
    },
    mounted () {
      if (typeof this.newsId !== 'undefined' && this.newsId) {
        this.title = 'Редактировать новость'
        this.action = 'news/' + this.newsId
        this.fields.push({name: 'id', placeholder: '', type: 'hidden', value: ''})
        this.$axios.get('news/' + this.newsId)
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
