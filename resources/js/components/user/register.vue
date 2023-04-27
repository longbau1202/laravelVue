<template>
    <body>
        <div class="container">
            <h1>Register</h1>
            <form v-on:submit.prevent="register">
                <input type="text" v-model="name" placeholder="name" />
                <input type="email" v-model="email" placeholder="Email" />
                <input type="password" v-model="password" placeholder="Password" /> 
                <input type="password" v-model="password_confirmation" placeholder="password_confirmation" /> 
                <button type="submit">register</button> 
            </form>
        </div>
    </body>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        },
        
        methods: {
            async register() {
                const postData = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                }
                try {
                    const response = await axios.post('api/auth/register', postData);
                    localStorage.setItem('storedData',JSON.stringify(response.data));
                    if (response.status === 200) {
                        //chuyển hướng về trang index
                        this.$router.push({ path: '/index' })
                    }
                } catch (error) {
                    
                }
            }
        },
    }
</script>

<style lang="css" scoped>
      body {
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
      }
      .container {
        margin: 0 auto;
        max-width: 400px;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #dddfe2;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
      }
      h1 {
        font-size: 28px;
        font-weight: bold;
        margin: 0 0 20px;
        text-align: center;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: none;
        border-bottom: 1px solid #dddfe2;
        font-size: 16px;
      }
      input[type="submit"] {
        background-color: #1877f2;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 20px;
        text-transform: uppercase;
        width: 100%;
      }
      input[type="submit"]:hover {
        background-color: #3b5998;
      }
</style>
