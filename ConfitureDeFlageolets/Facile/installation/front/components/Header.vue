<template>
  <header class="flex flex-row absolute w-full h-16 bg-blue-500 py-2 text-white font-bold">
    <div class="flex flex-row align-center items-center">
    <p class="ml-2 text-4xl">
        STDoctoLib
    </p>
    </div>
    <div class="flex flex-row-reverse w-full text-white font-bold">
        <button v-if="!isLogged"
        @click="switchModal('login')"
        class="bg-blue-500 hover:bg-blue-400 text-white font-bold  px-4 mx-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        Se connecter
        </button>
        <button v-else
        @click="logout()"
        class="bg-blue-500 hover:bg-blue-400 text-white font-bold  px-4 mx-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        {{username}} - Se déconnecter
        </button>
        <button v-if="!isLogged"
        @click="switchModal('register')"
         class="bg-blue-500 hover:bg-blue-400 text-white font-bold px-4 mx-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        S'inscrire
        </button>
        <button 
        @click="help()"
        class="bg-white text-blue-500 hover:text-blue-600 font-bold px-4 mx-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
        Besoin d'aide ?
        </button>
    </div>

</header>
</template>

<script>
//click event on login button emmiting event to switch modal
export default {
    data() {
        return {
            modal: 'login',
            isLogged: false,
            username: ''
        }
    },
    methods: {
        switchModal(m) {
            $nuxt.$emit('switchModal', m);
        },
        //Methods to change route for help page
        help() {
            this.$router.push('/help');
        },
        logout() {
            this.isLogged = false;

            this.$axios.$post('http://' + window.location.hostname + ':3000/api/accounts/logout.php', {}, {
                 headers : {
                    'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'
                }
            })
        }
    },
    created() {
        this.$nuxt.$on('login', (name) => {
        this.isLogged = true
        this.username = name
        })
  },
}

</script>

<style>

</style>
