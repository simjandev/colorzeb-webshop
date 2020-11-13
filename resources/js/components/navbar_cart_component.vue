<template>
    <a href="/cart">
        <li id="navbar-cart" class="nav-item">
            <i id="navbar-cart-icon" class="fa fa-shopping-cart"></i>
            <div id="navbar-cart-value-currency">&nbsp;Ft</div>
            <div id="navbar-cart-value">{{ cartValue }}</div>
        </li>
    </a>
</template>

<script>
    export default {
        props: {
            _value: Number,
        },
        data: function () {
            return {
                cartValue: this.$props._value,
            };
        },
        mounted: function() {            
            this.$root.$on('cart-value-changed', (newValue) => {
                this.cartValue = newValue;
            });
        },
    }
</script>