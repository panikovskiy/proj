<template>
 <section class="section">
    <nav class="pagination inline-block">
      <nuxt-link :to="getUrl(prevPageUrl)" class="pagination-previous is-marginless">Previous</nuxt-link>
      <nuxt-link :to="getUrl(nextPageUrl)" class="pagination-next">Next</nuxt-link>
    </nav>
    <div class="columns is-multiline">
      <div class="column is-4" v-for="nw in newsList">
        <div class="card">
          <div class="card-image" v-if="nw.image">
            <nuxt-link :to="'/news/' + nw.id">
              <figure class="image is-3by2">
                <img :src="nw.image" alt="news">
              </figure>
            </nuxt-link>
          </div>
          <div class="card-content">
            <nuxt-link :to="'/news/' + nw.id" class="title is-4">
              <h1>{{ nw.title }}</h1>
            </nuxt-link>
            <div class="content">
              {{ nw.content }}
              <div class="keys">
                <a v-for="key in nw.keywords">&nbsp;#{{ key }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import axios from '~plugins/axios'
  export default {
    data () {
      return {
        newsList: [],
        nextPageUrl: '',
        prevPageUrl: ''
      }
    },
    beforeRouteUpdate (to, from, next) {
      this.updateNews(to.query.page)
      next()
    },
    created () {
      this.updateNews(this.$route.query.page)
    },
    methods: {
      getUrl (page) {
        return '/news?' + page
      },
      updateNews (page) {
        let strpage = page ? '?page=' + page : ''
        axios.get('/news' + strpage)
          .then(({data}) => {
            this.newsList = data.data
            this.nextPageUrl = data.next_page_url ? data.next_page_url.match('(page=)(\\d+)')[0] : ''
            this.prevPageUrl = data.prev_page_url ? data.prev_page_url.match('(page=)(\\d+)')[0] : ''
          })
          .catch((error) => {
            console.log(error)
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
  a.title {
    display: block;
  }
  a.title h1 {
    color: #333;
  }
  a.title:hover h1 {
    color: #111;
  }
  .keys a {
    display: inline-block;
  }
</style>
