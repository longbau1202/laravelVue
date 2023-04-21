<template>
    <div>
        <body>
            <h1>Danh sách thương hiệu</h1>
            <div>
                <ul class="category-list">
                    <li v-if="categories.length > 0 " v-for="category in categories" class="category-item">
                        <h2 class="category-name">{{ category.category_name }}</h2>
                        <p class="category-code">Code: {{ category.category_code }}</p>
                        <p class="category-description">Mô tả: {{ category.category_description }}</p>
                        <button v-on:click.prevent="editCategory(category.id)">edit</button>
                    </li>
                    <li class="category-item" v-else>
                        <h2 class="category-name"> Không có thông tin nào cả </h2>
                    </li>
                    <!-- Các sản phẩm khác được thêm vào đây -->
                </ul>
            </div>
            <div>
                <button v-on:click="getCategory(current_page - 1)" :disabled="current_page === 1">Previous</button>
                <button v-on:click="getCategory(current_page + 1)" :disabled="current_page === paginate.last_page">next</button>
            </div>
        </body>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                categories: {},
                current_page: 1,
                paginate: {},
            }
        },

        mounted() {
            this.getCategory();
        },

        methods: {
            async getCategory (page = 1){
                this.current_page = page;
                try {
                    const response = await axios.get(`/api/category/list?page=${page}`)
                    this.categories = response.data.data.data; // Gán dữ liệu người dùng vào biến category
                    this.paginate = response.data.data
                } catch (error) {
                    console.log(error);
                }
            },

            editCategory (categoryId){
                this.$router.push({ path: `/category/edit/${categoryId}`})
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

.category-list {
    list-style-type: none;
    padding: 0;
}

.category-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.category-name {
    font-size: 18px;
    margin-top: 0;
}

.category-brand,
.category-price,
.category-description {
    margin-bottom: 5px;
}

</style>