<template>
    <div id="cart" class="row">
        <order-steps-component :_active="1"></order-steps-component>
        <div id="cart-items" class="col-sm-12 col-lg-8 offset-lg-2">
            <div id="cart-items-header">
                <a id="back-to-shop-link" href="/">&lt; Vissza a boltba</a>
                <div id="cart-items-count">{{ cartItems.length }} db termék a kosárban</div>
            </div>
            <hr class="gray">
            <div is="cart-item-component" v-for="cartItem in cartItems" :key="cartItem.id"
                :_id="cartItem.id"
                :_productId="cartItem.productId"
                :_name="cartItem.name"
                :_price="cartItem.price"
                :_quantity="cartItem.quantity"
                :_image="cartItem.image"
                v-on:remove-cart-item="removeCartItem"
                v-on:modify-cart-item="modifyCartItem">
            </div>
        </div>

        <div id="cart-sum" class="col-lg-2 offset-lg-8">
            <div class="cart-sum-line">Szállítás: <div class="cart-sum-line-value">{{ shipping }} Ft</div></div>
            <div class="cart-sum-line">Nettó végösszeg: <div class="cart-sum-line-value">{{ sumPriceBeforeVat }} Ft</div></div>
            <div class="cart-sum-line">Áfa (27%): <div class="cart-sum-line-value">{{ sumVat }} Ft</div></div>
            <div class="cart-sum-line">Fizetendő: <div class="cart-sum-line-value">{{ sumPriceAfterVat }} Ft</div></div>
        </div>

        <div id="next-button-box" class="text-right col-sm-12 col-lg-8 offset-lg-2">
            <a href="/order-login">
                <button id="next-button" class="button blue">Tovább</button>
            </a>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                cartItems: this.$props._cartItems,
                shipping: 0,
                sumPriceBeforeVat: 0,
                sumPriceAfterVat: 0,
                sumVat: 0,
            }
        },
        props: {
            _cartItems: Array,
        },
        methods: {
            calculateSumPrices : function() {
                this.sumPriceBeforeVat = 0;
                this.sumPriceAfterVat = this.shipping;
                this.sumVat = 0;
                
                for (var i = 0; i < this.cartItems.length; i++) {
                    this.sumPriceAfterVat += this.cartItems[i].price * this.cartItems[i].quantity;
                }
                
                if (this.sumPriceAfterVat == this.shipping) {
                    this.sumPriceAfterVat = 0;
                }

                this.sumVat = Math.round(this.sumPriceAfterVat - this.sumPriceAfterVat / 1.27);
                this.sumPriceBeforeVat = this.sumPriceAfterVat - this.sumVat;
            },
            removeCartItem: function(id) {
                for (var i = 0; i < this.cartItems.length; i++) {
                    if (this.cartItems[i].id == id) {
                        this.cartItems.splice(i, 1);
                        this.calculateSumPrices();
                        this.updateCartValue();
                        break;
                    }
                }
            },
            updateCartValue: function() {
                this.$root.$emit('cart-items-changed', this.cartItems.length);
            },
            modifyCartItem: function(id, quantity) {
                for (var i = 0; i < this.cartItems.length; i++) {
                    if (this.cartItems[i].id == id) {
                        this.cartItems[i].quantity = parseInt(quantity);
                        this.calculateSumPrices();
                        this.updateCartValue();
                        break;
                    }
                }
            },
        },
        mounted: function() {
            this.calculateSumPrices();

            // remove empty parameters from cart items
            // and calculate shipping price
            for (var i = 0; i < this.cartItems.length; i++) {
                if (this.cartItems[i].shippingPrice > this.shipping) {
                    this.shipping = this.cartItems[i].shippingPrice;
                }

                if (this.cartItems[i].parameters[2] == '') {
                    this.cartItems[i].parameters.splice(2, 1);
                }

                if (this.cartItems[i].parameters[1] == '') {
                    this.cartItems[i].parameters.splice(1, 1);
                }

                if (this.cartItems[i].parameters[0] == '') {
                    this.cartItems[i].parameters.splice(0, 1);
                }

                if (this.cartItems[i].parameters.length) {
                    this.cartItems[i].name += ' (' + this.cartItems[i].parameters.join(', ') + ')';
                }
            }

            this.calculateSumPrices();
        },
    }
</script>