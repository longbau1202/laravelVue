<template>
    <body>
        <!-- <login v-if="!isLogin" @myEvent="handleMyEvent"></login> -->
        <div class="sidebar">
            <ul>
                <li v-if="!isLogin"><a href="#" @click="login">login</a></li>
                <li v-if="isLogin"><a href="#" @click="logout">logout</a></li>
                <li v-if="isLogin"><a href="#" @click="detail">detail user</a></li>
                <li v-if="!isLogin"><a href="#" v-on:click="register">register</a></li>
                <li v-if="isLogin"><a href="#" v-on:click="addProduct">Product add</a></li>
                <li v-if="isLogin"><a href="#" v-on:click="listProduct">Product list</a></li>
                <li v-if="isLogin"><a href="#" v-on:click="addCategory">Category add</a></li>
                <li v-if="isLogin"><a href="#" v-on:click="listCategory">Category list</a></li>
            </ul>
        </div>
        <div class="content">
            <RouterView></RouterView>
        </div>
    </body>
</template>

<script>
    export default {
        data() {
            return {
                isLogin: false,
            }
        },

        mounted() {
            this.checkAuth();
        },

        methods: {
            checkAuth () {
                const isLoggerIn = localStorage.getItem('storedData');
                if (isLoggerIn) {
                    this.isLogin = true
                }
            },

            handleCheckLogin (data) {
                this.isLogin = data;
            },
            
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
                        this.isLogin = false
                        this.$router.push({ path: '/login'})
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
            },

            addCategory () {
                this.$router.push({ path: '/category/add'})
            },

            listCategory () {
                this.$router.push({ path: '/category/list'})
            },  
        },
    }
</script>

<style lang="css" scoped>

body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

.sidebar {
  background-color: #333;
  color: #fff;
  width: 200px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  padding-top: 20px;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  padding: 10px;
}

.sidebar a {
  color: #fff;
  text-decoration: none;
}

.sidebar a:hover {
  color: #00bcd4;
}

.content {
  margin-left: 200px;
  padding: 20px;
}
</style>
