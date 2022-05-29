<template>
    <div class="row mt-5">
    <div class="col-lg-8">
    <form @submit.prevent="register">
    <div class="form-group">
            <label for="email">Name</label>
            <input type="text" v-model="form.name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter name">
            <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>

        </div>
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
         <router-link to="/login" class="nav-item nav-link">login
        </router-link>

    </form>
    </div>

</div>
</template>

<script>
export default {
    data() {
        return {
           form:{
                name: "",
                email: "",
                password: "",
           },
            errors:{},
        }
    },
    methods: {
        register(e) {
            e.preventDefault()
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/register',this.form)
                        .then(response => {
                            if (response.data.status == true) {
                                window.location.href = "/login"
                            }
                        }).catch(error => (this.errors = error.response.data.errors));
                })
            }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
