<template>
    <div>
        <body>
            <h1>Danh sách sản phẩm</h1>
            <div>
                <ul class="product-list">
                <li v-if="products.length > 0 " v-for="product in products" class="product-item">
                    <h2 class="product-name">{{ product.product_name }}</h2>
                    <p class="product-brand">Thương hiệu: {{ product.category.category_name }}</p>
                    <p class="product-price">Giá: {{ product.product_price }}</p>
                    <p class="product-description">Mô tả: {{ product.product_description }}</p>
                    <button v-on:click.prevent="editProduct(product.id)">edit</button>
                </li>
                <li class="product-item" v-else>
                    <h2 class="product-name"> Không có thông tin nào cả </h2>
                </li>
                <!-- Các sản phẩm khác được thêm vào đây -->
                </ul>
            </div>
            <div>
                <button @click="getProduct(current_page - 1)" :disabled="current_page === 1">Previous</button>
                <button @click="getProduct(current_page + 1)" :disabled="current_page === paginate.last_page">Next</button>
            </div>
        </body>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                products: {},
                paginate: {},
                current_page: 1
            }
        },

        mounted() {
            this.getProduct();
        },

        methods: {
            async getProduct (page = 1){
                this.current_page = page;
                try {
                    const response = await axios.get(`/api/product/list?page=${page}`);
                    this.products = response.data.data.data; // Gán dữ liệu người dùng vào biến product
                    this.paginate = response.data.data;
                } catch (error) {
                    console.log(error);
                }
            },

            editProduct (productId){
                this.$router.push({ path: `/product/edit/${productId}`});
            }
        },

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

.product-list {
    list-style-type: none;
    padding: 0;
}

.product-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.product-name {
    font-size: 18px;
    margin-top: 0;
}

.product-brand,
.product-price,
.product-description {
    margin-bottom: 5px;
}

</style>