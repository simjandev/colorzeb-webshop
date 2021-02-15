<template>
    <div id="product" class="col-sm-12 col-lg-8 offset-lg-1">
        <div class="alert alert-success" role="alert" v-if="successText.length" v-html="successText"></div>
        <div class="alert alert-danger" role="alert" v-if="alertText.length" v-html="alertText"></div>
        <div id="menu-buttons">
            <button :class="{active: currentMenu == 'details', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('details')">Termék adatok</button>
            <button :class="{active: currentMenu == 'pictures', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('pictures')">Képek</button>
            <button :class="{active: currentMenu == 'parameters', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('parameters')"> Paraméterek</button>
            <button id="save-button" class="button blue" v-on:click="modifyProduct()" :disabled="successText.length > 0 && id == -1">{{ id == -1 ? 'Termék feltöltése' : 'Mentés' }}</button>
            <a :href="'/product/' + _id" v-if="_id !== -1" target="_blank">
                <button id="save-button" class="button blue" title="Megtekintés"><i class="fa fa-eye"></i></button>
            </a>
        </div>
        <hr id="menu-buttons-divider">
        
        <div :style="{display: currentMenu == 'pictures' ? 'block' : 'none'}">
            <h5>Képek</h5>
            <div id="images" class="cols-m-12" v-if="imageNames.length">
                <div class="image-box" v-for="(image, index) in imageNames" :key="index">
                    <img class="image" :src="'/product-image/' + image + '/000000'">
                </div>
            </div>

            <div id="file-upload-box">
                <div class="custom-file">
                    <input id="image-files" type="file" class="custom-file-input" @change="imageSelected" multiple>
                    <label class="custom-file-label" for="image-files">{{ imageFilesLabel }}</label>
                </div>
                <button id="image-upload-button" class="button blue col-sm-2" @click="uploadSelectedImages" :disabled="!selectedUploadImages.length">Feltöltés</button>
            </div>
            <div v-if="imageNames.length">
                <h5>Képek színekhez társítása</h5>
                <table class="table table-bordered" id="image-list">
                    <thead>
                        <tr>
                            <th>Kép</th>
                            <th>Kép választás</th>
                            <th>Szín</th>
                            <th>+ kép</th>
                            <th>Törlés</th>
                        </tr>
                    </thead>
                        <transition-group name="disappear" tag="tbody">
                            <tr v-for="image in imageColorPairs" :key="image.id">
                                <td>
                                    <a target="_blank" :href="'/product-image/' + image.name + '/' + image.color + '/' + image.extraImage.file">
                                        <img v-if="image.name" :src="'/product-image/' + image.name + '/' + image.color + '/' + image.extraImage.file">
                                    </a>
                                </td>
                                <td>
                                    <select class="form-control blue" v-model="image.name" v-on:change="imageColorPairsChanged">
                                        <option value="">Válassz képet</option>
                                        <option v-for="(imageName, imageNameIndex) in imageNames" :key="imageNameIndex" :value="imageName">{{ imageName }}</option>
                                    </select>
                                </td>
                                <td><input class="form-control blue" type="text" v-model="image.color" placeholder="szín" v-on:change="imageColorPairsChanged"></td>
                                <td>
                                    <select class="form-control blue" v-model="image.extraImage" v-on:change="imageColorPairsChanged">
                                        <option v-for="(currentExtraImage, index) in extraImageList" :key="index" :value="currentExtraImage">{{ currentExtraImage.name }}</option>
                                    </select>
                                </td>
                                <td><button class="button red product-image-delete-button" v-on:click="removeImageColorPair(image.id)">X</button></td>
                            </tr>
                        </transition-group>
                </table>
                <button class="button blue" v-on:click="addImageColorPair">Új elem felvétele</button>
            </div>
        </div>
        
        <div :style="{display: currentMenu == 'parameters' ? 'block' : 'none'}">
            <h5>Egyedi paraméterek</h5>
            <table class="table table-bordered" id="custom-parameters">
                <thead>
                    <tr>
                        <th>Típus</th>
                        <th>Paraméter neve</th>
                        <th>Értékek</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customParameter, index) in customParameters" :key="index">
                        <td>
                            <select class="form-control blue" v-model="customParameter.type" v-on:change="customParameterTypeChanged">
                                <option value="">Nincs / rejtve</option>
                                <option value="select">Kiválasztós</option>
                                <option value="text">Egyedi szöveg</option>
                            </select>
                        </td>
                        <td><input class="form-control blue" type="text" v-model="customParameter.name" v-if="customParameter.type != ''" placeholder="paraméter neve"></td>
                        <td><input class="form-control blue" type="text" v-model="customParameter.values" v-if="customParameter.type == 'select'" v-on:change="customParameterValueChanged(customParameter.index)" placeholder="értékek"></td>
                    </tr>
                </tbody>
            </table>
            
            <br><br>
            <h5>Árak és képek beállítása paraméterekhez</h5>
            <div class="alert alert-warning">
                Az első sor tartalmazza az alapméretezett árat, képet és az egyedi paraméter értékeket. A termék ezekkel 
                az értékekkel jelenik meg a keresőben, a felhasználó a termék megtekintése után tud más értékeket kiválasztani.
            </div>
            <table class="table table-bordered" id="parameter-settings">
                <thead>
                    <tr>
                        <th class="c-image">Kép</th>
                        <th class="c-param1" v-if="customParameters[0].type == 'select'">{{ customParameters[0].name }}</th>
                        <th class="c-param2" v-if="customParameters[1].type == 'select'">{{ customParameters[1].name }}</th>
                        <th class="c-param3" v-if="customParameters[2].type == 'select'">{{ customParameters[2].name }}</th>
                        <th class="c-price">Ár</th>
                        <th class="c-shipping-price">Szállítás</th>
                        <th class="c-picture">Kép</th>
                        <th class="c-delete">Törlés</th>
                    </tr>
                </thead>
                <transition-group name="disappear" tag="tbody">
                    <tr v-for="parameterSetting in parameterSettings" :key="parameterSetting.id">
                        <td class="c-image">
                            <img :src="'/product-image/' + parameterSetting.image.name + '/' + parameterSetting.image.color + '/' + parameterSetting.image.extraImage.file" alt="" v-if="parameterSetting.image">
                        </td>
                        <td class="c-param1" v-if="customParameters[0].type == 'select'">
                            <select class="form-control blue" v-model="parameterSetting.param1">
                                <option value="" v-if="parameterSettingIndex">Bármelyik</option>
                                <option v-for="(value, index) in customParameters[0].values.split(',')" :key="index" :value="value">{{ value }}</option>
                            </select>
                        </td>
                        <td class="c-param2" v-if="customParameters[1].type == 'select'">
                            <select class="form-control blue"  v-model="parameterSetting.param2">
                                <option value="" v-if="parameterSettingIndex">Bármelyik</option>
                                <option v-for="(value, index) in customParameters[1].values.split(',')" :key="index" :value="value">{{ value }}</option>
                            </select>
                        </td>
                        <td class="c-param3" v-if="customParameters[2].type == 'select'">
                            <select class="form-control blue"  v-model="parameterSetting.param3">
                                <option value="" v-if="parameterSettingIndex">Bármelyik</option>
                                <option v-for="(value, index) in customParameters[2].values.split(',')" :key="index" :value="value">{{ value }}</option>
                            </select>
                        </td>
                        <td class="c-price">
                            <input class="form-control blue" type="number" v-model.number="parameterSetting.price">
                        </td>
                        <td class="c-shipping-price">
                            <input class="form-control blue" type="number" v-model.number="parameterSetting.shippingPrice">
                        </td>
                        <td class="c-picture">
                            <select class="form-control blue"  v-model="parameterSetting.image">
                                <option value="" v-if="parameterSettingIndex">Válassz képet</option>
                                <option v-for="(image, index) in imageColorPairs" :key="index" :value="{name: image.name, color: image.color, extraImage: image.extraImage}">{{ image.name + ' (' + image.color + ', +kép: ' + image.extraImage.name + ')' }}</option>
                            </select>
                        </td>
                        <td class="c-delete"><button class="button red product-image-delete-button" v-if="parameterSetting.id" v-on:click="removeParametersetting(parameterSetting.id)">X</button></td>
                    </tr>
                </transition-group>
            </table>
            <button class="button blue" v-on:click="addParameterSetting">Új elem felvétele</button>
        </div>

        <form class="form-inline" :style="{display: currentMenu == 'details' ? 'block' : 'none'}">
            <div class="form-group">
                <div class="col-sm-2" for="name">Termék név:</div>
                <input id="name" type="text" class="form-control blue col-sm-10" v-model="name">
            </div>
            
            <div class="form-group">
                <div class="col-sm-2" for="description">Leírás:</div>
                <textarea id="description" class="form-control blue col-sm-10" placeholder="termék leírás" v-model="description"></textarea>
            </div>
            
            <div class="form-group">
                <div class="col-sm-2" for="discount">Kedvezmény %:</div>
                <input id="discount" type="number" class="form-control blue col-sm-10" value="0"  min="0" max="99" v-model.number="discount">
            </div>
            
            <div class="form-group">
                <div class="col-sm-2" for="category">Kategória:</div>
                <select id="category" class="form-control blue col-sm-10" v-model.number="category">
                    <option value="-1">Kategória</option>
                    <option v-for="(category, index) in categories" :key="index" :value="index">{{ category.name }}</option>
                </select>
            </div>
            
            <div id="active-checkbox" class="form-group">
                <div id="active-checkbox-label" class="col-sm-2">Aktív:</div>
                <div class="form-check">
                    <input id="active" class="form-check-input blue" type="checkbox" v-model="active">
                    <label class="form-check-label" for="active"></label>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            _categoryList: Array,
            _id: {
                type: Number,
                default: function() {
                    return -1;
                }
            },
            _name: {
                type: String,
                default: function () {
                    return '';
                },
            },
            _description: {
                type: String,
                default: function () {
                    return '';
                },
            },
            _discount: {
                type: Number,
                default: function () {
                    return 0;
                },
            },
            _active: {
                type: Boolean,
                default: function () {
                    return true;
                },
            },
            _categoryId: {
                type: Number,
                default: function () {
                    return -1;
                },
            },
            _imageColorPairs: {
                type: Array,
                default: function () {
                    return [];
                },
            },
            _imageNames: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            _customParameters: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            _parameterSettings: {
                type: Array,
                default: function () {
                    return [
                        {
                            id: 0,
                            price: 0,
                            shippingPrice: 0,
                            image: '',
                            param1: '',
                            param2: '',
                            param3: '',
                        },
                    ];
                }
            },
        },
        data: function() {
            return {
                currentMenu: 'details',
                alertText: '',
                successText: '',
                extraImageList: [
                    {
                        name: 'nincs',
                        file: '',
                    },
                    {
                        name: 'Villanykapcsoló',
                        file: 'light-switch.png',
                    },
                ],
                selectedUploadImages: [],
                imageFilesLabel: 'Kép kiválasztása',
                categories: this.$props._categoryList,

                id: this.$props._id,
                name: this.$props._name,
                description: this.$props._description,
                discount: this.$props._discount,
                active: this.$props._active,
                category: -1,
                imageNames: this.$props._imageNames,
                imageColorPairs: this.$props._imageColorPairs,
                imageColorPairIndex: this.$props._imageColorPairs.length,
                customParameters: [
                    {
                        type: '',
                        name: '',
                        values: '',
                        index: 0,
                    },
                    {
                        type: '',
                        name: '',
                        values: '',
                        index: 1,
                    },
                    {
                        type: '',
                        name: '',
                        values: '',
                        index: 2,
                    },
                ],
                parameterSettings: this.$props._parameterSettings,
                parameterSettingIndex: 1,
                mainImage: {},
            }
        },
        mounted: function() {
            // only need to set initial values if
            // parameters are given
            if (this.$props.name == '') {
                return;
            }

            // init category
            for (var i = 0; i < this.categories.length; i++) {
                if (this.categories[i].id == this.$props._categoryId) {
                    this.category = i;
                    break;
                }
            }

            // init custom parameters
            for (var i = 0; i < this.$props._customParameters.length; i++) {
                this.customParameters[i].type = this.$props._customParameters[i].type;
                this.customParameters[i].name = this.$props._customParameters[i].name;
                
                
                this.customParameters[i].values = [];
                for (var j = 0; j < this.$props._customParameters[i].options.length; j ++) {
                    this.customParameters[i].values.push(this.$props._customParameters[i].options[j].value);
                }

                this.customParameters[i].values = this.customParameters[i].values.join(',');
            }

            // init parameter settings index
            for (var i = 0; i < this.$props._parameterSettings.length; i++) {
                if (this.$props._parameterSettings[i].id > this.parameterSettingIndex) {
                    this.parameterSettingIndex = this.$props._parameterSettings[i].id;
                }
            }

            if (this.parameterSettingIndex > 1) {
                this.parameterSettingIndex ++;
            }
        },
        methods: {
            visibleMenuChanged: function(newMenu) {
                if (this.successText.length && this.id == -1) {
                    return;
                }

                this.currentMenu = newMenu;
            },
            addImageColorPair: function() {
                this.imageColorPairs.push({name: '', color: '000000', extraImage: {name: 'nincs', file: ''}, id: this.imageColorPairIndex});
                this.imageColorPairIndex ++;
            },
            addParameterSetting: function() {
                this.parameterSettings.push({
                    id: this.parameterSettingIndex,
                    param1: '',
                    param2: '',
                    param3: '',
                    image: '',
                    price: 0,
                    shippingPrice: 0,
                });

                this.parameterSettingIndex++
            },
            imageSelected(event) {
                this.selectedUploadImages = [];
                var files = event.target.files;

                for (var i = 0; i < files.length; i++) {
                    if (files[i].type !== 'image/png') {
                        continue;
                    }

                    this.selectedUploadImages.push(files[i]);
                }

                if (this.selectedUploadImages.length) {
                    this.imageFilesLabel = this.selectedUploadImages[0].name;
                    if (this.selectedUploadImages.length > 1) {
                        this.imageFilesLabel += ' (+' + (this.selectedUploadImages.length - 1) + ' másik)';
                    }
                }
            },
            uploadSelectedImages() {
                const fd = new FormData();
                for (var i = 0; i < this.selectedUploadImages.length; i++) {
                    fd.append('images[]', this.selectedUploadImages[i], this.selectedUploadImages[i].name);
                }

                axios.post('/admin/upload-product-images', fd).then(res => {
                    this.imageFilesLabel = 'Kép kiválasztása';
                    this.imageNames = this.imageNames.concat(JSON.parse(res.request.responseText));
                    this.selectedUploadImages = [];
                });
                
                // this makes the change event trigger even if the same file has been selected
                document.getElementById('image-files').value = '';
            },
            removeImageColorPair(id) {
                for (var i = 0; i < this.imageColorPairs.length; i++) {
                    if (this.imageColorPairs[i].id == id) {
                        this.imageColorPairs.splice(i, 1);
                        break;
                    }
                }
            },
            removeParametersetting(id) {
                for (var i = 0; i < this.parameterSettings.length; i++) {
                    if (this.parameterSettings[i].id == id) {
                        this.parameterSettings.splice(i, 1);
                        break;
                    }
                }
            },
            customParameterTypeChanged() {
                if (this.customParameters[0].type !== 'select') {
                    this.parameterSettings[0].param1 = '';
                    this.customParameters[0].values = '';
                }

                if (this.customParameters[1].type !== 'select') {
                    this.parameterSettings[0].param2 = '';
                    this.customParameters[1].values = '';
                }

                if (this.customParameters[2].type !== 'select') {
                    this.parameterSettings[0].param3 = '';
                    this.customParameters[2].values = '';
                }

                if (this.customParameters[0].type == '') {
                    this.customParameters[0].name = '';
                }

                if (this.customParameters[1].type == '') {
                    this.customParameters[1].name = '';
                }

                if (this.customParameters[2].type == '') {
                    this.customParameters[2].name = '';
                }
            },
            customParameterValueChanged(index) {
                for (var i = 0; i < this.parameterSettings.length; i++) {
                    if (this.customParameters[index].values.indexOf(this.parameterSettings[i]['param' + (index + 1)]) == -1) {
                        this.parameterSettings[i]['param' + (index + 1)] = '';
                    }
                }
            },
            imageColorPairsChanged() {
                for (var i = 0; i < this.parameterSettings.length; i++) {
                    this.parameterSettings[i].image = '';
                }
            },
            modifyProduct() {
                this.alertText = '';

                // main image validation
                if (this.parameterSettings[0].image == '' ||
                    this.parameterSettings[0].image.name == '' ||
                    this.parameterSettings[0].image.name == 'undefined') {

                    this.alertText += 'Kötelező alapméretezett képet megadni!';
                }

                // images validation
                for (var i = 0; i < this.imageColorPairs.length; i++) {
                    if (this.imageColorPairs[i].name == '') {
                        if (this.alertText.length) {
                            this.alertText += '<br>';
                        }
                        this.alertText += 'Minden kép/szín párnál kötelező képet választani!';
                        break;
                    }
                }
                
                // price validation
                if (!Number.isInteger(this.parameterSettings[0].price)) {
                    this.alertText += 'Az alapméretezett árnak pozitív egész számnak kell lennie!';
                } else if (this.parameterSettings[0].price < 1) {
                    if (this.alertText.length) {
                        this.alertText += '<br>';
                    }

                    this.alertText += 'Az alapméretezett árnak pozitív egész számnak kell lennie!';
                }

                // name validation
                if (this.name == '') {
                    if (this.alertText.length) {
                        this.alertText += '<br>';
                    }

                    this.alertText += 'Kötelező terméknevet megadni!';
                }

                // discount validation
                if (!Number.isInteger(this.discount)) {
                    if (this.alertText.length) {
                        this.alertText += '<br>';
                    }

                    this.alertText += 'A kedvezménynek 0-99 közötti számnak kell lennie.';
                } else if (this.discount < 0 || this.discount > 99) {
                    if (this.alertText.length) {
                        this.alertText += '<br>';
                    }

                    this.alertText += 'A kedvezménynek 0-99 közötti számnak kell lennie.';
                }

                // shipping price validation
                if (!Number.isInteger(this.parameterSettings[0].shippingPrice)) {
                    if (this.alertText.length) {
                        this.alertText += '<br>';
                    }

                    this.alertText += 'A szállítási díjnak nem negatív egész számnak kell lennie.';
                } else if (this.parameterSettings[0].shippingPrice < 0) {
                    this.alertText += 'A szállítási díjnak nem negatív egész számnak kell lennie.';
                }

                // default parameters validation
                if ((this.customParameters[0].type == 'select' && this.parameterSettings[0].param1 == '') ||
                    (this.customParameters[1].type == 'select' && this.parameterSettings[0].param2 == '') ||
                    (this.customParameters[2].type == 'select' && this.parameterSettings[0].param3 == '')) {
                        if (this.alertText.length) {
                            this.alertText += '<br>';
                        }

                        this.alertText += 'Kötelező alapméretezett paramétereket megadni, ha a termék tartalmaz kiválasztós egyedi paramétereket.';
                }

                // default parameters validation
                if ((this.customParameters[0].type !== '' && this.customParameters[0].name == '') ||
                    (this.customParameters[1].type !== '' && this.customParameters[1].name == '') ||
                    (this.customParameters[2].type !== '' && this.customParameters[2].name == '')) {
                        if (this.alertText.length) {
                            this.alertText += '<br>';
                        }

                        this.alertText += 'Kötelező paraméter nevet megadni.';
                }

                // display errors
                if (this.alertText.length) {
                    return;
                }

                // create post data object
                var product = {};
                product.id = this.id;
                product.name = this.name;
                product.description = this.description;
                product.images = JSON.stringify(this.imageColorPairs);
                product.mainImage = this.parameterSettings[0].image;
                product.price = this.parameterSettings[0].price;
                product.discount = this.discount;
                product.discountPrice = product.discount ? Math.round(product.price * (1 - product.discount / 100)) : 0;
                product.shippingPrice = this.shippingPrice;
                product.categoryId = this.category == -1 ? null : this.categories[this.category].id;
                product.categoryName = this.category == -1 ? '' : this.categories[this.category].name;
                product.customParameters = JSON.stringify(this.customParameters);
                product.parameterSettings = JSON.stringify(this.parameterSettings);
                product.active = this.active;


                axios.post('/admin/modify-product', product).then(res => {
                    if (this.id == -1) {
                        this.currentMenu = '';
                    }

                    if (this.successText.length) {
                        this.successText += '<br>';
                    }
                    this.successText += res.request.responseText;
                });
            }
        },
    }
</script>
