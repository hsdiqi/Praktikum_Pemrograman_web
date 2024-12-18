<template>
    <div class="container-fluid bg-dark text-light py-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <h1 class="mb-4">User Profile</h1>
          <div class="card bg-secondary">
            <div class="card-body">
              <form
                @submit.prevent="updateProfile"
                class="needs-validation"
                novalidate
                :class="{ 'was-validated': formValidated }"
              >
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input
                    type="text"
                    class="form-control bg-dark text-light"
                    id="name"
                    v-model="user.name"
                    :disabled="!isEditing"
                    required
                  />
                  <div class="invalid-feedback">Please provide your name.</div>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control bg-dark text-light"
                    id="email"
                    v-model="user.email"
                    :disabled="!isEditing"
                    required
                  />
                  <div class="invalid-feedback">Please provide a valid email.</div>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input
                    type="tel"
                    class="form-control bg-dark text-light"
                    id="phone"
                    v-model="user.phone"
                    :disabled="!isEditing"
                  />
                </div>
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea
                    class="form-control bg-dark text-light"
                    id="address"
                    v-model="user.address"
                    :disabled="!isEditing"
                    rows="3"
                  ></textarea>
                </div>
                <div class="mb-3" v-if="isEditing">
                  <label for="newPassword" class="form-label">New Password</label>
                  <input
                    type="password"
                    class="form-control bg-dark text-light"
                    id="newPassword"
                    v-model="newPassword"
                  />
                </div>
                <div class="mb-3" v-if="isEditing">
                  <label for="confirmPassword" class="form-label">Confirm Password</label>
                  <input
                    type="password"
                    class="form-control bg-dark text-light"
                    id="confirmPassword"
                    v-model="confirmPassword"
                  />
                  <div class="invalid-feedback">Passwords do not match.</div>
                </div>
                <div class="d-flex justify-content-between">
                  <button
                    type="button"
                    class="btn"
                    :class="isEditing ? 'btn-secondary' : 'btn-warning'"
                    @click="toggleEditing"
                  >
                    {{ isEditing ? 'Cancel' : 'Edit Profile' }}
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteProfile"
                  >
                    Delete Profile
                  </button>
                  <button
                    v-if="isEditing"
                    type="submit"
                    class="btn btn-primary"
                  >
                    Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import api from '../../api';
  
  export default {
    name: 'UserProfile',
    data() {
      return {
        user: {
          name: '',
          email: '',
          phone: '',
          address: '',
        },
        newPassword: '',
        confirmPassword: '',
        isLoading: false,
        isEditing: false,
        formValidated: false,
      };
    },
    created() {
      this.fetchUserProfile();
    },
    methods: {
      async fetchUserProfile() {
        try {
          this.isLoading = true;
          const id = localStorage.getItem('idUser');
          const response = await api.get(`/api/customer/${id}`);
          this.user = response.data.data;
        } catch (error) {
          console.error('Error fetching user profile:', error);
          alert('Failed to fetch user profile. Please try again.');
        } finally {
          this.isLoading = false;
        }
      },
      toggleEditing() {
        this.isEditing = !this.isEditing;
        if (!this.isEditing) {
          this.newPassword = '';
          this.confirmPassword = '';
        }
      },
      async updateProfile() {
        if (this.validateForm()) {
          try {
            this.isLoading = true;
            const updateData = { ...this.user, _method: 'PUT' }; // Tambahkan _method: PUT
            if (this.newPassword) {
              updateData.password = this.newPassword;
            }
            const id = localStorage.getItem('idUser');
            await api.post(`/api/customer/${id}`, updateData); // Gunakan POST
            alert('Profile updated successfully!');
            this.isEditing = false;
          } catch (error) {
            console.error('Error updating user profile:', error);
            alert('Failed to update profile. Please try again.');
          } finally {
            this.isLoading = false;
          }
        }
      },
      async deleteProfile() {
        try {
          const id = localStorage.getItem('idUser');
          await api.delete(`/api/customer/${id}`);
          alert('Profile deleted successfully!');
          localStorage.clear();
          this.$router.push({ name: 'home' });
        } catch (error) {
          console.error('Error deleting user profile:', error);
          alert('Failed to delete profile. Please try again.');
        }
      },
      validateForm() {
        const form = document.querySelector('.needs-validation');
        this.formValidated = true;
        if (!form.checkValidity() || this.newPassword !== this.confirmPassword) {
          document
            .getElementById('confirmPassword')
            .setCustomValidity('Passwords do not match');
          return false;
        } else {
          document.getElementById('confirmPassword').setCustomValidity('');
        }
        return true;
      },
    },
  };
  </script>
  
  <style scoped>
  .form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
  }
  </style>
  