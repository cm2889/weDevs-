<template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">All Product</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row card container">
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Employee Insert
                <router-link to="/store-employee" class="btn btn-sm btn-info" id="add_new"> Add New</router-link>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="table-responsive">
                        <label>Search</label>
                        <input type="text" v-model="searchTerm" class="form-control" style="width:200px; "><br>
                        <table class="table table-bordered" id="" width="100%" cellspacing="0">

                            <thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Salary</th>
                                <th>Joining date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr v-for="product in filtersearch" :key="product.id">
                                <td>{{ product.product_title }}</td>
                                <td>{{ product.product_description }}</td>
                               <!-- <td><img :src="product.photo" id="em_photo"></td>-->
                               <td>{{ product.phone }}</td>
                                <!--<td>{{ employee.salary }}</td>

                                <td>
                                    <router-link :to="{name: 'edit-employee', params:{id: employee.id} }" class="btn btn-sm btn-info">Edit</router-link>
                                    <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
                                </td>-->
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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

        created(){
            this.allProduct();
        },

        data(){
            return{
                products:[],
                searchTerm:'',
            }
        },
        computed:{
            filtersearch(){
                return this.products.filter(product => {
                    return product.product_title.match(this.searchTerm)
                })
            }
        },
        methods:{
            allEmployee(){
                axios.get('/api/product/')
                    .then(({data}) => (this.employees = data))
                    .catch()
            },
            deleteEmployee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/employee/'+id)
                            .then(()=>{
                                this.employees = this.employees.filter(employee =>{
                                    return employee.id !=id
                                })
                            })
                            .catch(()=>{
                                this.$router.push({name: 'employee'})
                            })
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }
        },

    }



</script>

<style>

    #add_new{
        float: right;
    }
    #em_photo{
        height: 40px;
        width: 40px;
    }

</style>
