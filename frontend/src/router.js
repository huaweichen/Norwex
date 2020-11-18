import {createRouter, createWebHistory} from 'vue-router'

const Customer = () => import('@/components/pages/Customer.vue')

export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/customers',
            name: 'customers',
            component: Customer
        }
    ]
})
