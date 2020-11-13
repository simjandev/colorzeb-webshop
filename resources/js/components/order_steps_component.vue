<template>
    <div class="col-sm-12 col-lg-10 offset-lg-1">
        <ul id="step-bar-titles">
            <li v-for="(item, index) in items" :key="index" :class="item.class">
                <div>{{ item.title }}</div>
            </li>
        </ul>
        <ul id="step-bar">
            <li v-for="(item, index) in items" :key="index" :class="'step-bar ' + item.class">
                <a :href="item.link"><div class="wrap" v-html="item.text"></div></a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {

                items: [
                    {
                        title:'Kosár',
                        class: '',
                        link: '/cart',
                        text: '<i class="fa fa-shopping-cart"></i>',
                    },
                    {
                        title:'Bejelentkezés',
                        class: '',
                        link: '/order-login',
                        text: '<i class="fa fa-user"></i>',
                    },
                    {
                        title:'Szállítási adatok',
                        class: '',
                        link: '/order-shipping',
                        text: '<i class="fa fa-truck"></i>',
                    },
                    {
                        title:'Megerősítés',
                        class: '',
                        link: '/order-confirm',
                        text: '<i class="fa fa-file"></i>',
                    },
                ],
            }
        },
        props: {
            _active: {
                type: Number,
                default: 1,
            },
        },
        mounted: function() {
            this.items[this.$props._active - 1].class = 'active';
            for (var i = 0; i < this.$props._active - 1; i++) {
                this.items[i].class = 'finished';
            }
        }
    }
</script>