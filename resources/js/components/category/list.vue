<template>
    <div>
        <body>
            <h1>Danh sách thương hiệu</h1>
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
        </body>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                categories: {}
            }
        },

        mounted() {
            this.getCategory();
        },

        methods: {
            getCategory (){
                try {
                    const response = axios.get('/api/category/list').then(response => {
                        this.categories = response.data.data; // Gán dữ liệu người dùng vào biến category
                    });
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