<template>
    <div class="container-fluid bg-dark min-vh-100 d-flex align-items-center justify-content-center">
      <div class="card bg-dark text-light" style="width: 400px;">
        <div class="card-body">
          <h2 class="card-title text-center text-warning mb-4">Login</h2>
          <form @submit.prevent="handleLogin">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control bg-dark text-light" id="email" v-model="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control bg-dark text-light" id="password" v-model="password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
          </form>
          <p class="mt-3 text-center">
            Belum Punya akun?
            <router-link to="/register" class="text-success">Daftar</router-link>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import api from '../../api';
  
  export default {
    name: 'Login',
    data() {
      return {
        email: '',
        password: ''
      }
    },
    methods: {
      async handleLogin() {
  
        if (this.email === 'admin@gmail.com' && this.password === 'admin') {
          localStorage.setItem('isAdmin', true)
          this.$router.push('/admin')
          return
        }
        try {
          const response = await api.post('/api/login', {
            email: this.email,
            password: this.password
          });
  
          const token = response.data.data.token;
          const customer = response.data.data.customer;

          localStorage.setItem('token', token);
          localStorage.setItem('idUser', customer.id);
          localStorage.setItem('userName', customer.name);

  
          this.$router.push('/');
        } catch (error) {
          console.error('Login failed:', error);
          alert('Login failed. Please check your credentials and try again.');
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .form-control {
    border-color: #6c757d;
  }
  
  .form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
  }
  </style>