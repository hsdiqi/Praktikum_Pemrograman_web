<template>
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <router-link class="nav-link text-light" to="/admin">
                                Dashboard
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-light active" to="/admin/products">
                                Products
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-light" to="/admin/customers">
                                Customers
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-light" to="/admin/orders">
                                Orders
                            </router-link>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-dark text-light">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Product</h1>
                </div>

                <form @submit.prevent="handleSubmit" class="needs-validation" novalidate v-if="product">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control bg-dark text-light" id="productName"
                            v-model="product.name" required>
                        <div class="invalid-feedback">
                            Please provide a product name.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productBrand" class="form-label">Brand</label>
                        <select class="form-select bg-dark text-light" id="productBrand" v-model="product.brand"
                            required>
                            <option value="">Choose...</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Xiaomi">Xiaomi</option>
                            <option value="Realme">Realme</option>
                            <option value="Oppo">Oppo</option>
                            <option value="Vivo">Vivo</option>
                            <option value="Infinix">Infinix</option>
                            <option value="Itel">Itel</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a brand.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control bg-dark text-light" id="productDescription"
                            v-model="product.description" rows="3" required></textarea>
                        <div class="invalid-feedback">
                            Please provide a product description.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price (Rp)</label>
                        <input type="number" class="form-control bg-dark text-light" id="productPrice"
                            v-model="product.price" required>
                        <div class="invalid-feedback">
                            Please provide a valid price.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productStock" class="form-label">Stock</label>
                        <input type="number" class="form-control bg-dark text-light" id="productStock"
                            v-model="product.stock" required>
                        <div class="invalid-feedback">
                            Please provide a valid stock number.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control bg-dark text-light" id="productImage"
                            @change="handleImageUpload" accept="image/*">
                        <div class="invalid-feedback">
                            Please provide a product image.
                        </div>
                    </div>

                    <div class="mb-3" v-if="product.image">
                        <label class="form-label">Current Image</label>
                        <img :src="product.image" alt="Current product image" class="img-thumbnail"
                            style="max-width: 200px;">
                    </div>

                    <button type="submit" class="btn btn-success">Update Product</button>
                </form>
                <div v-else class="text-center">
                    <p>Loading product details...</p>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import api from '../../api';
import { ref, onMounted } from 'vue';

export default {
    name: 'EditProduct',
    data() {
        return {
            product: null,
            newImage: null,
        }
    },
    created() {
        this.fetchProductDetails();
    },
    methods: {
        async fetchProductDetails() {
            try {
                var id = this.$route.params.id;
                // console.log(id)
                const response = await api.get(`/api/product/${id}`);
                this.product = response.data.data;
                console.log(this.product)
            } catch (error) {
                console.error('Error fetching product details:', error);
                alert('Failed to fetch product details. Please try again.');
            }
        },
        handleImageUpload(event) {
            this.newImage = event.target.files[0];
        },
        async handleSubmit() {
            if (this.validateForm()) {
                try {
                    const formData = new FormData();
                    for (const key in this.product) {
                        if (key !== 'image') {
                            formData.append(key, this.product[key]);
                        }
                    }
                    if (this.newImage) {
                        formData.append('image', this.newImage);
                    }
                    formData.append('_method', 'PUT');

                    const response = await api.post(`/api/product/${this.product.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });

                    console.log('Product updated successfully:', response.data);
                    this.$router.push('/admin');
                } catch (error) {
                    console.error('Error updating product:', error);
                    alert('Failed to update product. Please try again.');
                }
            }
        },
        validateForm() {
            const form = document.querySelector('.needs-validation');
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            return form.checkValidity();
        }
    }
}
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

.form-control,
.form-select {
    border-color: #6c757d;
}

.form-control:focus,
.form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}
</style>