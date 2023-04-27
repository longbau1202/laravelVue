<template>
    <div>
        <body>
            <h1>Danh sách sản phẩm</h1>
            <div class="search-container">
            <form action="javascript:void(0);" method="GET">
                <input type="text" placeholder="Tìm kiếm" v-model="search_value">
                <button v-on:click="searchItem" ><i class="fa fa-search"></i></button>
            </form>
            </div>
            <div>
                <ul class="product-list">
                    <button @click="sortData" :value="sort">sort</button>
                <li v-if="products.length > 0 " v-for="product in products" class="product-item">
                    <img :src="`/storage/${product.product_image}`" alt="image">
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

            <button v-on:click="getProduct">clear</button>
        </body>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                products: {},
                paginate: {},
                current_page: 1,
                search_value: '',
                sort: 'ASC'
            }
        },

        mounted() {
            this.getProduct();
        },

        methods: {
            async getProduct (page = 1){
                this.current_page = page;
                try {
                    const response = await axios.get(`/api/product/list?page=${page}&sort=DESC`);
                    this.products = response.data.data.data; // Gán dữ liệu người dùng vào biến product
                    this.paginate = response.data.data;
                } catch (error) {
                    console.log(error);
                }
            },

            async sortData () {
                const response = await axios.get(`/api/product/list?sort=${this.sort}`);
                this.products = response.data.data.data;
                this.paginate = response.data.data;
                if (this.sort === 'DESC') {
                    this.sort = 'ASC';
                } else {
                    this.sort = 'DESC';
                }
            },

            editProduct (productId){
                this.$router.push({ path: `/product/edit/${productId}`});
            },

            async searchItem () {
                if (!this.search_value) {
                    return;
                }
                const search = await axios.get(`/api/product/search?value=${this.search_value}`);
                this.products = search.data.data.data;
                this.paginate = search.data.data;
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
img {
    width: 50px;
    height: 50px;
}
.search-container {
  display: flex;
  align-items: center;
}

.search-container input[type="text"] {
  padding: 10px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
  border-bottom: 1px solid #ccc;
}

.search-container input[type="text"]:focus {
  outline: none;
  border-bottom: 2px solid dodgerblue;
}

.search-container button {
  background-color: dodgerblue;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
}

.search-container button:hover {
  background-color: #ccc;
}


</style>