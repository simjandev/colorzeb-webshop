<template>
    <div class="product-to-cart-box">
        <button id="product-add-to-cart-button" class="button blue" v-if="_displayText" v-on:click.prevent="addProductToCart">
            Kosárba <i class="fa fa-shopping-cart"></i>
        </button>
        <button class="product-add-to-cart-button button blue" title="Kosárba" v-if="!_displayText" v-on:click.prevent="addProductToCart">
            <i class="add-to-cart-button fa fa-shopping-cart"></i>
        </button>
        <input id="product-quantity" class="form-control blue" type="number" v-model="quantity" min="1" step="1" v-if="_displayText">
    </div>
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
            _displayText: {
                type: Boolean,
                default: false
            },
            _id: {
                type: Number,
                default: -1
            },
            _parameters: {
                type: Array,
                default: function() {
                    return [
                        '',
                        '',
                        '',
                    ];
                },
            }
        },
        methods: {
            addProductToCart: function() {
                axios.post('/add-to-cart', {
                    id: this.$props._id,
                    quantity: this.quantity,
                    parameters: JSON.stringify(this.parameters),
                }).then(response => {
                    window.location = '/cart';
                });
            }
        },
    }
</script>