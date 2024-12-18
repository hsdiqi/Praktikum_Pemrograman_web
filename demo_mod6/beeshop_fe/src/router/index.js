import { createRouter, createWebHistory } from 'vue-router'

const Home = () => import('../views/Home.vue')
const About = () => import('../views/aboutUs.vue')
const Support = () => import('../views/support.vue')
const Catalog = () => import('../views/catalog.vue')

const Login = () => import('../views/auth/login.vue')
const Register = () => import('../views/auth/register.vue')

const Admin = () => import('../views/admin/dashboard.vue')
const AddProduct = () => import('../views/admin/create.vue')
const EditProduct = () => import('../views/admin/update.vue')
const AdminProduct = () => import('../views/admin/products.vue')

const Profile = () => import('../views/customer/profile.vue')
const Cart = () => import('../views/customer/cart.vue')

const routes = [ 
    { 
        path: '/', 
        name: 'home', 
        component: Home 
    },{
        path: '/catalog',
        name: 'catalog',
        component: Catalog
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/support',
        name: 'support',
        component: Support
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin
    },
    {
        path: '/admin/add-product',
        name: 'add-product',
        component: AddProduct
    },
    {
        path: '/admin/edit-product/:id',
        name: 'edit-product',
        component: EditProduct
    },
    {
        path: '/admin/products',
        name: 'admin-products',
        component: AdminProduct
    },
    {
        path: '/customer/profile',
        name: 'profile',
        component: Profile
    },
    {
        path: '/customer/cart',
        name: 'cart',
        component: Cart
    }

] 

//create router 
const router = createRouter({ 
    history: createWebHistory(), 
    routes // <-- routes, 
}) 

export default router 