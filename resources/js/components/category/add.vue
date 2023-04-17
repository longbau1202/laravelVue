<template>
    <div>
    <body>
        <h1>Thêm Thương hiệu</h1>
        <form v-on:submit.prevent="addCategory">
            <label for="category_name">Thương hiệu:</label>
            <input type="text" id="category_name" v-model="category_name" required>
            <span class="error" v-if="errors.category_name">{{ errors.category_name[0] }}</span>
            <br>
            <br>
            <label for="category_code">Code:</label>
            <input type="text" id="category_code" v-model="category_code" required>
            <span class="error" v-if="errors.category_code">{{ errors.category_code[0] }}</span>
            <br>
            <br>
            <label for="category_description">Mô tả:</label>
            <textarea id="category_description" v-model="category_description" required></textarea>
            <span class="error" v-if="errors.category_description">{{ errors.category_description[0] }}</span>
            <br>
            <br>
            <input type="submit"  value="Thêm thương hiệu">
        </form>
    </body>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                category_name: '',
                category_code: '',
                category_description: '',
                errors: {}
            }
        },

        methods: {
            async addCategory() {
                const postData = {
                    category_name: this.category_name,
                    category_code: this.category_code,
                    category_description: this.category_description,
                }
                try {
                    const response = await axios.post('/api/category/add', postData);
                    if (response.data) {
                        const check = confirm(response.data.message);
                        if (check) {
                            this.$router.push('/index');
                        }
                    }
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                }
            }

        }
    }
</script>
<style lang="css" scoped>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

h1 {
    text-align: center;
}

form {
    max-width: 400px;
    margin: 0 auto;
}

label, input, textarea {
    display: block;
    margin-bottom: 10px;
}

input[type="submit"] {
    margin-top: 10px;
    cursor: pointer;
}
.error {
    color: rgb(194, 59, 59);
}
</style>