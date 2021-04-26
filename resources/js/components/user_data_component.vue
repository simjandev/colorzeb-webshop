<template>
    <div id="user-data" class="col-sm-12 align-center">
        <form v-on:submit.prevent="confirmShippingData">
            <h5>Szállítási adatok</h5>
            <hr>
            
            <div class="form-group row">
                <label for="shipping-name" class="col-md-3 col-form-label text-md-right">Név:</label>
                <div class="col-md-9">
                    <input id="shipping-name" type="text" class="form-control blue" v-model="shippingName" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="shipping-phone" class="col-md-3 col-form-label text-md-right">Telefonszám:</label>
                <div class="col-md-9">
                    <input id="shipping-phone" type="text" class="form-control blue" v-model="shippingPhone" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="shipping-zip-code" class="col-md-3 col-form-label text-md-right">Cím:</label>
                <div class="col-md-3">
                    <input id="shipping-zip-code" type="text" class="form-control blue" placeholder="irányító szám" v-model="shippingZip" required>
                </div>
                <div class="col-md-3">
                    <input id="shipping-city-code" type="text" class="form-control blue" placeholder="város" v-model="shippingCity" required>
                </div>
                <div class="col-md-3">
                    <input id="shipping-address-code" type="text" class="form-control blue" placeholder="utca, házszám" v-model="shippingAddress" required>
                </div>
            </div>

            <h5 id="billing-data-label">Számlázási adatok</h5>
            <hr>

            <div class="form-group row">
                <label id="billing-checkbox-label" class="form-check-label col-md-3 col-form-label text-md-right">Megegyezik a szállítási adatokkal:</label>
                <div id="billing-checkbox" class="form-check col-md-9">
                    <input id="same-as-shipping" class="form-check-input" type="checkbox" v-model="sameAsShipping" v-on:change="billingSameAsShippingChanged">
                    <label for="same-as-shipping" class="form-check-label"></label>
                </div>
            </div>

            <div class="form-group row">
                <label for="billing-name" class="col-md-3 col-form-label text-md-right">Név:</label>
                <div class="col-md-9">
                    <input id="billing-name" type="text" class="form-control blue" v-model="billingName" required>
                </div>
            </div>

            <div class="form-group row" v-if="company == 'company'">
                <label for="billing-tax-number" class="col-md-3 col-form-label text-md-right">Adószám:</label>
                <div class="col-md-9">
                    <input id="billing-tax-number" type="text" class="form-control blue" v-model="billingTaxNumber" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="billing-zip-code" class="col-md-3 col-form-label text-md-right">Cím:</label>
                <div class="col-md-3">
                    <input id="billing-zip-code" type="text" class="form-control blue" placeholder="irányító szám" v-model="billingZip" required>
                </div>
                <div class="col-md-3">
                    <input id="billing-city-code" type="text" class="form-control blue" placeholder="város" v-model="billingCity" required>
                </div>
                <div class="col-md-3">
                    <input id="billing-address-code" type="text" class="form-control blue" placeholder="utca, házszám" v-model="billingAddress" required>
                </div>
            </div>
            <div class="form-group row">
                <div for="billing-address-code" class="offset-md-3">
                    <button id="confirm-button" class="button blue">Mentés</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                shippingName: this.$props._shippingName,
                shippingPhone: this.$props._shippingPhone,
                shippingZip: this.$props._shippingZip,
                shippingCity: this.$props._shippingCity,
                shippingAddress: this.$props._shippingAddress,

                billingName: this.$props._billingName,
                billingTaxNumber: this.$props._billingTaxNumber,
                billingZip: this.$props._billingZip,
                billingCity: this.$props._billingCity,
                billingAddress: this.$props._billingAddress,                

                sameAsShipping: false,
                company: '',
            };
        },
        props: {
            _shippingName: {
                type: String,
                default: '',
            },
            _shippingPhone: {
                type: String,
                default: '',
            },
            _shippingZip: {
                type: String,
                default: '',
            },
            _shippingCity: {
                type: String,
                default: '',
            },
            _shippingAddress: {
                type: String,
                default: '',
            },
            _billingName: {
                type: String,
                default: '',
            },
            _billingTaxNumber: {
                type: String,
                default: '',
            },
            _billingZip: {
                type: String,
                default: '',
            },
            _billingCity: {
                type: String,
                default: '',
            },
            _billingAddress: {
                type: String,
                default: '',
            },
        },
        mounted: function() {
            if (this.$props._billingName == '') {
                this.company = '';
            } else {
                this.company = this.$props._billingTaxNumber == '' ? 'person' : 'company';
            }
        },
        methods: {
            companyChanged: function() {
                if (this.company !== 'company') {
                    this.billingTaxNumber = '';
                }
            },
            billingSameAsShippingChanged: function() {
                if (this.sameAsShipping) {
                    this.billingName = this.shippingName;
                    this.billingZip = this.shippingZip;
                    this.billingCity = this.shippingCity;
                    this.billingAddress = this.shippingAddress;
                } else {
                    this.billingName = '';
                    this.billingZip = '';
                    this.billingCity = '';
                    this.billingAddress = '';
                }
            },
            confirmShippingData: function() {
                var data = {};
                data.email = this.email;
                data.comment = this.comment;

                data.shippingName = this.shippingName;
                data.shippingPhone = this.shippingPhone;
                data.shippingZip = this.shippingZip;
                data.shippingCity = this.shippingCity;
                data.shippingAddress = this.shippingAddress;

                data.billingName = this.billingName;
                data.billingTaxNumber = this.billingTaxNumber;
                data.billingZip = this.billingZip;
                data.billingCity = this.billingCity;
                data.billingAddress = this.billingAddress;

                axios.post('/user/data/save', data).then(response => {
                    if (response.request.responseText == 'success') {
                        window.location = '/user/data';
                    }
                });
            }
        },
    }
</script>