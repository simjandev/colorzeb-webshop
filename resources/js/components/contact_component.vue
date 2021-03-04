<template>
    <div id="contact">
        <div id="contact-infos">
            <div class="contact-info">
                <img src="/images/logo.png">
            </div>
            <div class="contact-info">
                <div class="contact-info-icon">
                    <a target="_blank" class="footer-image-link" href="https://www.instagram.com/colorzeb_design/"><i class="fa fa-instagram"></i></a>
                </div>
                <div class="contact-info-text">
                    <a target="_blank" class="footer-image-link" href="https://www.instagram.com/colorzeb_design/">colorzeb_design</a>
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-info-icon">
                    <a target="_blank" class="footer-image-link" href="https://www.facebook.com/ColorZebDesign/"><i class="fa fa-facebook"></i></a>
                </div>
                <div class="contact-info-text">
                    <a target="_blank" class="footer-image-link" href="https://www.facebook.com/ColorZebDesign/">ColorZebDesign</a>
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-info-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="contact-info-text">
                    zsuzsi@colorzebdesign.hu
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-info-icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="contact-info-text">
                    06 30 451 8699
                </div>
            </div>
        </div>
        <form id="contact-message">
            <label>{{ label }}</label>
            <input v-if="!this.sent" id="contact-name" v-model="contactName" placeholder="Név" type="text" class="form-control col-sm-12" required>
            <input v-if="!this.sent" id="contact-email" v-model="contactEmail" placeholder="E-mail cím" type="email" class="form-control col-sm-12" required>
            <textarea v-if="!this.sent" id="contact-text" v-model="contactText" placeholder="Üzenet" class="form-control col-sm-12" required></textarea>
            <button v-if="!this.sent" id="send-message-button" class="button" v-on:click.prevent="sendContactEmail"><i class="fa fa-paper-plane"></i> Küldés</button>
            <div id="success-text" v-if="this.sent">
                Köszönjük, hogy felvetted velünk a kapcsolatot! Hamarosan válaszolunk email-ben.
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data: function () {
            return {
                sent: false,
                label: 'Kérdésed van? Írj nekünk!',
                contactName: '',
                contactEmail: '',
                contactText: '',
            };
        },
        methods: {
            sendContactEmail: function() {
                axios.post('/send-contact-message', {
                    name: this.contactName,
                    email: this.contactEmail,
                    text: this.contactText,
                }).then(response => {
                    this.sent = true;
                    this.label = "Sikeres üzenetküldés!"
                }).catch(error  => {
                    alert('hiba');
                    this.label = "Hiba!"
                });
            }
        },
    }
</script>