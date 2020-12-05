<template>
    <li class="nav-item search">
        <button id="search-button" class="button blue" v-on:click="search"><i class="fa fa-search"></i></button>
        <input id="search-input" class="form-control" type="text" placeholder="keresés" v-model="searchText" v-on:keyup.enter="search">
    </li>
</template>

<script>
    export default {
        data: function() {
            return {
                searchText: '',
            }
        },
        props: {

        },
        methods: {
            search: function() {
                window.location = '/products/' + encodeURI(this.searchText);
                
            }
        },
    }
</script>