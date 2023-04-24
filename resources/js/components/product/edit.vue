<template>
    <div>
    <body>
        <h1>Sửa sản phẩm</h1>
        <form v-on:submit.prevent="editProduct">
            <label for="">Ảnh sản phẩm:</label>
            <img id="product_image" :src="`/storage/${product.product_image}`" alt="image">
            <input type="file" id="image" ref="change image" @change="changeImage">
            <br>
            <br>
            <label for="product_name">Tên sản phẩm:</label>
            <input type="text" id="product_name" v-model="product.product_name" required>
            <span class="error" v-if="errors.product_name">{{ errors.product_name[0] }}</span>
            <br>
            <br>
            <select v-model="product.product_brand">
                <option value="" disabled selected>Thương hiệu:</option>
                <option v-for="category in categories" :value="category.id" :key="category.id" :selected="category.id == product.product_brand">{{ category.category_name }}</option>
            </select>

            <span class="error" v-if="errors.product_brand">{{ errors.product_brand[0] }}</span>
            <br>
            <br>
            <label for="product_price">Giá:</label>
            <input type="number" id="product_price" v-model="product.product_price" required>
            <span class="error" v-if="errors.product_price">{{ errors.product_price[0] }}</span>
            <br>
            <br>
            <label for="product_description">Mô tả:</label>
            <textarea id="product_description" v-model="product.product_description" required></textarea>
            <span class="error" v-if="errors.product_description">{{ errors.product_description[0] }}</span>
            <br>
            <br>
            <input type="submit" value="Sửa sản phẩm">
        </form>
    </body>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                product: {},
                errors: {},
                avatar: '',
                image: '',
                categories: {},
            }
        },
        mounted() {
            this.getProduct();
            this.getCategory();
        },

        methods: {
            async getProduct() {
                const response = await axios.get(`/api/product/edit/${this.id}`)
                this.product = response.data.data
            },

            async editProduct() {
                if (this.avatar) { 
                        const formData = new FormData();
                        formData.append('image', this.avatar);
                        this.image = await axios.post('/api/product/upload-image', formData);
                        this.product.product_image = this.image.data.path;
                }

                try {
                    const update = await axios.put(`/api/product/update/${this.id}`, this.product)
                } catch (error) {
                    this.errors = error.response.data.errors
                }
            },
            async getCategory () {
                const categories = await axios.get('/api/category/list');
                this.categories = categories.data.data.data
            },

            changeImage (e) {
                const file = e.target.files[0];
                if (!file) {
                    return false;
                }
                if (file.type !== 'image/png' && file.type !== 'image/jpg' && file.type !== 'image/jpeg') {
                    this.alert('Định dạng ảnh phải là png, jpg, jpeg');
                    this.imageUrl = '';
                    return false;
                }
                this.avatar = file;
                document.getElementById('product_image').src = URL.createObjectURL(file);
            },
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

img {
    width: 50px;
    height: 50px;
}
</style>