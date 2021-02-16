<template>
    <div id="cookie-notification-box" :class="{visible: visible}">
        A ColorZeb weboldala is sütiket használ a kényelmesebb használathoz. A honlap használatával beleegyezel a sütik használatába.<br>
        <button class="button" v-on:click="agree">Elfogad</button>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data: function () {
            return {
                visible: false,
            };
        },
        methods: {
            agree: function() {
                this.visible = false;
                this.$cookie.set('gdpr', 'agreed', 1);
            }
        },
        mounted: function() {
            if (this.$cookie.get('gdpr') == 'agreed') {
                return;
            }

            setTimeout(() => {
                this.visible = true;
            }, 500);
        }
    }
</script>