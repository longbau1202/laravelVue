<template>
    <div>
        <body>
            <h1>Danh sách sản phẩm</h1>
            <ul class="product-list">
                <li class="product-item">
                    <h2 class="product-name">Tên sản phẩm 1</h2>
                    <p class="product-brand">Thương hiệu: Thương hiệu 1</p>
                    <p class="product-price">Giá: $100</p>
                    <p class="product-description">Mô tả: Mô tả sản phẩm 1</p>
                </li>
                <li class="product-item">
                    <h2 class="product-name">Tên sản phẩm 2</h2>
                    <p class="product-brand">Thương hiệu: Thương hiệu 2</p>
                    <p class="product-price">Giá: $200</p>
                    <p class="product-description">Mô tả: Mô tả sản phẩm 2</p>
                </li>
                <!-- Các sản phẩm khác được thêm vào đây -->
            </ul>
        </body>
    </div>
</template>

<script></script>
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