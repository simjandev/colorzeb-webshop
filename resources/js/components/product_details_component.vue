<template>
    <div id="product-details-box">
        <div id="product-images-box">
            <div id="product-big-image-box">
                <img id="product-big-image" :src="currentImage">
            </div>
            <div id="product-small-image-box">
                <div id="product-image-left-arrow-box">
                    <button id="product-image-left-arrow" class="button blue" v-on:click="leftArrowClick" :disabled="!leftArrowEnabled">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>
                <div id="product-small-image-slide">
                    <div id="product-small-image-slide-overflow">
                        <div class="product-small-image" v-for="(image, index) in images" :key="index" v-if="image.visible">
                            <img :src="'/product-image/' + image.name + '/' + image.color + '/' + image.extraImage.file" v-on:click="selectImage('/product-image/' + image.name + '/' + image.color + '/' + image.extraImage.file)">
                        </div>
                    </div>
                </div>
                <div id="product-image-right-arrow-box">
                    <button id="product-image-right-arrow" class="button blue" v-on:click="rightArrowClick" :disabled="!rightArrowEnabled">
                        <i class="fa fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="product-parameters-box">
            <div id="product-category">
                <a href="#">{{ _categoryName }}</a>
            </div>
            <div id="product-name">{{ _name }}</div>
            <div id="product-shipping"><i class="fa fa-truck"></i> Szállítás: {{ shippingPrice }}Ft, 3-5 munkanap</div>
            <div id="product-custom-parameters">
                <div id="product-custom-parameter" v-for="(customParameter, index) in customParameters" :key="index" v-if="customParameter.type.length">
                        <div class="product-custom-parameter-name">{{ customParameter.name }}:</div>
                        <div class="product-custom-parameter-value">
                            <select class="form-control blue" 
                                v-if="customParameter.type == 'select'" v-model="selectedParameters[customParameter.index]" v-on:change="customParameterChanged">
                                    <option v-for="(option, index2) in customParameter.options" 
                                        :key="index2" :value="option.value"> 
                                        {{ option.value }}
                                    </option>
                            </select>
                            <input v-if="customParameter.type == 'text'" v-model="selectedParameters[customParameter.index]" type="text" class="form-control blue" :placeholder="customParameter.name">
                        </div>
                </div>
            </div>
            <div id="product-custom-description" v-html="_description"></div>
            <div id="product-price-box">
                    <div id="product-price" v-if="discountPrice">{{ discountPrice }} Ft</div>
                    <div id="product-old-price" v-if="discountPrice">{{ price }} Ft</div>
                    <div id="product-price-spacing" v-if="!discountPrice">&nbsp;</div>
                    <div id="product-price" v-if="!discountPrice">{{ price }} Ft</div>
            </div>
            <a :href="'/admin/edit-product/' + _id" v-if="_isAdmin">
                <button class="edit-product-button button blue" title="Szerkesztés"><i class="fa fa-edit"></i></button>
            </a>
            <add-to-cart-button-component :_id="_id" :_display-text="true" :_parameters="selectedParameters" ></add-to-cart-button-component>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            _imageList: Array,
            _mainImage: Object,
            _id: Number,
            _categoryId: Number,
            _categoryName: String,
            _name: String,
            _description: String,
            _price: Number,
            _discountPrice: Number,
            _discount: Number,
            _parameterSettings: Array,
            _customParameters: Array,
            _isAdmin: Boolean,
        },

        data: function () {
            return {
                images: this.$props._imageList,
                currentImage: '/product-image/' + this.$props._mainImage.name + '/' + this.$props._mainImage.color + '/' + this.$props._mainImage.extraImage,
                firstImageIndex: 0,
                leftArrowEnabled: false,
                rightArrowEnabled: false,
                parameterSettings: this.$props._parameterSettings,
                customParameters: this.$props._customParameters,
                price: this.$props._price,
                discountPrice: this.$props._discountPrice,
                discount: this.$props._discount,
                shippingPrice: this.$props._parameterSettings[0].shippingPrice,
                selectedParameters: [
                    this.$props._parameterSettings[0].param1,
                    this.$props._parameterSettings[0].param2,
                    this.$props._parameterSettings[0].param3,
                ],
            };
        },

        mounted: function () {
            this.updateArrowButtonStates();
            window.addEventListener('resize', this.updateArrowButtonStates.bind(this));
        },

        methods: {
            customParameterChanged: function() {

                for (var i = 1; i < this.parameterSettings.length; i++) {
                    if (this.parameterSettings[i].param1 !== '' && this.parameterSettings[i].param1 !== this.selectedParameters[0] && 
                        this.customParameters[0].type == 'select') {
                        continue;
                    }

                    if (this.parameterSettings[i].param2 !== '' && this.parameterSettings[i].param2 !== this.selectedParameters[1] && 
                        this.customParameters[1].type == 'select') {
                        continue;
                    }

                    if (this.parameterSettings[i].param3 !== '' && this.parameterSettings[i].param3 !== this.selectedParameters[2] && 
                        this.customParameters[2].type == 'select') {
                        continue;
                    }

                    // change image if it's set in parameter setting
                    if (this.parameterSettings[i].image) {
                        this.currentImage = '/product-image/' + this.parameterSettings[i].image.name + '/' + this.parameterSettings[i].image.color + '/' + this.parameterSettings[i].image.extraImage.file;
                    }
                    
                    // change price if it's set in parameter setting
                    if (this.parameterSettings[i].price) {
                        this.price = this.parameterSettings[i].price;
                        if (this.discount) {
                            this.discountPrice = Math.round(this.parameterSettings[i].price * (1 - this.discount / 100));
                        }
                    }

                    // change shipping price if it's set in parameter setting
                    if (this.parameterSettings[i].shippingPrice) {
                        this.shippingPrice = this.parameterSettings[i].shippingPrice;
                    }
                }
            },
            leftArrowClick: function () {
                var lastImageIndex = 0;
                for (var i = 0; i < this.images.length - 1; i++) {
                    if (!this.images[i].visible) {
                        lastImageIndex = i;
                        break;
                    }
                }

                this.images[lastImageIndex].visible = true;
                this.firstImageIndex --;
                this.updateArrowButtonStates();
            },
            
            rightArrowClick: function () {
                this.images[this.firstImageIndex].visible = false;
                this.firstImageIndex ++;
                
                this.updateArrowButtonStates();
            },

            selectImage: function(image) {
                this.currentImage = image;
            },

            updateArrowButtonStates() {
                this.leftArrowEnabled = this.firstImageIndex > 0;

                // calculate visible images count
                var boxWidth = document.getElementById('product-small-image-slide').offsetWidth - 2;
                var imageWidth = document.getElementsByClassName('product-small-image')[0].offsetWidth + 4;               
                console.log(boxWidth + ', ' + imageWidth);
                var visibleImagesCount = Math.floor(boxWidth / imageWidth);

                this.rightArrowEnabled = this.firstImageIndex < this.images.length - visibleImagesCount;
            }
        }
    }
</script>