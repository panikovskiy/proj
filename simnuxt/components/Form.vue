<template>
  <div class="columns">
    <div class="column  is-half is-offset-one-quarter">
      <article class="message is-primary">
        <div class="message-header">
          <p>{{ title }}</p>
        </div>
        <div class="message-body">
          <form method="post" action="/auth" @submit.prevent="onSubmit" @keydown="errorClear($event.target.name)">
            <p :class="{ 'control': true, 'has-icon': field.icon }" v-for="field in fields">
              <input v-if="!['textarea', 'checkbox'].includes(field.type)" :type="field.type" class="input is-medium" :placeholder="field.placeholder" :name="field.name" :value="field.value" @input="field.value = $event.target.value">
              <textarea v-if="field.type == 'textarea'" class="textarea" :placeholder="field.placeholder" :name="field.name" :value="field.value" @input="field.value = $event.target.value"></textarea>
              <label v-if="field.type == 'checkbox'" class="checkbox">
                <input type="checkbox" :name="field.name"
                :checked="field.value"
                @change="field.value = $event.target.checked">
                {{ field.placeholder }}
              </label>
              <span class="icon is-small" v-if="field.icon">
                <i class="fa" :class="field.icon"></i>
              </span>
              <span class="help is-danger" v-if="errors.hasOwnProperty(field.name)" v-text="errorMessage(field.name)"></span>
            </p>

            <p class="control">
              <input type="submit" class="button is-success" :value="button ? button : title" />
              <nuxt-link v-if="cancel" :to="cancel" class="button is-primary cancel">Отмена</nuxt-link>
            </p>
          </form>
        </div>
        <div class="notification is-danger" v-if="errors.error">
          <button class="delete" @click="errors.error = ''"></button>
          {{ errors.error }}
        </div>
      </article>
    </div>
  </div>
</template>
<script>
  import '~plugins/axios'
  export default {
    props: {
      'fields': {type: Array},
      'title': {type: String},
      'button': {type: String},
      'action': {type: String},
      'cancel': {type: String},
      'reset': {type: Boolean, default: true}
    },
    data (asx) {
      return {
        errors: {}
      }
    },
    methods: {
      getData () {
        let result = {}
        for (let idx in this.fields) {
          result[this.fields[idx].name] = this.fields[idx].value
        }
        if (this.$store.state.auth.server_key) {
          result.server_key = this.$store.state.auth.server_key
        }
        return result
      },
      resetData () {
        for (let idx in this.fields) {
          this.fields[idx].value = ''
        }
      },
      onSubmit () {
        this.$axios.post(this.action, this.getData())
          .then(response => {
            this.onSuccess(response.data)
          })
          .catch((error) => {
            this.onFail(error.response.data)
          })
      },
      onSuccess (data) {
        this.errors = {}
        if (this.reset) this.resetData()
        this.$emit('onSuccess', data)
      },
      onFail (errors) {
        this.errors = errors
      },
      errorMessage (field) {
        if (this.errors[field]) {
          return this.errors[field][0]
        }
      },
      errorClear (field) {
        if (field) {
          delete this.errors[field]
        }
      }
    }
  }
</script>

<style>
.button.cancel {
  text-decoration: none;
  margin-left: 13px;
}
input::placeholder, textarea::placeholder {
  color: #b7b7b7;
}
</style>
