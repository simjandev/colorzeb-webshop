<template>
    <div id="categories" class="col-sm-8 offset-lg-1" >
        <div id="delete-category-modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Biztosan törlöd a kategóriát?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Biztosan törlöd ezt a kategóriát?<br>
                        (#{{ this.categoryToDelete.id + ') ' + this.categoryToDelete.name }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button red" data-dismiss="modal" v-on:click="removeCategoryConfirmed()">Törlés</button>
                        <button type="button" class="button blue" data-dismiss="modal">Mégsem</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-warning" role="alert">
            Ha egy kategória törlésre kerül, akkor a benne lévő termékek kategória nélküli termékek lesznek. 
            Ezek a termékek nem jelennek meg a keresőben ha a felhasználó kategóriára szűr.
        </div>
        <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Kategória név</th>
                        <th>Szerkesztés</th>
                        <th>Törlés</th>
                    </tr>
                </thead>
                    <transition-group name="disappear" tag="tbody">
                        <tr v-for="category in categories" :key="category.id">
                            <td>    {{ category.id }}</td>
                            <td>
                                <input type="text" class="form-control blue" v-model="category.name">
                            </td>
                            <td>
                                <button class="modify-button button blue" title="Módosítás" v-on:click="modifyCategory(category.id, category.name)">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                            <td>
                                <button class="button red product-image-delete-button"
                                    v-on:click="removeCategoryDialog(category.id)"
                                    data-toggle="modal" data-target="#delete-category-modal">X</button>
                            </td>
                        </tr>
                    </transition-group>
            </table>
            <br>
            <form class="form form-inline">
                <input id="new-category-name" class="form-control blue" type="text" placeholder="Új kategória neve" v-model="newCategoryName">
                <button id="new-category-button" class="button blue ml-auto" type="button" v-on:click="createNewCategory()">Új kategória</button>
            </form><br>
            <div class="alert alert-success" v-show="successText.length">{{ successText }}</div>
            <div class="alert alert-danger" v-show="alertText.length">{{ alertText }}</div>
        </div>
</template>

<script>
    export default {
        props: {
            _categoryList: Array,
        },
        data: function() {
            return {
                categories: this.$props._categoryList,
                categoryToDelete: {
                    id: -1,
                    name: '',
                },
                newCategoryName: '',
                alertText: '',
                successText: '',
            };
        },
        mounted: function() {
        },
        methods: {
            removeCategoryDialog(id) {
                for (var i = 0; i < this.categories.length; i++) {
                    if (this.categories[i].id == id) {
                        this.categoryToDelete.id = id;
                        this.categoryToDelete.name = this.categories[i].name;
                        break;
                    }
                }
            },
            removeCategoryConfirmed() {
                axios.post('/admin/remove-category', {categoryId: this.categoryToDelete.id}).then(function(res) {
                    if (res.request.responseText == 'ok') {
                        for (var i = 0; i < this.categories.length; i++) {
                            if (this.categories[i].id == this.categoryToDelete.id) {
                                this.categories.splice(i, 1);
                                break;
                            }
                        }
                    } else {
                        console.log(res);
                    }
                }.bind(this));
            },
            createNewCategory() {
                if (this.newCategoryName == '') {
                    this.alertText = 'Kötelező megadni kategória nevet.';
                    setTimeout(() => {
                        this.alertText = '';
                    }, 5000);
                    
                    return;
                }

                axios.post('/admin/create-category', {newCategoryName: this.newCategoryName}).then(function(res) {
                    this.categories.push({id: parseInt(res.request.responseText), name: this.newCategoryName});
                    this.newCategoryName = '';
                    this.alertText = '';
                    this.successText = 'Sikeres kategória létrehozás.';
                    setTimeout(() => {
                        this.successText = '';
                    }, 5000);
                }.bind(this));
            },
            modifyCategory(id, name) {
                if (name == '') {
                    this.alertText = 'Kötelező megadni kategória nevet.';
                    setTimeout(() => {
                        this.alertText = '';
                    }, 5000);

                    return;
                }

                axios.post('/admin/modify-category', {categoryId: id, categoryNewName: name}).then(function(res) {
                    this.successText = 'Sikeres kategória módosítás.';
                    setTimeout(() => {
                        this.successText = '';
                    }, 5000);
                }.bind(this));
            },
        },
    }
</script>