<template>

<div class="fixed h-screen w-full bg-black bg-opacity-30">
    <div class="relative bg-white border-2 border-blue-400 w-2/6 h-auto mx-auto mt-56 p-4 rounded-lg">
        <!-- Cross icon on the right -->
        <div class="absolute top-4 right-4">
            <button @click="switchModal(MODAL)" class="text-2xl text-blue-500 hover:text-blue-700">
                <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
            </button>
        </div>
        <div v-if="MODAL == 'login'" class="w-full flex flex-col items-center">
            <div class="my-4 w-full text-center"><h2 class="text-2xl">Se connecter</h2>
            <h1 v-if="error" class="text-red-500 text-center">Erreur : {{ error }}</h1> 
            </div>
            <form class="flex flex-col w-3/5" @submit.prevent="login">
                <label class="my-2">
                    <input type="text" v-model="username" placeholder="Nom d'utilisateur" class="h-10 px-2 w-full rounded-sm  focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-indigo-700 dark:focus:border-indigo-700 dark:border-gray-700 dark:bg-gray-800 ">
                </label>
                <label class="my-2">
                    <input type="password" v-model="password" placeholder="Mot de passe" class="h-10 px-2 w-full rounded-sm  focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-indigo-700 dark:focus:border-indigo-700 dark:border-gray-700 dark:bg-gray-800 ">
                </label>
                <button type="submit" class="bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 text-white px-8 py-3 my-2 text-sm focus:outline-none focus:ring-2   focus:ring-indigo-600 rounded border shadow">Login</button>
            </form>
        </div>
        <div v-else class="w-full flex flex-col items-center">
            <div class="my-4 w-full text-center"><h2 class="text-2xl">S'inscrire</h2>
            <h1 v-if="error" class="text-red-500 text-center">Erreur : {{ error }}</h1> 
            </div>
            <form class="flex flex-col w-3/5" @submit.prevent="submit">
                <label class="my-2">
                    <input type="text" v-model="username" placeholder="Nom d'utilisateur" class="h-10 px-2 w-full rounded-sm  focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-indigo-700 dark:focus:border-indigo-700 dark:border-gray-700 dark:bg-gray-800 ">
                </label>
                <label class="my-2">
                    <input type="password" v-model="password" placeholder="Mot de passe" class="h-10 px-2 w-full rounded-sm  focus:outline-none hover:bg-gray-100 focus:ring-2 focus:ring-indigo-700 dark:focus:border-indigo-700 dark:border-gray-700 dark:bg-gray-800 ">
                </label>
                <button type="submit" class="bg-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 text-white px-8 py-3 my-2 text-sm focus:outline-none focus:ring-2   focus:ring-indigo-600 rounded border shadow">Sign in</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['modal'],
    data() {
        return {
            MODAL: this.modal,
            password: '',
            username: '',
            error: ''
        }
    },
    methods: {
        switchModal(m) {
                $nuxt.$emit('switchModal', m);
        },
        onClickAway(event) {
            this.switchModal('login')
        },
        login() {
            if(this.password.length < 6 || this.username.length < 3) {
                this.error = 'Champs invalides'
                return
            }

            this.$axios.$post('http://' + window.location.hostname + ':3000/api/accounts/login.php', {
                username: this.username,
                password: this.password
            }, {
                 headers : {
                    'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'
                }
            }).then(response => {
                if (response.status) {
                    this.switchModal('login')
                    $nuxt.$emit('login', response.user);
                } else {
                    this.error = response.message
                }
            })
        },
        submit() {
            if(this.password.length < 6 || this.username.length < 3) {
                this.error = 'Champs invalides'
                return
            }

            this.$axios.$post('http://' + window.location.hostname + ':3000/api/accounts/register.php', {
                username: this.username,
                password: this.password
            },
            ).then(response => {
                if (response.status) {
                    this.switchModal('register')
                    $nuxt.$emit('login', this.username);
                } else {
                    this.error = response.message
                }
            })
        },

    }
}
</script>

<style>

</style>
