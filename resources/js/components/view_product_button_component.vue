<template>
    <button class="view-product-button button blue" title="Megtekintés" v-on:click.prevent="viewProduct"><i class="add-to-cart-button fa fa-eye"></i></button>
</template>

<script>
    export default {
        data: function() {
            return {
                quantity: 1,
                parameters: this.$props._parameters,
            }
        },
        props: {
            _id: {
                type: Number,
                default: -1
            },
        },
        methods: {
            viewProduct() {
                window.location.href = '/product/' + this._id;
            }
        },
    }
</script>