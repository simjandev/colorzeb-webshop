<template>
    <transition name="disappear">
        <div class="cart-item">
            <div class="cart-item-image">
                <img :src="image">
            </div>
            <div class="cart-item-name"><a :href="'/product/' + _productId">{{ _name }}</a></div>
            <div class="cart-item-price">{{ quantity }}x{{ price }} Ft</div>
            <div class="cart-item-edit">
                <input v-model.number="quantity" type="number" class="form-control blue cart-item-quantity" title="darabszám"
                    v-on:change="modifyCartItem(id, quantity)" v-on:click="modifyCartItem(id, quantity)" v-on:keyup="modifyCartItem(id, quantity)">
                <button class="delete-button button red" title="Törlés" v-on:click="removeCartItem(id)">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        data: function() {
            return {
                id: this.$props._id,
                price: this.$props._price,
                quantity: parseInt(this.$props._quantity),
                image: this.$props._image
            }
        },
        props: {
            _id: Number,
            _productId: Number,
            _name: String,
            _price: Number,
            _quantity: Number,
            _image: String,
        },
        methods: {
            modifyCartItem: function(id, quantity) {
                this.quantityValidation();

                axios.post('/modify-cart-item', {
                    id: id,
                    quantity: quantity,
                }).then(response => {
                    if (response.request.response == 'success') {
                        this.quantity = parseInt(this.quantity);
                        this.$emit('modify-cart-item', this.id, parseInt(this.quantity));
                    }
                });
            },

            removeCartItem: function(id, quantity) {
                axios.post('/remove-cart-item', {
                    id: id,
                    quantity: quantity,
                }).then(response => {
                    if (response.request.response == 'success') {
                        this.$emit('remove-cart-item', this.id);
                    }
                });
            },

            quantityValidation: function() {
                if (!Number.isInteger(this.quantity)) {
                    this.quantity = 1;
                }

                if (this.quantity < 1) {
                    this.quantity = 1;
                }

                if (this.quantity > 1000) {
                    this.quantity = 1000;
                }
            },
        },
    }
</script>