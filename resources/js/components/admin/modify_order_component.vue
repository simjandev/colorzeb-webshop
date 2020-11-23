<template>
    <div>
        <h5>Rendelés állapota</h5>
        <hr>
        
        <div class="col-sm-12">
            <div id="order-status-box">
                <select id="order-status" class="form-control blue" v-model="status">
                    <option value="Feldolgozásra vár">Feldolgozásra vár</option>
                    <option value="Megerősítve">Megerősítve</option>
                    <option value="Elutasítva">Elutasítva</option>
                    <option value="Fizetésre vár">Fizetésre vár</option>
                    <option value="Feladva">Feladva</option>
                    <option value="Teljesítve">Teljesítve</option>
                    <option value="Törölve">Törölve</option>
                </select>
                <button id="order-status-button" class="button blue" v-on:click="orderStatusChanged">Mentés</button>
            </div>
            <div class="alert alert-success" v-if="successText.length">{{ successText }}</div>
        </div><br>

        <h5>Rendelés állapot emailek</h5>
        <hr>
        
        <div class="col-sm-12">
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
            _status: String,
            _id: Number,
        },
        data: function() {
            return {
                id: this.$props._id,
                status: this.$props._status,
                successText: '',
            };
        },
        mounted: function() {
        },
        methods: {
            orderStatusChanged: function() {
                axios.post('/admin/modify-order-status', {id: this.id, status: this.status}).then(res => {
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