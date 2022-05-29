<template>
<div class="row mt-3">
    <div class="col-md-12 d-flex">
        <div class="col-md-6">
            <button type="button" class="btn btn-danger" @click="logout">Logout</button>
        </div>
        <div class="col-md-6">

            <button type="button" class="btn btn-primary" @click="showModal">Create</button>
        </div>
    </div>

        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Area</th>
                    <th scope="col">Arrival Date</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Status </th>
                     <th scope="col">Action </th>
                    </tr>
                </thead>
                <tbody >
                    <tr  v-for="(data,index) in res_data.data" :key="data.id">
                        <th scope="row">{{index+1}}</th>
                        <td>{{data.display_name}}</td>
                        <td>{{data.display_area}}</td>
                        <td>{{data.display_arrival_date}}</td>
                        <td>{{data.display_due_date}}</td>
                        <td>{{data.display_status}}</td>
                        <td>
                            <button type="button" class="px-2" @click="edit(data)"><i class="bi bi-pencil-square text-success "></i></button>&nbsp;
                            <button type="button" class="mr-2" @click="remove(data.id,index)"><i class="bi bi-trash3-fill text-danger "></i></button>
                        </td>
                    </tr>
                </tbody>
                <!-- <tbody v-else>
                    <tr>
                        <td colspan="7" align="center">Data not found yet.</td>
                        </tr>
                </tbody> -->


            </table>
            <div class="d-flex align-items-center justify-content-end mt-4">
                <ul class="pagination-items">

                    <pagination :data="res_data" :length="res_data.data"  @pagination-change-page="getResults"
                     />

                </ul>
            </div>
        </div>
        <modal  :showModal="showModalNow" @closeModal="closeMyModal"
            @store ="create" @update="update" :form ="form" :is_edit="is_edit"
         ></modal>
    </div>
</template>
<script>
import LaravelVuePagination from 'laravel-vue-pagination';

import modal from './Modal';

export default ({

    components: {
        'Pagination': LaravelVuePagination,
        'modal' : modal
    },
    data(){
        return{
            res_data : {},
            showModalNow: false,
               form:{
                   name: '',
                   area: '',
                   arrival_date: '',
                   due_date: '',
                   status: '',
               },
               is_edit:false
        }
    },
    created(){
        this.getResults();
    },
    methods:{
        /*get result all data */
        getResults(page = 1){
            axios.get(`/api/railcar?page= ${page}`).then((response)=>{
                this.res_data = response.data;
            }).catch((error)=>{
                  this.$router.push('/login')
            });
        },
        remove(id,index){
            let text = "Are you sur want delte it.";
            if (confirm(text) == true) {
                axios.delete(`/api/railcar/${id}`).then((response)=>{
                this.res_data.data.splice(index,1);
            })
            } else {

            }
        },
         /*close modal */
        closeMyModal() {
            this.showModalNow = false;
            this.is_edit = false;
        },
         /*show modal */
        showModal(){
            this.showModalNow = !this.showModalNow;
        },
        edit(data){
            this.is_edit = true;
            this.form = data;
            this.showModalNow = true;
        },
        create(data){
           this.res_data.data.unshift(data);
            this.showModalNow = false;
            this.is_edit = false;
        },
        update(){
            this.getResults();
            this.showModalNow = false;
            this.is_edit = false;
        },
        logout(){
            axios.post('/api/logout').then((response)=>{
                if(response.data.status == true){
                    this.$router.push('/login')
                }
            })
        }
    },

})
</script>



