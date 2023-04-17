<template>
    <div>
    <body>
        <h1>Sửa sản phẩm</h1>
        <form v-on:submit.prevent="editCategory">
            <label for="category_name">Thương hiệu:</label>
            <input type="text" id="category_name" v-model="category.category_name" required>
            <span class="error" v-if="errors.category_name">{{ errors.category_name[0] }}</span>
            <br>
            <br>
            <label for="category_code">Code:</label>
            <input type="text" id="category_code" v-model="category.category_code" required>
            <span class="error" v-if="errors.category_code">{{ errors.category_code[0] }}</span>
            <br>
            <br>
            <label for="category_description">Mô tả:</label>
            <textarea id="category_description" v-model="category.category_description" required></textarea>
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
        props: ['id'],
        data() {
            return {
                category: {},
                errors: {}
            }
        },

        mounted() {
            this.getCategory();
        },

        methods: {
            async getCategory() {
                const response = await axios.get(`/api/category/edit/${this.id}`)
                this.category = response.data.data
            },

            async editCategory() {
                try {
                    const update = await axios.put(`/api/category/update/${this.id}`, this.category);
                    const check = confirm(update.data.message);

                    if (check) {
                        this.$router.push('/category/list');
                    }
                } catch (error) {
                    this.errors = error.response.data.errors
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