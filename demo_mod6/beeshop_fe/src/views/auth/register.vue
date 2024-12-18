<template>
    <div class="container-fluid bg-dark min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card bg-dark text-light" style="width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center text-warning mb-4">Register</h2>
                <form @submit.prevent="handleRegister">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control bg-dark text-light" id="name" v-model="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-dark text-light" id="email" v-model="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control bg-dark text-light" id="phone" v-model="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control bg-dark text-light" id="address" v-model="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control bg-dark text-light" id="password" v-model="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control bg-dark text-light" id="password_confirmation" v-model="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>
                <p class="mt-3 text-center">
                    Sudah Punya akun?
                    <router-link to="/login" class="text-success">Login</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
// import axios from 'axios';
import api from '../../api';

export default {
    name: 'Register',
    data() {
        return {
            name: '',
            email: '',
            phone: '',
            address: '',
            password: '',
            password_confirmation: '', // Tambahkan field ini
        }
    },
    methods: {
        async handleRegister() {
            try {
                const response = await api.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    address: this.address,
                    password: this.password,
                    password_confirmation: this.password_confirmation, // Kirim password_confirmation
                });

                if (response.data.success) {
                    alert('Registration successful. Please login.');
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('Registration failed:', error.response || error);
                if (error.response && error.response.status === 422) {
                    alert('Validation failed. Please check your input.');
                } else {
                    alert('Registration failed. Please try again.');
                }
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
