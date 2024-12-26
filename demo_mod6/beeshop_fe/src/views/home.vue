<template>
  <div class="container py-4">
    <section class="mb-5">
      <h2 class="mb-4 text-light">Terbaru</h2>
      <div class="row g-4">
        <div v-for="product in latestProducts" :key="product.id" class="col-md-3">
          <div class="card mb-4 h-100 p-1" @click="goToProductDetail(product.id)">
            <img :src="product.image" class="card-img-top fixed-image" :alt="product.name">
            <div class="card-body">
              <h5 class="card-title text-truncate"
                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{
                product.name }}</h5>
              <p class="card-text">{{ product.description }}</p>
              <p class="card-text"><strong>Rp{{ formatPrice(product.price) }}</strong></p>
              <button @click="addToCart(product)" class="btn btn-success w-100">
                Masukkan keranjang
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <h2 class="mb-4 text-light">Best Seller</h2>
      <div class="row g-4">
        <div v-for="product in bestSellers" :key="product.id" class="col-md-3">
          <div class="card mb-4 h-100 p-1" @click="goToProductDetail(product.id)">
            <img :src="product.image" class="card-img-top fixed-image" :alt="product.name">
            <div class="card-body">
              <h5 class="card-title text-truncate">{{ product.name }}</h5>
              <p class="card-text text-truncate"
                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{
                  product.description }}</p>
              <p class="card-text"><strong>Rp{{ formatPrice(product.price) }}</strong></p>
              <button @click="addToCart(product)" class="btn btn-success w-100">
                Masukkan keranjang
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import api from '../api';

export default {
  data() {
    return {
      latestProducts: [],
      bestSellers: [],
      customerData: []
    };
  },
  methods: {
    async fetchProducts() {
      try {
        // Ganti URL ini dengan endpoint backend Anda
        const latestResponse = await api.get('/api/home?sort_by=year&order=desc');
        const bestSellersResponse = await api.get('/api/home?sort_by=bought&order=asc');

        // Simpan data dari backend ke dalam state
        this.latestProducts = latestResponse.data.data.data;
        this.bestSellers = bestSellersResponse.data.data.data;
        console.log(this.latestProducts);
        console.log(this.bestSellers);
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    formatPrice(price) {
      return price.toLocaleString('id-ID');
    }, goToProductDetail(productId) {
      if (!productId) {
        console.error("Invalid product ID:", productId);
        return;
      }
      this.$router.push({ path: '/detail', query: { id: productId } });
    },
    addToCart(product) {
      console.log(`Added ${product.id} to cart!`);
    },
  },
  mounted() {
    this.fetchProducts();
  },
};
</script>

<style scoped>
/* Optional styling */
.card {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  height: 100%;
}

.text-truncate {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.fixed-image {
  object-fit: cover;
  height: 300px;
  width: 100%;
}
</style>