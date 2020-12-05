<template>
    <div class="col-lg-8 offset-lg-1">
        <a href="#" onclick="window.location.replace(document.referrer);">
            <button id="back-button" class="button blue">
                <i class="add-to-cart-button fa fa-arrow-left"></i> Vissza
            </button>
        </a><br><br>

        <div id="menu-buttons">
            <button :class="{active: currentMenu == 'details', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('details')">Részletek</button>
            <button :class="{active: currentMenu == 'modify', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('modify')">Módosítás</button>
            <button :class="{active: currentMenu == 'emails', button: true, blue: true, 'menu-button': true}" v-on:click="visibleMenuChanged('emails')">Emailek</button>
        </div>
        <hr id="menu-buttons-divider">

        <table id="order-items" class="table table-bordered table-sm col-sm-12" v-if="currentMenu == 'details'">
            <thead>
                <tr>
                    <th></th>
                    <th>Termék</th>
                    <th>Mennyiség</th>
                    <th>Egységár</th>
                    <th>Összesen</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in orderProducts" :key="index">
                    <td><img :src="product.image" class="order-item-image"></td>
                    <td>{{ product.name }} </td>
                    <td>{{ product.quantity }}</td>
                    <td>{{ product.price }} Ft</td>
                    <td>{{ product.price * product.quantity }} Ft</td>
                </tr>
            </tbody>
        </table>

        <table id="order-customer-data" class="table table-bordered table-sm col-sm-12" v-if="currentMenu == 'details'">
            <thead>
                <tr>
                    <th colspan="2">Vevő adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>E-mail cím</td>
                    <td>{{ order.email }}</td>
                </tr>
                <tr>
                    <td>Megjegyzés</td>
                    <td>{{ order.user_comment }}</td>
                </tr>
                
            </tbody>
        </table>

        <table id="order-customer-shipping-data" class="table table-bordered table-sm col-sm-12" v-if="currentMenu == 'details'">
            <thead>
                <tr>
                    <th colspan="2">Szállítási adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Név</td>
                    <td>{{ order.shipping_name }}</td>
                </tr>
                <tr>
                    <td>Telefonszám</td>
                    <td>{{ order.shipping_phone }}</td>
                </tr>
                <tr>
                    <td>Cím</td>
                    <td>
                        {{ order.shipping_zip + ' ' + order.shipping_city + ', ' + order.shipping_address}}
                    </td>
                </tr>
            </tbody>
        </table>

        <table id="order-customer-billing-data" class="table table-bordered table-sm col-sm-12" v-if="currentMenu == 'details'">
            <thead>
                <tr>
                    <th colspan="2">Számlázási adatok</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Név</td>
                    <td>{{ order.billing_name }}</td>
                </tr>
                <tr v-if="order.billing_tax_number.length">
                    <td>Adószám</td>
                    <td>{{ order.billing_tax_number }}</td>
                </tr>
                <tr>
                    <td>Cím</td>
                    <td>
                        {{ order.billing_zip + ' ' + order.billing_city + ', ' + order.billing_address}}
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table id="order-sum" class="table table-bordered table-sm col-sm-12" v-if="currentMenu == 'details'">
            <thead>
                <tr>
                    <th class="alignment-column"></th>
                    <th>Tétel</th>
                    <th>Összeg</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Szállítás:</td>
                    <td>{{ order.shipping_price }} Ft</td>
                </tr>
                <tr>
                    <td class="alignment-column"></td>
                    <td>Termékek ára:</td>
                    <td>{{ order.price }} Ft</td>
                </tr>
            </tbody>
        </table>
        
        <div id="order-modify" class="col-sm-12" v-if="currentMenu == 'modify'">
            <div class="form-group row col-sm-12">
                <label for="order-status" class="col-lg-4 text-right">Állapot:</label>
                <select id="order-status" class="form-control blue col-lg-8" v-model="order.status">
                    <option value="Feldolgozásra vár">Feldolgozásra vár</option>
                    <option value="Megerősítve">Megerősítve</option>
                    <option value="Elutasítva">Elutasítva</option>
                    <option value="Fizetésre vár">Fizetésre vár</option>
                    <option value="Feladva">Feladva</option>
                    <option value="Teljesítve">Teljesítve</option>
                    <option value="Törölve">Törölve</option>
                </select>
            </div>
            
           <div class="form-group row col-sm-12">
                <label for="payed" class="col-lg-4 text-right">Fizetve:</label>
                <select id="payed" class="form-control blue col-lg-8" v-model="order.payed">
                    <option value="0">Nem</option>
                    <option value="1">Igen</option>
                </select>
            </div>
            
            <div class="form-group row col-sm-12">
                <label id="admin-comment-label" for="admin-comment" class="col-lg-4 text-right">Admin megjegyzés:</label>
                <textarea id="admin-comment" class="form-control blue col-lg-8" v-model="order.admin_comment"></textarea>
            </div>

            <button id="order-status-button" class="button blue" v-on:click="orderStatusChanged">Mentés</button>
            <div class="alert alert-success" v-if="successText.length">{{ successText }}</div>
        </div><br>
        
        <div class="col-sm-12" v-if="currentMenu == 'emails'">
            <textarea class="form-control blue" placeholder="Állapot email egyedi szöveg"></textarea><br>
            <select id="order-status-email" class="form-control blue">
                <option value="Feldolgozásra vár">Feldolgozásra vár</option>
                <option value="Megerősítve">Megerősítve</option>
                <option value="Elutasítva">Elutasítva</option>
                <option value="Fizetésre vár">Fizetésre vár</option>
                <option value="Feladva">Feladva</option>
                <option value="Teljesítve">Teljesítve</option>
                <option value="Törölve">Törölve</option>
            </select>
            <button id="order-status-email-button" class="button blue">Küldés</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            _order: Object,
            _orderProducts: Array,
        },
        data: function() {
            return {
                order: this.$props._order,
                orderProducts: this.$props._orderProducts,
                successText: '',
                currentMenu: 'details',
            };
        },
        mounted: function() {
            for (var i = 0; i < this.orderProducts.length; i++) {
                this.orderProducts[i].parameters = JSON.parse(this.orderProducts[i].parameters);
                
                if (!this.orderProducts[i].parameters[2].length) {
                    this.orderProducts[i].parameters.splice(2, 1);
                }

                if (!this.orderProducts[i].parameters[1].length) {
                    this.orderProducts[i].parameters.splice(1, 1);
                }

                if (!this.orderProducts[i].parameters[0].length) {
                    this.orderProducts[i].parameters.splice(0, 1);
                }

                if (this.orderProducts[i].parameters.length) {
                    this.orderProducts[i].name += ' (' + this.orderProducts[i].parameters.join(', ') + ')';
                }
            }
        },
        methods: {
            visibleMenuChanged: function(newMenu) {
                if (this.successText.length && this.id == -1) {
                    return;
                }

                this.currentMenu = newMenu;
            },
            orderStatusChanged: function() {
                var orderModifyData = {
                    id: this.order.id,
                    status: this.order.status,
                    payed: this.order.payed,
                    admin_comment: this.order.admin_comment,
                };

                axios.post('/admin/modify-order', orderModifyData).then(res => {
                    if (res.request.responseText == 'success') {
                        this.successText = 'Sikeres állapot módosítás';
                    }

                    setTimeout(() => {
                        this.successText = '';
                    }, 5000);
                });
            }
        },
    }
</script>