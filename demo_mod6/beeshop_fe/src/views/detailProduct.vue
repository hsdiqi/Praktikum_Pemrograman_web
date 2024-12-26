<template>
    <div class="product-detail-container">
        <!-- Back Button -->
        <button @click="goBack" class="back-button text-success mb-4 d-inline-block text-warning">← Back to Store</button>

        <!-- Product Image Section -->
        <div class="product-image">
            <img :src="product.image" :alt="product.name" />
        </div>

        <!-- Product Info Section -->
        <div class="product-info">
            <h1 class="product-name">{{ product.name }}</h1>
            <h2 class="product-price">Rp{{ formatPrice(product.price) }}</h2>

            <div class="info-section">
                <h3>Info Produk:</h3>
                <ul>
                    <li><strong>Kategori:</strong> {{ product.category }}</li>
                    <li><strong>Brand:</strong> {{ product.brand }}</li>
                    <li><strong>Tahun Rilis:</strong> {{ product.year }}</li>
                </ul>
            </div>
        </div>

        <!-- Purchase Section -->
        <div class="purchase-section">
            <h3>Atur Jumlah dan Catatan</h3>
            <div class="quantity-selector">
                <button @click="decreaseQuantity">-</button>
                <input type="number" v-model="quantity" min="1" :max="product.stock" />
                <button @click="increaseQuantity">+</button>
            </div>
            <p><strong>Stok:</strong> {{ product.stock }}</p>
            <button class="add-to-cart" @click="addToCart">Masukkan Keranjang</button>
            <button class="buy-now" @click="buyNow">Beli</button>
        </div>

        <!-- Product Specs Section -->
        <div class="product-specs">
            <h3>Detail Produk</h3>
            <p>{{ product.description }}</p>
            <a href="#" class="view-more">Lihat Selengkapnya</a>
        </div>
    </div>
</template>


<script>
import api from "../api";

export default {
    data() {
        return {
            product: {},
        };
    },
    methods: {
        async fetchProduct() {
            try {
                const productId = this.$route.query.id;
                const response = await api.get(`/api/product/${productId}`);
                this.product = response.data.data;
            } catch (error) {
                console.error("Error fetching product details:", error);
                if (error.response?.status === 404) {
                    alert("Product not found. Please check the URL.");
                } else {
                    alert("An error occurred. Please try again later.");
                }
            }
        },

        formatPrice(price) {
            // Format price as Indonesian Rupiah
            if (!price || price <= 0) return "0,00";
            const parts = parseFloat(price).toFixed(2).split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return `${parts[0]},${parts[1]}`;
        },
        async addToCart(product) {
            try {
                const response = await api.put(`/api/cart/${product.id}`);
                alert(`Product ${response.data.data.name} added to cart successfully!`);
            } catch (error) {
                console.error("Error adding to cart:", error);
            }
        }, goBack() {
            this.$router.back();
        }
    },
    mounted() {
        this.fetchProduct(); // Fetch the product details on page load
    },
};
</script>

<style scoped>
/* Base Layout */
.product-detail-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    color: #fff;
    background-color: #000;
    justify-content: center;
    align-items: flex-start;
}

.product-image {
    flex: 1 1 300px;
    max-width: 400px;
    text-align: center;
}

.product-image img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.product-info {
    flex: 2 1 400px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.product-info .product-name {
    font-size: 24px;
    font-weight: bold;
}

.product-info .product-price {
    font-size: 20px;
    color: #ff5733;
}

.info-section ul {
    list-style: none;
    padding: 0;
}

.info-section ul li {
    margin-bottom: 8px;
}

.purchase-section {
    flex: 1 1 300px;
    background-color: #222;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.quantity-selector {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
}

.quantity-selector button {
    background-color: #444;
    color: #fff;
    border: none;
    padding: 10px;
    margin: 0 5px;
    cursor: pointer;
    border-radius: 5px;
}

.quantity-selector input {
    width: 50px;
    text-align: center;
    border: 1px solid #444;
    border-radius: 5px;
}

.add-to-cart,
.buy-now {
    display: block;
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.add-to-cart {
    background-color: green;
}

.buy-now {
    background-color: red;
}

.product-specs {
    flex: 1 1 100%;
    margin-top: 20px;
}

.product-specs p {
    white-space: pre-wrap;
}

.view-more {
    color: cyan;
    text-decoration: underline;
    cursor: pointer;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .product-detail-container {
        flex-direction: column;
        align-items: center;
    }

    .product-image,
    .product-info,
    .purchase-section {
        max-width: 100%;
        text-align: center;
    }

    .purchase-section {
        width: 100%;
    }

    .product-info {
        align-items: center;
    }
}

.back-button {
    text-decoration: none;
    font-weight: bold;
    border: none;
    background: none;
    cursor: pointer;
    margin: 0;
    padding: 0;
}

.back-button:hover {
    text-decoration: underline;
}
</style>