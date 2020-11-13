<template>
  <div :id="_id" class="slider" :style="sliderStyle">
        <div class="slider-track"></div>
        <div class="slider-track-coloring" :style="sliderTrackColoringStyle"></div>
        <div id="left-handle" class="handle" :style="leftHandleStyle" 
            v-on:mousedown="leftHandleMouseDown(false, $event)"
            v-on:touchstart="leftHandleMouseDown(true, $event)">
        </div>
        <div id="right-handle" class="handle" :style="rightHandleStyle"
            v-on:mousedown="rightHandleMouseDown(false, $event)"
            v-on:touchstart="rightHandleMouseDown(true, $event)">
        </div>
  </div>
</template>

<script>
    export default {
        props: {
            _id: String,
            _minimum: Number,
            _maximum: Number,
            _left: Number,
            _right: Number,
        },
        data: function() {
            return {
                sliderStyle: {
                    width: '100%',
                },
                sliderTrackColoringStyle: {
                    left: '0px',
                    width: '0px',
                },
                leftHandleStyle: {
                    left: '0px',
                },
                leftHandle: {
                    mouseStartPosition: -1,
                    leftPositionBeforeMove: -1,
                },
                rightHandleStyle: {
                    left: '',
                },
                rightHandle: {
                    mouseStartPosition: -1,
                    leftPositionBeforeMove: -1,
                },
                sliderWidth: 0,
                handleSize: 20,
                values: {
                    left: this.$props._minimum,
                    right: this.$props._maximum,
                }
            };
        },
        methods: {
            leftHandleMouseDown: function(touch = false, event) {
                this.leftHandle.mouseStartPosition = event.clientX;
                if (touch) {
                    this.leftHandle.mouseStartPosition =  event.changedTouches[0].clientX;
                }
                this.leftHandle.leftPositionBeforeMove = parseInt(this.leftHandleStyle.left);
            },

            rightHandleMouseDown: function(touch = false, event) {
                this.rightHandle.mouseStartPosition = event.clientX;
                if (touch) {
                    this.rightHandle.mouseStartPosition =  event.changedTouches[0].clientX;
                }
                this.rightHandle.leftPositionBeforeMove = parseInt(this.rightHandleStyle.left);
            },
            mouseMove: function(touch = false, event) {
                // update left handle
                if (this.leftHandle.mouseStartPosition !== -1) {
                    var difference = this.leftHandle.mouseStartPosition - event.clientX;
                    if (touch) {
                        var difference = this.leftHandle.mouseStartPosition - event.changedTouches[0].clientX;
                    }

                    var newValue = this.leftHandle.leftPositionBeforeMove - difference;

                    if (newValue > parseInt(this.rightHandleStyle.left) - this.handleSize) {
                        newValue = parseInt(this.rightHandleStyle.left) - this.handleSize;
                    }

                    if (newValue < 0) {
                        newValue = 0;
                    }

                    this.leftHandleStyle.left = newValue + 'px';
                    this.updateValues();
                }

                // update right handle
                if (this.rightHandle.mouseStartPosition !== -1) {
                    var difference = this.rightHandle.mouseStartPosition - event.clientX;
                    if (touch) {
                        var difference = this.rightHandle.mouseStartPosition - event.changedTouches[0].clientX;
                    }

                    var newValue = this.rightHandle.leftPositionBeforeMove - difference;

                    if (newValue > document.getElementById(this.$props._id).offsetWidth - this.handleSize) {
                        newValue = document.getElementById(this.$props._id).offsetWidth - this.handleSize;
                    }

                    if (newValue < parseInt(this.leftHandleStyle.left) + this.handleSize) {
                        newValue = parseInt(this.leftHandleStyle.left) + this.handleSize;
                    }

                    this.rightHandleStyle.left = newValue + 'px';
                    this.updateValues();
                }

                // update track color
                var leftPosition = parseInt(this.leftHandleStyle.left);
                var rightPosition = parseInt(this.rightHandleStyle.left);
                this.sliderTrackColoringStyle.left = leftPosition + this.handleSize / 2 + 'px';
                this.sliderTrackColoringStyle.width = (rightPosition - leftPosition) + 'px';
            },
            mouseUp: function() {
                this.leftHandle.mouseStartPosition = -1;
                this.leftHandle.leftPositionBeforeMove = -1;

                this.rightHandle.mouseStartPosition = -1;
                this.rightHandle.leftPotionBeforeMove = -1;
            },
            resize: function(event) {
                var difference = document.getElementById(this.$props._id).offsetWidth / this.sliderWidth;

                // reposition left handle
                var newValue = parseInt(this.leftHandleStyle.left) * difference;
                if (newValue > parseInt(this.rightHandleStyle.left) - 10) {
                    newValue = parseInt(this.rightHandleStyle.left) - 10;
                }

                if (newValue < 0) {
                    newValue = 0;
                }

                this.leftHandleStyle.left = newValue + 'px';
                if (this.leftHandleStyle.left !== 0) {
                    this.leftHandleStyle.left = newValue + 'px';
                }

                // reposition right handle
                newValue = parseInt(this.rightHandleStyle.left) * difference;

                if (newValue < parseInt(this.leftHandleStyle.left) + this.handleSize) {
                    newValue = parseInt(this.leftHandleStyle.left) + this.handleSize;
                }

                if (newValue > document.getElementById(this.$props._id).offsetWidth - this.handleSize ||
                    this.rightHandleStyle.left == (this.sliderWidth - this.handleSize) + 'px') {

                    newValue = document.getElementById(this.$props._id).offsetWidth - this.handleSize;
                }

                this.rightHandleStyle.left = newValue + 'px';
                // update slider width
                this.sliderWidth = document.getElementById(this.$props._id).offsetWidth;
                
                // update track coloring
                var leftPosition = parseInt(this.leftHandleStyle.left);
                var rightPosition = parseInt(this.rightHandleStyle.left);
                this.sliderTrackColoringStyle.left = leftPosition + this.handleSize / 2  + 'px';
                this.sliderTrackColoringStyle.width = (rightPosition - leftPosition) + 'px';
            },
            updateValues: function(emit = true) {
                // get handles percentages from the slider
                var rightPercentage = parseInt(this.rightHandleStyle.left) / (this.sliderWidth - this.handleSize);
                if (parseInt(this.leftHandleStyle.left) == 0) {
                    var leftPercentage = 0;
                } else {
                    var leftPercentage = parseInt(this.leftHandleStyle.left) / (this.sliderWidth - this.handleSize);
                }

                // convert percentages into values between minimum and maximum
                this.values.left = Math.round((this.$props._maximum - this.$props._minimum) * leftPercentage + this.$props._minimum);
                this.values.right = Math.round((this.$props._maximum - this.$props._minimum) * rightPercentage + this.$props._minimum);
                
                if (emit) {
                    this.$emit('input', {
                        left: this.values.left,
                        right: this.values.right,
                    });
                }
            },
        },
        mounted: function() {
            window.addEventListener('load', () => {
                document.addEventListener('mousemove', this.mouseMove.bind(this, false));
                document.addEventListener('touchmove', this.mouseMove.bind(this, true), {passive: false});
                document.addEventListener('mouseup', this.mouseUp.bind(this, false));
                document.addEventListener('touchend', this.mouseUp.bind(this, true), {passive: false});
                window.addEventListener('resize', this.resize.bind(this));

                this.sliderWidth = document.getElementById(this.$props._id).offsetWidth;

                // set initial position of right button
                this.rightHandleStyle.left = this.sliderWidth - this.handleSize + 'px';
                while (this.values.right > this.$props._right) {
                    this.rightHandleStyle.left = (parseInt(this.rightHandleStyle.left) - 1) + 'px';
                    this.updateValues(false);
                }

                this.leftHandleStyle.left = '0px';
                while (this.values.left < this.$props._left) {
                    this.leftHandleStyle.left = (parseInt(this.leftHandleStyle.left) + 1) + 'px';
                    this.updateValues(false);
                }

                this.$emit('input', {
                    left: this.$props._left,
                    right: this.$props._right,
                });
                
                // update track coloring
                var leftPosition = parseInt(this.leftHandleStyle.left);
                var rightPosition = parseInt(this.rightHandleStyle.left);
                this.sliderTrackColoringStyle.left = leftPosition + this.handleSize / 2  + 'px';
                this.sliderTrackColoringStyle.width = (rightPosition - leftPosition) + 'px';
            });
        }
    }
</script>