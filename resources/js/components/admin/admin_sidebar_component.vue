<template>
    <div id="admin-side-panel" class="col-lg-2">
        <div id="header"><i class="fa fa-file"></i>&nbsp;&nbsp;Admin oldal</div>

        <a v-for="(link, index) in links" :key="index" :href="link.location"><button :class="{'active': active == link.text, 'button': true, 'blue': true, 'admin-menu-button': true}">{{ link.text }}</button></a>
    </div>
</template>

<script>
    export default {
        props: {
            _active: String,
        },
        data: function() {
            return {
                links: [
                    {
                        text: 'Megrendelések',
                        location: '/admin/orders',
                    },
                    {
                        text: 'Kategóriák',
                        location: '/admin/categories',
                    },
                    {
                        text: 'Termékek',
                        location: '/admin/products',
                    },
                    {
                        text: 'Új termék',
                        location: '/admin/create-product',
                    },
                ],
                active: this.$props._active,
            }
        },
        
        mounted: function() {
            for (var i = 0; i < this.links.length; i++) {
                if (this.links[i].text == this.active) {
                    return;
                }
            }

            this.links.push({
                text: this.active,
                link: window.location,
            });
        },
        
    }
</script>