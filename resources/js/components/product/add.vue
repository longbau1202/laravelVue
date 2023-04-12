<template>
    <div>
    <body>
        <h1>Thêm sản phẩm</h1>
        <form v-on:submit.prevent="addProduct">
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" id="product_name" v-model="product_name" required>
            <span class="error" v-if="errors.product_name">{{ errors.product_name[0] }}</span>
            <br>
            <br>
            <label for="product_brand">Thương hiệu:</label>
            <input type="text" id="product_brand" v-model="product_brand" required>
            <span class="error" v-if="errors.product_brand">{{ errors.product_brand[0] }}</span>
            <br>
            <br>
            <label for="product_price">Giá:</label>
            <input type="number" id="product_price" v-model="product_price" required>
            <span class="error" v-if="errors.product_price">{{ errors.product_price[0] }}</span>
            <br>
            <br>
            <label for="product_description">Mô tả:</label>
            <textarea id="product_description" v-model="product_description" required></textarea>
            <span class="error" v-if="errors.product_description">{{ errors.product_description[0] }}</span>
            <br>
            <br>
            <input type="submit"  value="Thêm sản phẩm">
        </form>
    </body>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product_name: '',
                product_brand: '',
                product_price: '',
                product_description: '',
                errors: {}
            }
        },

        methods: {
            async addProduct() {
                const postData = {
                    product_name: this.product_name,
                    product_brand: this.product_brand,
                    product_price: this.product_price,
                    product_description: this.product_description,
                }
                try {
                    const response = await axios.post('/api/product/add', postData);
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