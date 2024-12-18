<template>
  <div id="app" class="bg-dark">
    <!-- Navbar hanya ditampilkan jika bukan halaman login, register, atau admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" v-if="!isLoginPage && !isRegisterPage && !isAdminPage">
      <div class="container">
        <router-link class="navbar-brand text-warning" to="/">Bee Shoop</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <router-link class="nav-link" to="/">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/about">About Us</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/catalog">Catalog</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/support">Support</router-link>
            </li>
          </ul>
          <div class="d-flex">
            <router-link v-if="!isLoggedIn" to="/login" class="btn btn-success">Login</router-link>
            <div v-else class="d-flex align-items-center">
              <router-link to="/customer/cart" class="btn btn-outline-light me-2">
                Cart <span class="badge bg-warning text-dark">{{ cartCount }}</span>
              </router-link>
              <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                  Hi, {{ username }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><router-link class="dropdown-item" to="/customer/profile">Profile</router-link></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#" @click="logout">Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Konten Halaman -->
    <router-view></router-view>

    <!-- Footer hanya ditampilkan jika bukan halaman login, register, atau admin -->
    <footer class="bg-dark text-light py-4 mt-5" v-if="!isLoginPage && !isRegisterPage && !isAdminPage">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h5 class="text-warning">Bee Shop: Toko Handphone</h5>
            <p>Your trusted phone shop partner</p>
          </div>
          <div class="col-md-6 text-md-end">
            <p>&copy; 2024 Bee Shop. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import api from './api';

export default {
  name: 'App',
  data() {
    return {
      cartCount: 0, // Jumlah barang di keranjang
    };
  },
  computed: {
    // Cek apakah halaman saat ini adalah login, register, atau admin
    isLoginPage() {
      return this.$route.path === '/login';
    },
    isRegisterPage() {
      return this.$route.path === '/register';
    },
    isAdminPage() {
      return this.$route.path.startsWith('/admin');
    },
    isLoggedIn() {
      return !!localStorage.getItem('token');
    },
    username() {
      return localStorage.getItem('userName') || 'Guest';
    },
  },
  methods: {
    // Ambil jumlah barang di keranjang
    async fetchCartCount() {
      try {
        const id = localStorage.getItem('idUser'); // Ambil id user dari localStorage
        if (!id) {
          console.error('ID user tidak ditemukan!');
          return;
        }

        // Panggil API untuk mendapatkan data keranjang berdasarkan id
        const response = await api.get(`/api/cart/${id}`);
        const totalProduct = response.data.data;

        // Pastikan totalProduct valid dan hitung jumlah barang
        if (Array.isArray(totalProduct)) {
          this.cartCount = totalProduct.reduce((total, item) => total + (item.quantity || 0), 0);
        } else {
          console.error('Data keranjang tidak valid!');
        }
      } catch (error) {
        console.error('Terjadi kesalahan saat menghitung barang di keranjang:', error);
      }
    },
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('idUser');
      localStorage.removeItem('userName');
      this.cartCount = 0; // Reset jumlah barang
      this.$router.push('/login');
    },
  },
  mounted() {
    // Ambil jumlah barang di keranjang saat komponen dimuat
    if (this.isLoggedIn) {
      this.fetchCartCount();
    }
  },
};
</script>

<style>
#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.router-view {
  flex: 1;
}
</style>
