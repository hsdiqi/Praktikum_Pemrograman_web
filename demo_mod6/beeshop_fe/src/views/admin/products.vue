<template>
    <div style="padding: 30px;">
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
                            <img :src="product.image" alt="Product"
                                style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.brand }}</td>
                        <td>Rp{{ formatPrice(product.price) }}</td>
                        <td>{{ product.stock }}</td>
                        <td>
                            <router-link :to="`/admin/edit-product/${product.id}`"
                                class="btn btn-sm btn-warning me-2">Edit</router-link>
                            <button class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import api from '../../api';

export default {
    name: 'ProductTable',
    setup() {
        const products = ref([]); // Gunakan "products" untuk konsistensi dengan template

        const fetchProducts = async () => {
            try {
                const response = await api.get('/api/product');
                products.value = response.data.data.data;
                console.log("Products fetched:", products.value);
            } catch (error) {
                console.error("Failed to fetch products:", error);
            }
        };

        const formatPrice = (price) => {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        const deleteProduct = async (productId) => {
            if (confirm('Are you sure you want to delete this product?')) {
                try {
                    await api.delete(`/api/product/${productId}`);
                    fetchProducts(); // Refresh data setelah penghapusan
                } catch (error) {
                    console.error("Failed to delete product:", error);
                }
            }
        };

        onMounted(() => {
            fetchProducts(); // Memanggil fetchProducts saat komponen dimuat
        });

        return {
            products,
            fetchProducts,
            formatPrice,
            deleteProduct
        };
    }
};
</script>
