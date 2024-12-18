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
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add New Product</h1>
          </div>
  
          <form @submit.prevent="handleSubmit" class="needs-validation" novalidate>
            <div class="mb-3">
              <label for="productName" class="form-label">Product Name</label>
              <input 
                type="text" 
                class="form-control bg-dark text-light" 
                id="productName" 
                v-model="product.name" 
                required
              >
              <div class="invalid-feedback">
                Please provide a product name.
              </div>
            </div>
  
            <div class="mb-3">
              <label for="productBrand" class="form-label">Brand</label>
              <select 
                class="form-select bg-dark text-light" 
                id="productBrand" 
                v-model="product.brand" 
                required
              >
                <option value="">Choose...</option>
                <option value="Samsung">Samsung</option>
                <option value="Xiaomi">Xiaomi</option>
                <option value="Realme">Realme</option>
                <option value="Oppo">Oppo</option>
                <option value="Vivo">Vivo</option>
                <option value="Infinix">Infinix</option>
                <option value="Itel">Itel</option>
                <option value="Other">Other</option>
              </select>
              <div class="invalid-feedback">
                Please select a brand.
              </div>
            </div>

            <div class="mb-3">
              <label for="productCategory" class="form-label">Category</label>
              <input 
                type="text" 
                class="form-control bg-dark text-light" 
                id="productCategory" 
                v-model="product.category" 
                required
              >
              <div class="invalid-feedback">
                Please provide a product category.
              </div>
            </div>
  
            <div class="mb-3">
              <label for="productDescription" class="form-label">Description</label>
              <textarea 
                class="form-control bg-dark text-light" 
                id="productDescription" 
                v-model="product.description" 
                rows="3" 
                required
              ></textarea>
              <div class="invalid-feedback">
                Please provide a product description.
              </div>
            </div>
  
            <div class="mb-3">
              <label for="productPrice" class="form-label">Price (Rp)</label>
              <input 
                type="number" 
                class="form-control bg-dark text-light" 
                id="productPrice" 
                v-model="product.price" 
                required
              >
              <div class="invalid-feedback">
                Please provide a valid price.
              </div>
            </div>
  
            <div class="mb-3">
              <label for="productStock" class="form-label">Stock</label>
              <input 
                type="number" 
                class="form-control bg-dark text-light" 
                id="productStock" 
                v-model="product.stock" 
                required
              >
              <div class="invalid-feedback">
                Please provide a valid stock number.
              </div>
            </div>

            <div class="mb-3">
              <label for="productYear" class="form-label">Year</label>
              <input 
                type="number" 
                class="form-control bg-dark text-light" 
                id="productYear" 
                v-model="product.year" 
                required
              >
              <div class="invalid-feedback">
                Please provide a valid Year number.
              </div>
            </div>
  
            <div class="mb-3">
              <label for="productImage" class="form-label">Product Image</label>
              <input 
                type="file" 
                class="form-control bg-dark text-light" 
                id="productImage" 
                @change="handleImageUpload" 
                accept="image/*" 
                required
              >
              <div class="invalid-feedback">
                Please provide a product image.
              </div>
            </div>
  
            <button type="submit" class="btn btn-success">Add Product</button>
          </form>
        </main>
      </div>
    </div>
  </template>
  
  <script>
//   import axios from 'axios';
  import api from '../../api';
  
  export default {
    name: 'AddProduct',
    data() {
      return {
        product: {
          name: '',
          brand: '',
          category: '',
          description: '',
          price: '',
          stock: '',
          bought: '0',
          year: '',
          image: null
        }
      }
    },
    methods: {
      handleImageUpload(event) {
        this.product.image = event.target.files[0];
      },
      async handleSubmit() {
        if (this.validateForm()) {
          try {
            const formData = new FormData();
            console.log(this.product)
            for (const key in this.product) {
              formData.append(key, this.product[key]);
            }
  
            const response = await api.post('/api/product', formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            });
  
            console.log('Product added successfully:', response.data);
            window.location.reload();
          } catch (error) {
            console.error('Error adding product:', error);
            alert('Failed to add product. Please try again.');
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
  
  .form-control, .form-select {
    border-color: #6c757d;
  }
  
  .form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
  }
  </style>