<template>
    <div class="image-slide">
        <img :src="image.src" v-for="(image, index) in images" :key="index" v-bind:style="{left: image.left}">
        <div id="image-circles">
            <div class="image-circle" v-for="(image, index) in images" :key="index" v-bind:class="{selected: (index == currentIndex)}" v-on:click="slideTo(index)"></div>
        </div>
        <div id="image-slide-left-arrow"><i class="fa fa-chevron-left" v-on:click="slideTo(currentIndex - 1)"></i></div>
        <div id="image-slide-right-arrow"><i class="fa fa-chevron-right" v-on:click="slideTo(currentIndex + 1)"></i></div>
    </div>
</template>

<script>
    export default {
        props: {
            _images: Array,
        },
        data: function () {
            return {
                images: [],
                currentIndex: 0,
                moving: false,
                speed: 4,
                autoMoveSpeed: 5000,
                autoMoveTimer: null,
            };
        },
        methods: {
            slide: function(slideDirection = -1, counter = 100) {
                if (counter == 0) {
                    return;
                }

                for (var j = 0; j < this.speed; j ++) {
                    for (var i = 0; i < this.images.length; i++) {
                        var currentLeft = parseInt(this.images[i].left);
                        this.images[i].left = (currentLeft + slideDirection) + '%';
                    }

                    counter --;

                    if (counter % 100 == 0) {
                        break;
                    }
                }

                if (counter > 0) {
                    setTimeout(() => {
                        this.slide(slideDirection, counter);
                    }, 10 / (1 + parseInt(counter / 100)));
                } else {
                    this.moving = false;
                }
            },
            slideTo(index) {
                if (index == this.currentIndex || this.moving || index < 0 || index > this.images.length - 1) {
                    return;
                }

                window.clearTimeout(this.autoMoveTimer);
                this.autoMoveTimer = window.setTimeout(this.autoMove, this.autoMoveSpeed);

                var slideDirection = -1;
                if (this.currentIndex > index) {
                    slideDirection = 1;
                }

                var counter = index-this.currentIndex;
                if (counter < 0) {
                    counter *= -1;
                }

                this.slide(slideDirection, counter * 100);
                this.currentIndex = index;
                this.moving = true;
            },
            autoMove() {
                var nextIndex = this.currentIndex + 1;
                if (nextIndex > this.images.length - 1) {
                    nextIndex = 0;
                }

                this.slideTo(nextIndex);
            }
        },

        mounted: function() {
            for (var i = 0; i < this.$props._images.length; i++) {
                this.images.push({
                    src: this.$props._images[i],
                    left: (i*100) + '%',
                });
            }

            this.autoMoveTimer = window.setTimeout(this.autoMove, this.autoMoveSpeed);
        }
    }
</script>