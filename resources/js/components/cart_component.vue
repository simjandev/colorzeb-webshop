<template>
    <div class="row col-sm-12">
        <order-steps-component :_active="1"></order-steps-component>
        <table id="cart-items" class="table table-bordered col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            <thead>
                <tr>
                    <th class="cart-item-image"></th>
                    <th class="cart-item-name">Termék</th>
                    <th class="cart-item-price">Egységár</th>
                    <th class="cart-item-price-total">Összesen</th>
                    <th class="cart-item-edit">Mennyiség</th>
                </tr>
            </thead>
            <tbody>
                <tr is="cart-item-component" v-for="cartItem in cartItems" :key="cartItem.id"
                    :_id="cartItem.id"
                    :_name="cartItem.name"
                    :_price="cartItem.price"
                    :_quantity="cartItem.quantity"
                    :_image="cartItem.image"
                    v-on:remove-cart-item="removeCartItem"
                    v-on:modify-cart-item="modifyCartItem">
                </tr>
            </tbody>
        </table>
        <table id="cart-sum" class="table table-bordered col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            <thead>
                <tr>
                    <th class="alignment-column"></th>
                    <th class="cart-sum-name">Tétel</th>
                    <th class="cart-sum-value">Összeg</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="alignment-column"></td>
                    <td class="cart-sum-name">Szállítás:</td>
                    <td class="cart-sum-value">{{ shipping }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td class="cart-sum-name">Nettó végösszeg:</td>
                    <td class="cart-sum-value">{{ sumPriceBeforeVat }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td class="cart-sum-name">Áfa (27%):</td>
                    <td class="cart-sum-value">{{ sumVat }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td class="cart-sum-name">Fizetendő:</td>
                    <td class="cart-sum-value">{{ sumPriceAfterVat }} Ft</td>
                </tr>
            </tbody>
        </table>
        <div id="payment-button-box" class="text-right col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            <a href="/order-login">
                <button id="payment-button" class="button blue">Tovább</button>
            </a>
        </div>
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
                if (this.shipping) {
                    this.$root.$emit('cart-value-changed', this.sumPriceAfterVat - this.shipping);
                } else {
                    this.$root.$emit('cart-value-changed', this.sumPriceAfterVat);
                }
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