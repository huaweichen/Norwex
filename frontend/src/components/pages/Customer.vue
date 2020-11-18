<template>
    <div class="table-responsive-sm">
        <table v-if="customers.length !== 0" class="table table-sm table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total Order Count</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(customer, index) in customers"
                    :key="index"
                    :class="getRowColor(customer.display_color)"
                >
                    <td>{{ customer.customer_name }}</td>
                    <td>{{ customer.total_order_count }}</td>
                </tr>
            </tbody>
        </table>
        <Loader v-show="loading === true"/>
        <div v-if="customers.length === 0 && loading === false" class="alert alert-warning" role="alert">
            No customers found.
        </div>
    </div>
</template>

<script>
import {getCustomers} from '@/api/customers'
import {onMounted, ref} from 'vue';
import Loader from "@/components/fields/Loader";

export default {
    name: 'Customer',
    components: {
        Loader
    },
    setup() {
        let loading = ref(true)
        let customers = ref([])

        onMounted(() => {
            getCustomers().then((response) => {
                loading.value = false
                customers.value = response.customers.data
            })
        })

        function getRowColor(customerColor) {
            switch (customerColor) {
                case 'red':
                    return 'bg-danger'
                case 'orange':
                    return 'bg-warning'
                case 'green':
                    return 'bg-success'
                default:
                    return ''
            }
        }

        return {
            loading,
            customers,
            getRowColor
        }
    }
}
</script>

<style scoped>

</style>