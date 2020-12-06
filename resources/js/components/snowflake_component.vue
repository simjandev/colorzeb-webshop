<template>
    <div id="snowflake-box">
        <img src="/images/snowflake.png" class="snowflake"
            v-for="snowflake in snowflakes" :key="snowflake.id"
            v-bind:style="{left: (snowflake.x + 'px'), top: snowflake.y + 'px'}">
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                snowflakes: [],
                speed: 0.1,
                snowflakeCount: 25,
            }
        },
        
        mounted: function() {
            for (var i = 0; i < this.snowflakeCount; i++) {
                this.snowflakes.push({
                    id: i,
                    x: Math.floor(Math.random() * Math.floor(window.innerWidth)),
                    y: -20 - Math.floor(Math.random() * Math.floor(60)),
                    direction: Math.floor(Math.random() * Math.floor(1)) ? '<' : '>',
                });

            }

            setInterval( function() {
                for (var i = 0; i < this.snowflakes.length; i++) {
                    // snow fall
                    this.snowflakes[i].y += this.speed;

                    // random direction change
                    var directionChange = Math.floor(Math.random() * Math.floor(500));
                    if (!directionChange) {
                        if (this.snowflakes[i].direction == '>') {
                            this.snowflakes[i].direction = '<';
                        } else {
                            this.snowflakes[i].direction = '>';
                        }
                    }

                    // snow wind
                    if (this.snowflakes[i].direction == '>') {
                        this.snowflakes[i].x += this.speed;
                    } else {
                        this.snowflakes[i].x -= this.speed;
                    }

                    // reset flake
                    if (this.snowflakes[i].y > 60) {
                        this.snowflakes[i].y = -20 - Math.floor(Math.random() * Math.floor(20));
                        this.snowflakes[i].x = Math.floor(Math.random() * Math.floor(window.innerWidth));
                    }
                }
            }.bind(this), 10);
        },
    }
</script>