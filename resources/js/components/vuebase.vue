<template>
    <div>
        <button type="button" @click="detail">detail</button>
        <input type="button" @click="login" value="login"> 
        <input type="button" @click="logout" value="logout">
        <button type="button" v-on:click="register">register</button>
        <button type="button" v-on:click="addProduct">add product</button>
        <button type="button" v-on:click="listProduct">list product</button>
    </div>
    <div>
        <RouterView></RouterView>
    </div>
</template>

<script>
    export default {
        methods: {
            async detail(){
                this.$router.push({ path: '/detail' })
            },

            login () {
                this.$router.push({ path: '/login'})
            },

            async logout () {
                const isLoggerIn = localStorage.getItem('storedData');
                if(isLoggerIn) {
                    const response = await axios.post('/api/auth/logout');
                    if(response.data){
                        localStorage.removeItem('storedData');
                    }
                } else {
                    this.$router.push({ path: '/login'})
                }
            },

            register () {
                this.$router.push({ path: 'register'})
            },

            addProduct () {
                this.$router.push({ path: '/product/add'})
            },

            listProduct () {
                this.$router.push({ path: '/product/list'})
            }
        },
    }
</script>
