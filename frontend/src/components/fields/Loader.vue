<template>
    <div class="spinner-border text-success" role="status">
        <span class="sr-only">{{ loadingMessage }}</span>
    </div>
</template>

<script>
export default {
    name: 'Loader',
    props: {
        loadingMessage: {
            type: String,
            default: 'Loading ... '
        }
    }
}
</script>

<style scoped>

</style>