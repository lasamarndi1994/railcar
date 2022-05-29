<template>
   <div aria-labelledby="exampleModalLabel"
      ref="modal" class="modal fade"
      :class="{ show: active, 'd-block': active }"
      tabindex="-1"
      role="dialog" aria-hidden="true"
      >
  <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Create a new</h5>
               <button type="button"  @click="$emit('closeModal')" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form @submit.prevent="createOrUpdate">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="name">Name</label>
                     <input type="text" class="form-control" id="name" v-model="form.name"  placeholder="Enter name">
                    <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
                  </div>
                  <div class="form-group">
                        <label for="area">Area</label>
                        <select class="form-control" id="area" v-model="form.area">
                            <option value="">Select Area</option>
                            <option value="yard">Yard</option>
                            <option value="north_gate"> North Gate</option>
                            <option value="south_side">South Side</option>
                            <option value="platform_1">Platform 1</option>
                            <option value="platform_2">Platform 2</option>
                            <option value="platform_3">Platform 3</option>
                        </select>
                        <span class="text-danger" v-if="errors.area">{{ errors.area[0] }}</span>
                    </div>

                  <div class="form-group">
                     <label for="arrival_date">Arrival Date</label>
                     <input type="datetime-local" class="form-control" v-model="form.arrival_date" id="arrival_date"  placeholder="Arrival date">
                     <span class="text-danger" v-if="errors.arrival_date">{{ errors.arrival_date[0] }}</span>
                  </div>
                  <div class="form-group">
                     <label for="due_date">Due Date</label>

                     <input type="datetime-local" class="form-control" id="due_date" v-model="form.due_date"  placeholder="Due date">
                     <span class="text-danger" v-if="errors.due_date">{{ errors.due_date[0] }}</span>

                  </div>
                  <div class="form-group">
                     <label for="status">Status</label>
                     <select class="form-control" id="status" v-model="form.status">
                        <option value="">Select Status</option>
                        <option value="parked">Parked</option>
                        <option value="loading"> Loading</option>
                        <option value="loaded">Loaded</option>
                        <option value="shipped">Shipped</option>
                        <option value="archived">Archived</option>
                    </select>
                      <span class="text-danger" v-if="errors.status">{{ errors.status[0] }}</span>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary"  @click="$emit('closeModal')">Close</button>
                  <button type="submit" class="btn btn-primary">{{is_edit == true ? 'Update': 'Create'}}</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
import axios from "axios";


   export default({

        emits: ["closeModal","store","update"],
        props: {
           showModal: Boolean,
           form:Object,
           is_edit:Boolean,
       },

       data() {
           return {
               active: this.showModal,
               errors:{},
              button_text: this.is_edit ==true? 'Save Change' : 'Update Change'
           };
       },
       watch: {
            showModal: {
                handler(newVal) {
                    this.active = newVal;
                    const body = document.querySelector("body");
                    this.showModal ? body.classList.add("modal-open") : body.classList.remove("modal-open")
                },
                immediate: true,
                deep: true,
            },

            'form.name':function(value, oldValue) {
                return oldValue;
            }

        },
        methods:{
            /* update and store the new data */
            createOrUpdate(){
                if(this.is_edit){
                    this.update();
                }else{
                    this.store();
                }
            },
            /*store new data */
            store(){
                axios.post('/api/railcar',this.form).then((response)=>{
                    if(response.data.status == true){
                        this.clearFormData();
                        this.$emit('store',response.data.data);
                    }
                }).catch(error => (this.errors = error.response.data.errors));
            },
              /*update new data */
            update(){
                axios.put(`/api/railcar/${this.form.id}`,this.form).then((response)=>{
                    if(response.data.status == true){
                        this.clearFormData();
                        this.$emit('update');
                    }
                }).catch(error => (this.errors = error.response.data.errors));
            },
            /*clear form object data */
            clearFormData(){
                this.form.name = '';
                this.form.area = '';
                this.form.arrival_date = '';
                this.form.due_date = '';
                this.form.status = '';
            },
        }
   })
</script>
