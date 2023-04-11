<template>
    <body>
        <div class="container">
            <h1>Detail</h1>
            <form>
                <input type="text" v-model="userInfo.id">
                <input type="text" v-model="userInfo.name"/>
                <input type="email" v-model="userInfo.email"/>
            </form>
        </div>
    </body>
</template>

<script>
    export default {
        data() {
            return {
                userInfo: {},
            }
        },
        mounted() {
            this.getInfo();
        },
        methods: {
            getInfo() {
                const response = axios.get('api/auth/detail').then(response => {
                    this.userInfo = response.data.data; // Gán dữ liệu người dùng vào biến user
                    console.log(this.userInfo);
                })
                .catch(error => {
                    console.error(error);
                });
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