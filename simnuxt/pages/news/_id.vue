<template>
  <section class="section">
    <div class="tile is-ancestor">
      <div class="tile is-vertical is-3">
        <div class="tile">
          <div class="tile is-parent is-vertical">
            <article class="tile is-child notification is-white">
              <figure class="image is-4by3">
                <img :src="news.image" alt="Image">
              </figure>
            </article>
          </div>
        </div>
      </div>
      <div class="tile is-parent">
        <article class="tile is-child notification is-white">
          <div class="content">
            <p class="title">{{ news.title }}</p>
            <p>
              <a v-for="key in news.keywords">
                <span class="tag is-primary">{{ key }}</span>
              </a>
            </p>
            <div class="content" v-html="news.content"></div>
          </div>
        </article>
      </div>
    </div>
  </section>
</template>

<script>
  import axios from '~plugins/axios'
  export default {
    data (context) {
      return {
        id: context.params.id,
        news: {}
      }
    },
    mounted () {
      axios.get('/news/' + this.id + '?edit=1')
        .then(({data}) => {
          this.news = data
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
</script>
