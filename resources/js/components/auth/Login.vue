<template>
<div class="row mt-5">
    <div class="col-lg-8">
    <form @submit.prevent="login">
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" v-model="form.email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
             <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password">
            <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
         <router-link to="/register" class="nav-item nav-link">Register</router-link>

    </form>
    </div>

</div>


</template>

<script>

export default ({
    data(){
        return {
            form:{
                email:'',
                password: '',
            },
            errors:{}
        }
    },
    methods:{
        login(){
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/login',this.form).then((response) =>{
                    if (response.data.status == true) {
                            this.$router.push('/dashboard')
                        }
                }).catch(error => (this.errors = error.response.data.errors));
            })
        },
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
})
</script>
