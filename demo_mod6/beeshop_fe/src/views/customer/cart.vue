<template>
    <div class="container-fluid bg-dark text-light py-4">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-4">Keranjang</h1>

                <!-- Select All Header -->
                <div class="card bg-secondary mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="selectAll"
                                v-model="selectAll"
                                @change="toggleSelectAll"
                            />
                            <label class="form-check-label" for="selectAll">Pilih Semua</label>
                        </div>
                        <button class="btn btn-danger btn-sm" @click="deleteSelected" :disabled="!hasSelectedItems">
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- Cart Items -->
                <div v-if="cartItems.length > 0">
                    <div v-for="(item, index) in cartItems" :key="index" class="card bg-secondary mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <input type="checkbox" class="form-check-input" v-model="item.selected" />
                                </div>
                                <div class="col-auto">
                                    <img
                                        :src="item.image"
                                        :alt="item.name"
                                        class="img-fluid rounded"
                                        style="width: 100px; height: 100px; object-fit: cover;"
                                    />
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">{{ item.brand }}</h6>
                                    <p class="mb-1 small">{{ item.name }}</p>
                                    <p class="mb-0 text-warning">Rp{{ formatPrice(item.price) }}</p>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center bg-dark rounded p-1">
                                        <button
                                            class="btn btn-sm btn-dark"
                                            @click="decrementQuantity(index)"
                                            :disabled="item.quantity <= 1"
                                        >
                                            -
                                        </button>
                                        <span class="mx-2 text-light">{{ item.quantity }}</span>
                                        <button class="btn btn-sm btn-dark" @click="incrementQuantity(index)">+</button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-link text-danger" @click="removeItem(index)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-5">
                    <p>Keranjang belanja Anda kosong</p>
                    <router-link to="/catalog" class="btn btn-primary">Mulai Belanja</router-link>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-md-4">
                <div class="card bg-secondary">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga</span>
                            <span class="text-warning">Rp{{ formatPrice(totalPrice) }}</span>
                        </div>
                        <button class="btn btn-success w-100" @click="checkout" :disabled="!hasItems">
                            Beli
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from '../../api';

export default {
    name: 'Cart',
    data() {
        return {
            cartItems: [], // Daftar item di keranjang
            selectAll: false, // Status checkbox "Pilih Semua"
        };
    },
    computed: {
        hasItems() {
            return this.cartItems.length > 0;
        },
        hasSelectedItems() {
            return this.cartItems.some((item) => item.selected);
        },
        totalPrice() {
            return this.cartItems.reduce((total, item) => {
                return total + item.price * item.quantity;
            }, 0);
        },
    },
    created() {
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            try {
                const idUser = localStorage.getItem('idUser');
                if (!idUser) {
                    console.error('ID user tidak ditemukan');
                    return;
                }
                const response = await api.get(`/api/cart/${idUser}`);
                this.cartItems = response.data.data || [];
                console.log(this.cartItems)
            } catch (error) {
                console.error('Gagal memuat data keranjang:', error);
            }
        },
        formatPrice(price) {
            return new Intl.NumberFormat('id-ID').format(price);
        },
        toggleSelectAll() {
            this.cartItems.forEach((item) => {
                item.selected = this.selectAll;
            });
        },
        incrementQuantity(index) {
            this.cartItems[index].quantity++;
        },
        decrementQuantity(index) {
            if (this.cartItems[index].quantity > 1) {
                this.cartItems[index].quantity--;
            }
        },
        removeItem(index) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                this.cartItems.splice(index, 1);
            }
        },
        deleteSelected() {
            if (confirm('Apakah Anda yakin ingin menghapus item yang dipilih?')) {
                this.cartItems = this.cartItems.filter((item) => !item.selected);
                this.selectAll = false;
            }
        },
        checkout() {
            alert('Melanjutkan ke pembayaran...');
        },
    },
    watch: {
        cartItems: {
            handler(items) {
                this.selectAll = items.length > 0 && items.every((item) => item.selected);
            },
            deep: true,
        },
    },
};
</script>

<style scoped>
.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.btn-link {
    text-decoration: none;
}

.card {
    border: none;
}
</style>
