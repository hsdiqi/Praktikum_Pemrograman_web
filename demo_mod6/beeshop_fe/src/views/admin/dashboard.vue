<template>
  <div class="container-fluid">
    <div class="row">
      <!-- Admin Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <router-link class="nav-link" to="/admin">
                Dashboard
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link active" to="/admin/products">
                Products
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/admin/customers">
                Customers
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/admin/orders">
                Orders
              </router-link>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 style="color: aliceblue;">Manage Products</h1>
          <button class="btn btn-primary" @click="add">Add New Product</button>
        </div>

        <!-- Products Table -->
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id">
                <td>
                  <img :src="product.image" alt="Product" style="width: 50px; height: 50px; object-fit: cover;">
                </td>
                <td>{{ product.name }}</td>
                <td>{{ product.brand }}</td>
                <td>Rp{{ formatPrice(product.price) }}</td>
                <td>{{ product.stock }}</td>
                <td style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                  <router-link :to="`/admin/edit-product/${product.id}`"
                    class="btn btn-sm btn-warning me-2">Edit</router-link>
                  <button class="btn btn-sm btn-danger" style="margin-top: 5px;"
                    @click="deleteProduct(product.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</template>

<script>

// import axios from 'axios';
import api from '../../api';
import { ref, onMounted } from 'vue';

export default {
  name: 'dashboardAdmin',
  data() {
    return {
      products: ref([])
    }
  },
  created() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await api.get('/api/product');
        this.products = response.data.data;
        console.log(this.products)
      } catch (error) {
        console.log(error)
      }
    },
    // const fetchProducts async = () => {
    //   await api.get('/api/product').then((response) => {
    //     products.value = response.data.data.data;

    //     console.log("List data:", products.value);

    //   })
    //     .catch((error) => {
    //     console.error("Failed to ffetching product", error)
    //   })
    // },
    add() {
      this.$router.push('/admin/add-product')
    },
    formatPrice(price) {
      return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      // return price.toLocaleString('id-ID');
    },
    // method delete
    async deleteProduct(productId) {
      console.log(productId)
      if (confirm('Are you sure you want to delete this product?')) {
        try {
          await api.delete(`/api/product/${productId}`);
          this.fetchProducts();
        } catch (error) {
          console.log(error);
        }
      }
    }
  },
  mounted() {
    this.fetchProducts(); // Panggil fetch saat komponen dimuat
  }
};
</script>

<style scoped>
.sidebar {
  height: calc(100vh - 56px);
  position: fixed;
  top: 56px;
  bottom: 0;
  left: 0;
}

@media (max-width: 767.98px) {
  .sidebar {
    position: static;
    height: auto;
  }
}
</style>