<template>
    <div>
        <div class="card">
            <div class="card-header">Bejelentkezés</div>
            <div class="card-body">
                <form action="/order-auth" v-on:submit.prevent="login">
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">E-mail cím</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control blue" v-model="email" required autocomplete="email" autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Jelszó</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control blue" v-model="password" required autocomplete="current-password">
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div id="login-button-box" class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary blue">
                                Bejelentkezés
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="/register">
                                Regisztráció
                            </a>
                        </div>
                        <div class="col-md-8 offset-md-4">
                            <a href="/password/reset">
                                Elfelejtette a jelszavát?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="alert alert-danger" v-if="alertText.length">{{ alertText }}</div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                email: '',
                password: '',
                alertText: '',
            }
        },
        methods: {
            login() {
                axios.post('/order-auth', {
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    if (response.request.response == 'success') {
                        window.location = window.location;
                    } else {
                        this.alertText = 'Rossz email cím vagy jelszó!';
                    }
                });
            }
        },
    }
</script>