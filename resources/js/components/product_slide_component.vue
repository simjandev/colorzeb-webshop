<template>
    <div class="product-slider">
        <div class="product-slider-title">{{ _title }}</div>
        <div class="product-slider-left" v-on:click="pageLeft"><i class="fa fa-chevron-left"></i></div>
        <div class="product-slider-right" v-on:click="pageRight"><i class="fa fa-chevron-right"></i></div>
        <div class="product-slider-box" v-for="(productBox, index) in productBoxes" :key="index" :style="{left: productBox.left}">
            <div class="product" v-for="(product, index2) in productBox.products" :key="index2">
                <a :href="'/product/' + product.id">
                    <div class="product-image-box">
                        <img class="product-image" :src="'/product-image/' + product.image.name + '/' + product.image.color + '/' + product.image.extraImage">
                    </div>
                    <div class="product-name">{{ index + ', ' + product.name }}</div>
                    <div class="product-price-bubble">
                        <div class="bubble-price">{{ product.price }} Ft</div>
                        <div class="bubble-view-text">Tovább</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="product-slider-circles">
            <div :class="{'product-slider-circle': true, selected: currentPageIndex == index}"
                v-for="(productBox, index) in productBoxes" :key="index" v-on:click="pageTo(index)"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            _products: Array,
            _title: String,
        },

        data: function () {
            return {
                productBoxes: [],
                currentPageIndex: 0,
            };
        },

        mounted: function () {
            for (var i = 0; i < this.$props._products.length; i++) {
                if (i % 6 == 0) {
                    this.productBoxes.push({
                        products: [],
                        left: (100 * this.productBoxes.length) + '%',
                    });
                }

                var product = {
                    id  : this.$props._products[i].id,
                    name: this.$props._products[i].name,
                    image: JSON.parse(this.$props._products[i].main_image),
                    price: this.$props._products[i].discount_price ? this.$props._products[i].discount_price : this.$props._products[i].price,
                };

                this.productBoxes[this.productBoxes.length - 1].products.push(product);
            }
        },

        methods: {
            pageLeft: function() {
                if (this.currentPageIndex == 0) {
                    return;
                }

                for (var i = 0; i < this.productBoxes.length; i++) {
                    var newLeft = parseInt(this.productBoxes[i].left) + 100;
                    this.productBoxes[i].left = newLeft + '%';
                }

                this.currentPageIndex --;
            },
            pageRight: function() {
                if (this.currentPageIndex == this.productBoxes.length - 1) {
                    return;
                }

                for (var i = 0; i < this.productBoxes.length; i++) {
                    var newLeft = parseInt(this.productBoxes[i].left) - 100;
                    this.productBoxes[i].left = newLeft + '%';
                }

                this.currentPageIndex ++;
            },
            pageTo(newIndex) {
                while(newIndex > this.currentPageIndex) {
                    this.pageRight();
                }

                while(newIndex < this.currentPageIndex) {
                    this.pageLeft();
                }
            },
        }
    }
</script>