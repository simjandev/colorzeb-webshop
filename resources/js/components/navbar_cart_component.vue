<template>
    <a href="/cart">
        <li id="navbar-cart" class="nav-item">
            <div id="navbar-cart-items"><div id="navbar-cart-items-count">{{ cartItemsCount }}</div> Kosár</div>
            <i id="navbar-cart-icon" class="fa fa-shopping-cart"></i>
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
                cartItemsCount: this.$props._value,
            };
        },
        mounted: function() {            
            this.$root.$on('cart-items-changed', (newValue) => {
                this.cartItemsCount = newValue;
            });
        },
    }
</script>