<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Customers</h3></span>
		                	<span class="col-6">
			                	
			                </span>
		                </div>
	                </div>

	                <div class="card-body" v-if="userDetails.user_type == '0'">
	                   	<hr/>
		             	<div class="row" >
		             		<form class="section form-inline container"  @submit.prevent="filterCustomers()">
		                       	<div class="form-inline col-2">
		                       		<label class="col-md-12 col-form-label">Filter By</label>
		                       		<select class="form-control" v-model="filterBy" style="width:100%;">
		                       			<option>Name</option>
		                       			<option>Age</option>
		                       			<option>Gender</option>
		                       		</select>
		                       	</div>
			             		<div class="form-inline col-3" v-if="filterBy == 'Name'">
		                            <div class="col-sm-12 row">
		                          	<label for="description" class="col-md-12 col-form-label">Name</label>
				             			<input required="" type="text" class="form-control" v-model="filter.name" style="width:100%">
		                            </div>
		                        </div>

		                        <div class="form-inline col-6" v-if="filterBy == 'Age'">
		                          	
		                            <div class="col-sm-6">
		                            	<label for="description" class="col-md-7 col-form-label">Age From</label>
				             			<input required="" type="number" min="1" max="100" class="form-control" v-model="filter.ageFrom">
		                            </div>
		                          	
		                            <div class="col-sm-6">
		                            	<label for="description" class="col-md-7 col-form-label">Age To</label>
				             			<input required="" type="number" min="1" max="100" class="form-control" v-model="filter.ageTo">
		                            </div>
		                        </div>
		                        <div class="form-inline col-3" v-if="filterBy == 'Gender'">
		                            <div class="col-sm-12 row">
		                          	<label for="description" class="col-md-12 col-form-label">Gender</label>
				             			<select class="form-control" style="width:100%" v-model="filter.gender">
				             				<option>Male</option>
				             				<option>Female</option>
				             				<option>Others</option>
				             			</select>
		                            </div>
		                        </div>

		                        <div class="form-inline col-2">
		                            <div class="col-sm-12">
		                          	<label for="description" class="col-md-12 col-form-label">&nbsp;</label>
		                          	<button type="submit" class="btn btn-primary">Submit</button>
		                            </div>
		                        </div>

		                        
		                        <div class="form-inline col-2">
		                            <div class="col-sm-12">
		                          	<label for="description" class="col-md-12 col-form-label">&nbsp;</label>
		                            </div>
		                        </div>
		                    </form>
	                   	</div>
	                   	<hr/>
						<v-client-table v-if="customers" :data="customers" :columns="['id','name','email','age','gender','country.name','activity_count','actions']" :options="options">
							<template slot="age" slot-scope="props">
		             			{{props.row.date_of_birth}}
		             		</template>

		             		<template slot="actions" slot-scope="props">
		             			<button class="btn btn-danger" @click.prevent="deactivate(props.row)" v-if="props.row.is_active == '1'">Deactivate</button>

		             			<button class="btn btn-warning" @click.prevent="reactivate(props.row)" v-if="props.row.is_active == '0'">Reactivate</button>
		             		</template>

		             		<template slot="activity_count" slot-scope="props">
		             			{{props.row.receiver_activity.length + props.row.sender_activity.length}}
		             		</template>
						</v-client-table>

					</div>

					<div class="card-body" v-if="userDetails.user_type != '0'">
						<hr/>
		             	<div class="row" >
		             		<form class="section form-inline container"  @submit.prevent="filterCustomers()">
		                       	<div class="form-inline col-2">
		                       		<label class="col-md-12 col-form-label">Filter By</label>
		                       		<select class="form-control" v-model="filterBy" style="width:100%;">
		                       			<option>Name</option>
		                       			<option>Age</option>
		                       			<option>Gender</option>
		                       		</select>
		                       	</div>
			             		<div class="form-inline col-3" v-if="filterBy == 'Name'">
		                            <div class="col-sm-12 row">
		                          	<label for="description" class="col-md-12 col-form-label">Name</label>
				             			<input required="" type="text" class="form-control" v-model="filter.name" style="width:100%">
		                            </div>
		                        </div>

		                        <div class="form-inline col-6" v-if="filterBy == 'Age'">
		                          	
		                            <div class="col-sm-6">
		                            	<label for="description" class="col-md-7 col-form-label">Age From</label>
				             			<input required="" type="number" min="1" max="100" class="form-control" v-model="filter.ageFrom">
		                            </div>
		                          	
		                            <div class="col-sm-6">
		                            	<label for="description" class="col-md-7 col-form-label">Age To</label>
				             			<input required="" type="number" min="1" max="100" class="form-control" v-model="filter.ageTo">
		                            </div>
		                        </div>
		                        <div class="form-inline col-3" v-if="filterBy == 'Gender'">
		                            <div class="col-sm-12 row">
		                          	<label for="description" class="col-md-12 col-form-label">Gender</label>
				             			<select class="form-control" style="width:100%" v-model="filter.gender">
				             				<option>Male</option>
				             				<option>Female</option>
				             				<option>Others</option>
				             			</select>
		                            </div>
		                        </div>

		                        <div class="form-inline col-2">
		                            <div class="col-sm-12">
		                          	<label for="description" class="col-md-12 col-form-label">&nbsp;</label>
		                          	<button type="submit" class="btn btn-primary">Submit</button>
		                            </div>
		                        </div>

		                        
		                        <div class="form-inline col-2">
		                            <div class="col-sm-12">
		                          	<label for="description" class="col-md-12 col-form-label">&nbsp;</label>
		                            </div>
		                        </div>
		                    </form>
	                   	</div>
	                   	<hr/>
						<v-client-table v-if="customers" :data="customers" :columns="['id','name','email','age','gender','country.name','activity_count']" :options="options">
							<template slot="age" slot-scope="props">
		             			{{props.row.date_of_birth}}
		             		</template>
		             		<template slot="activity_count" slot-scope="props">
		             			{{props.row.receiver_activity.length + props.row.sender_activity.length}}
		             		</template>
						</v-client-table>

					</div>
            	</div>
        	</div>
    	</div>
	</div>
</template>

<script type="text/javascript">
	import Multiselect from 'vue-multiselect'
	import {ServerTable, ClientTable, Event} from 'vue-tables-2';
    
    Vue.use(ClientTable, {}, false, 'bootstrap4');

    import moment from 'moment';
	Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('D MMM Y')
        }
    })

    Vue.filter('getAge', function(value) {
        if (value) {
            return moment().diff(String(value), 'years');
        }
    })

    import {FormWizard, TabContent} from 'vue-form-wizard'
	import 'vue-form-wizard/dist/vue-form-wizard.min.css'

	import VueFormGenerator from 'vue-form-generator'
	import 'vue-form-generator/dist/vfg.css'

	Vue.use(VueFormGenerator)
	import 'vue-form-wizard/dist/vue-form-wizard.min.css'
	import ElementUI from 'element-ui';
	import 'element-ui/lib/theme-chalk/index.css';
	import VueSimpleAlert from "vue-simple-alert";

	Vue.use(VueSimpleAlert, { 'confirmButtonText': 'Yes' });
	export default{
		components: {
			Multiselect,
		  	FormWizard,
		  	TabContent
		},
		data(){
			return{
				filterBy : 'Name',
				filter:{
					name: '',
					ageFrom : 0,
					ageTo: 0,
					gender: ''
				},
        		form: {
           			venue: '',
           			isCredit: 0,
           			orderItems: [],
           			customers: [],
           			paymentInfo: {},
           			mixer : []
         		},
				orderItems: [],
                options: {
                    perPage: 10,
                    sortIcon: {
				        base : 'fa',
				        is: 'fa-sort',
				        up: 'fa-sort-asc',
				        down: 'fa-sort-desc'
				    },
				    headings:{
				    	'country.name': 'Country'
				    }
                },
               	allerros: [],
               	menuItems: [],
           		success : false,
           		userDetails: {},
           		customers: [],
           		currentYear : Number(moment().year()),
           		exchangeRates: {},
           		orderTax: 0,
           		serviceCharge: 0,
           		orderTotal: 0,
           		subTotal: 0,
           		venueTotal: 0,
           		orders: [],
           		taxRate: {},
           		mixerItems: [],
           		customer: {}
			}
		},
		mounted(){
			this.getCustomers()			
			this.getUserDetail()
		},
		methods:{
			getUserDetail(){
				axios.get('/get-user-details').then((response) => {
					this.userDetails = response.data
				})
			},
			getCustomers(){
				axios.get('/get-customers').then((response) => {
					console.log(response.data)
					this.customers = response.data
				})
			},
			deactivate(customer){
				var self = this
				this.$fire({
				  	title: 'Do you want to deactivate this customer?',
				  	showDenyButton: true,
				  	showCancelButton: true,
				  	confirmButtonText: `Yes`,
				  	cancelButtonText: `No`,
				}).then(r => {
					console.log(r)
					if(r.value == true){
					 	self.customer = customer
						axios.post('/deactivate-customer',self.customer).then((response) => {
							self.getCustomers()
							self.$toastr.w("Success! Customer has been deactivated.");
						})
					}			
				});
			},
			reactivate(customer){
				var self = this
				this.$fire({
				  	title: 'Do you want to reactivate this customer?',
				  	showDenyButton: true,
				  	showCancelButton: true,
				  	confirmButtonText: `Yes`,
				  	cancelButtonText: `No`,
				}).then(r => {
					console.log(r)
					if(r.value == true){
					 	self.customer = customer
						axios.post('/reactivate-customer',self.customer).then((response) => {
							self.getCustomers()
							self.$toastr.w("Success! Customer has been reactivated.");
						})
					}			
				});
			},
			filterCustomers(){
				axios.post('/filter', this.filter).then((response) => {
					this.customers = response.data
					this.filter.name = ''
					this.filter.ageFrom = 0
					this.filter.ageTo = 0
					this.filter.gender = ''
				})
			}
		}
	}
</script>

<style type="text/css">
	.VuePagination {
	  text-align: center;
	}

	.vue-title {
	  text-align: center;
	  margin-bottom: 10px;
	}

	.vue-pagination-ad {
	  text-align: center;
	}

	.glyphicon.glyphicon-eye-open {
	  width: 16px;
	  display: block;
	  margin: 0 auto;
	}

	th:nth-child(3) {
	  text-align: center;
	}

	.VueTables__child-row-toggler {
	  width: 16px;
	  height: 16px;
	  line-height: 16px;
	  display: block;
	  margin: auto;
	  text-align: center;
	}

	.VueTables__child-row-toggler--closed::before {
	  content: "+";
	}

	.VueTables__child-row-toggler--open::before {
	  content: "-";
	}

	[v-cloak] {
	  display:none;
	}

	.pull-right{
		float:right;
	}

	.label-danger {
	    width: 100%;
	    margin-top: 0.25rem;
	    font-size: 80%;
	    color: #e3342f;
	}

	.edit-record{
		cursor: pointer;
	}

	.text-center{
		text-align: center;
	}

	h3{
		padding-top:10px;
		color: #A5413D;
	}

	.table-responsive{
		min-height: 300px;
	}

	.multiselect__content-wrapper{
		position: relative;
	}
</style>