<template>
<div class="font-roboto">
  <Header/>
  <transition name="fade">
    <Modal v-if="loginModal" id="login-modal" modal="login"/>
  </transition>
  <transition name="fade">
    <Modal v-if="registerModal" id="login-modal" modal="register"/>
  </transition>
  <Content/>
  <Footer/>
</div>
</template>

<script>
import Modal from '~/components/Modal.vue'

export default {
  components: { Modal },
  data() {
    return {
      loginModal: false,
      registerModal: false
    }
  },
  methods: {
    switchModal(modal) {
      if (modal === 'login') {
        this.loginModal = !this.loginModal
      } else if (modal === 'register') {
        this.registerModal = !this.registerModal
      }
    }
  },
  created() {
    this.$nuxt.$on('switchModal', (e) => {
      this.switchModal(e)
    })
  },
}

</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>