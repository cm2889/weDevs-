<template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row container">
            <div class="card col-lg-12">
                <div class="card-header">
                    <i class="fas fa-chart-area"></i>
                    Product Update
                    <router-link to="/product" class="btn btn-sm btn-info" id="add_new"> All Product</router-link>
                </div>
                <div class="card-body">
                    <form @submit.prevent="productUpdate" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" v-model="form.product_title" class="form-control"   required="">
                                        <small class="text-danger" v-if="errors.product_title">{{ errors.product_title[0] }}</small>
                                        <label>Product Title</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" v-model="form.product_description" class="form-control"  required="">
                                        <small class="text-danger" v-if="errors.address">{{ errors.product_description[0] }}</small>
                                        <label >Description</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="text" id="sallery" v-model="form.product_price" class="form-control"  required="">
                                        <label>Product Price</label>
                                        <small class="text-danger" v-if="errors.product_price">{{ errors.product_price[0] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">

                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="file" class="btn btn-info" @change="onFileselected">

                                        <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img :src="form.photo" style="height:40px; width: 40px;">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted(){
            if (!User.loggedIn()) {
                this.$router.push({ name:'/' })
            }
        },
        data(){
            return{
                form:{
                    product_title :'',
                    product_description:'',
                    product_price:'',
                    photo :'',
                },
                errors:{},

            }
        },
        created(){
            let id = this.$route.params.id
            axios.get('/api/product/'+id)
                .then(({data}) => (this.form = data))
                .catch()

        },
        methods:{
            onFileselected(event){
                let file=event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                }else{
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.newphoto = event.target.result
                    };
                    reader.readAsDataURL(file);

                }
            },
            productUpdate(){
                let id = this.$route.params.id
                axios.patch('/api/product/'+id,this.form)
                    .then(() => {
                        this.$router.push({ name: 'product' })
                        Notification.success()
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

        }


    }




</script>

<style>

    #add_new{
        float: right;
    }

</style>
