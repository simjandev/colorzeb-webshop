<template>
    <div id="filters" class="col-sm-12 col-md-4 col-lg-3 col-xl-2">
            <input id="filter-text" type="text" class="form-control blue" placeholder="keresés" v-model="text">
            
            <div class="filter-label">
                <b>Ár</b>
                <hr>
            </div>
            <double-slider-component 
                _id="filter-price"
                v-model="price"
                :_minimum="_minimumPriceLimit"
                :_maximum="_maximumPriceLimit"
                :_left="_currentMinimumPrice"
                :_right="_currentMaximumPrice">
            </double-slider-component>
            <div id="filter-price-box">
                <input id="filter-min-price" type="number" class="form-control blue" v-model="price.left">
                <div id="filter-price-divider">-</div>
                <input id="filter-max-price" type="number" class="form-control blue" v-model="price.right">
            </div>

            <div class="filter-label">
                <b>Kategória</b>
                <hr>
            </div>
            <div id="filter-categories">
                <div class="form-check filter-box">
                    <input class="form-check-input discount-tag" type="checkbox" id="discount-filter"
                        v-model="discountFilter">
                    <label class="form-check-label" for="discount-filter">Akciós termékek</label>
                </div>
                <div class="form-check filter-box" v-for="(category, index) in categories" :key="index">
                    <input class="form-check-input" type="checkbox" 
                        :id="'category' + index"
                        v-model="category.checked">
                    <label class="form-check-label" :for="'category' + index">{{ category.name }}</label>
                </div>
            </div>

            <div v-for="(filter, index) in filters" :key="index">
                <div class="filter-label">
                    <b>{{ index }}</b>
                    <hr>
                </div>
                <div class="filter">
                    <div class="form-check filter-box" v-for="(item, index2) in filter" :key="index2">
                        <input class="form-check-input" type="checkbox" 
                            :id="'filter' + index + '.' + index2"
                            v-model="item.checked">
                        <label class="form-check-label" :for="'filter' + index + '.' + index2">{{ item.value }}</label>
                    </div>
                </div>
            </div>

            <button id="filter-button" class="button blue" v-on:click="filter"><i class="fa fa-search"></i> Keresés</button>
        </div>
</template>

<script>
    export default {
        props: {
            _categories: Array,
            _filters: Object,
            _discountFilter: Boolean,
            _minimumPriceLimit: Number,
            _maximumPriceLimit: Number,
            _currentMinimumPrice: Number,
            _currentMaximumPrice: Number,
            _text: String,
        },

        data: function () {
            return {
                price: {
                    left: 0,
                    right: 0,
                },
                text: this.$props._text,
                categories: this.$props._categories,
                filters: this.$props._filters,
                discountFilter: this.$props._discountFilter,
            };
        },

        mounted: function () {
        },

        methods: {
            filter: function() {
                var data = {};
                
                // select checked categories
                data.categories = [];
                for (var i = 0; i < this.categories.length; i++) {
                    if (this.categories[i].checked) {
                        data.categories.push(this.categories[i].id);
                    }
                }

                // select checked parameters
                data.filters = {};
                for (var name in this.filters) {
                    if (!this.filters.hasOwnProperty(name)) {
                        continue;
                    }

                    var options = [];
                    for (var i = 0; i < this.filters[name].length; i++) {
                        if (this.filters[name][i].checked) {
                            options.push(this.filters[name][i].value);
                        }
                    }

                    if (options.length) {
                        data.filters[name] = options;
                    }
                }

                // redirect to url
                var link = window.location.origin + '/products';
                link += '/' + this.price.left + '/' + this.price.right;
                if (this.text == '') {
                    link += '/*';
                } else {
                    link += '/' + encodeURI(this.text);
                }
                link += '/' + encodeURI(JSON.stringify(data.categories));
                link += '/' + encodeURI(JSON.stringify(data.filters));
                link += '/' + (this.discountFilter ? '1' : '0');
                link += '/' + 1;

                window.location = link;
            },
        }
    }
</script>