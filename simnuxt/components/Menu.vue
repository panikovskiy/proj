<template>
  <nav class="nav">
    <div class="nav-left">
      <nuxt-link to="/" class="nav-item" active-class="is-active" exact>
        <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma logo">
      </nuxt-link>
      <nuxt-link to="/news" class="nav-item is-tab is-hidden-mobile" active-class="is-active">
        Новости
      </nuxt-link>
      <nuxt-link to="/admin/news" class="nav-item is-tab is-hidden-mobile" active-class="is-active">
        Редактирование новостей
      </nuxt-link>
    </div>

    <span :class="{ 'nav-toggle': true, 'is-active': moblick }" @click="moblick = !moblick">
      <span></span>
      <span></span>
      <span></span>
    </span>

    <div class="nav-right nav-menu">
      <nuxt-link to="/signin" class="nav-item is-tab is-hidden-mobile" active-class="is-active">
        Регистрация
      </nuxt-link>
      <nuxt-link to="/login" class="nav-item is-tab is-hidden-mobile" active-class="is-active">
        Авторизация
      </nuxt-link>
      <nuxt-link to="/admin/profile" class="nav-item is-tab is-hidden-mobile" active-class="is-active">
        Профиль
      </nuxt-link>
    </div>
  </nav>
</template>

<script>
  export default {
    data () {
      return {
        moblick: true
      }
    }
  }
</script>
