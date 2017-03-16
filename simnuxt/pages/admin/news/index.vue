<template>
 <section class="section">
    <div class="notification is-danger" v-if="error">
      <nuxt-link to="/login?back=admin/news" class="delete"></nuxt-link>
      {{ error }}
    </div>
    <div v-if="!error">
      <div class="block has-text-right">
          <span class="is-pulled-left">
            <nuxt-link :to="getUrl(prevPageUrl)" class="pagination-previous is-marginless">Previous</nuxt-link>
            <nuxt-link :to="getUrl(nextPageUrl)" class="pagination-next">Next</nuxt-link>
          </span>
          <nuxt-link to="/admin/news/edit" class="button is-info">Добавить новость</nuxt-link>
      </div>
      <table class="table is-bordered">
        <thead>
          <tr>
            <th>Картинка</th>
            <th>Заголовок</th>
            <th>Содержание</th>
            <th>Ключевые слова</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="nw in newsList">
            <td>
              <img :src="nw.image" v-show="nw.image">
            </td>
            <td>{{ nw.title }}</td>
            <td>{{ nw.content }}</td>
            <td class="tags">
              <span class="tag is-light" v-for="tag in nw.keywords">
              {{ tag }}
              </span>
            </td>
            <td class="buttons has-text-centered">
              <nuxt-link :to="'/admin/news/edit?id=' + nw.id">
                <span class="icon blue" title="Редактировать">
                  <i class="fa fa-pencil"></i>
                </span>
              </nuxt-link>
              <span class="icon red" @click="deleteNews(nw.id)" title="Удалить">
                <i class="fa fa-times"></i>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
  import '~plugins/axios'
  export default {
    data () {
      return {
        newsList: [],
        nextPageUrl: '',
        prevPageUrl: '',
        error: ''
      }
    },
    beforeRouteUpdate (to, from, next) {
      this.uploadNews(to.query.page)
      next()
    },
    created () {
      this.uploadNews(this.$route.query.page)
    },
    methods: {
      removeFromList (id) {
        let len = this.newsList.length
        for (let i = 0; i < len; i++) {
          if (parseInt(this.newsList[i].id) === parseInt(id)) {
            this.newsList.splice(i, 1)
            break
          }
        }
      },
      deleteNews (id) {
        if (id && confirm('Удалить новость?')) {
          this.$axios.delete('/news/' + id, {data: {server_key: this.$store.state.auth.server_key}})
          .then(({data}) => {
            if (data.removed) {
              this.removeFromList(data.removed)
            }
          })
          .catch(error => {
            this.error = error.response.data.error
          })
        }
      },
      getUrl (page) {
        return '/admin/news?' + page
      },
      uploadNews (page) {
        let strpage = page ? '&page=' + page : ''
        this.$axios.get('/adminnews?server_key=' + this.$store.state.auth.server_key + strpage)
          .then(({data}) => {
            this.newsList = data.data
            this.nextPageUrl = data.next_page_url ? data.next_page_url.match('(page=)(\\d+)')[0] : ''
            this.prevPageUrl = data.prev_page_url ? data.prev_page_url.match('(page=)(\\d+)')[0] : ''
          })
          .catch(error => {
            this.error = error.response.data.error
          })
      }
    }
  }
</script>

<style scoped>
.pagination {
  display: block;
  margin-bottom: 33px;
  text-align: left;
}
.pagination-next {
  margin-left: 13px;
}
tbody tr td {
  vertical-align: middle;
}
.buttons {
  width: 90px;
}
.buttons span {
  margin-left: 9px;
}
.icon {
  cursor: pointer;
  opacity: 0.8;
}
.icon:hover {
  opacity: 1;
}
.icon.blue {
  color: #3273dc;
}
.icon.red {
  color: #ff5511;
}
</style>
