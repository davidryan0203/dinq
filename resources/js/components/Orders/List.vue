<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Orders</h3></span>
		                	<span class="col-6">
			                	<button class="btn btn-danger pull-right" @click.prevent="addNewOrder()"><i class="fa fa-plus"></i> Add New Order</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<!-- <v-client-table v-if="orders" :data="orders" :columns="['name','description','date_created','actions']" :options="options">
						<template slot="actions" slot-scope="props" >
                            <div class="table-button-container text-center">
                                <span class="edit-record" @click.prevent="edit(props.row.id, props.row.name, props.row.description)" data-function="Edit" title="Edit"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" :id="props.row.id"></i>Edit</span>
                            </div>
                        </template>

                        <template slot="date_created" slot-scope="props" >
                        	{{props.row.created_at | formatDate}}
                        </template>
					</v-client-table> -->

					<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Add Order</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
		                                <form-wizard @on-complete="onComplete" 
								                      shape="circle"
								                      color="red">
								            <tab-content title="Venue" v-if="userDetails.user_type == '0'">
								            	
								            </tab-content>
								            <tab-content title="Items" :before-change="beforeTabSwitch">
								            	<label class="radio-inline">
											      	<input type="radio" name="optradio" :checked="form.isCredit == '0'" value="0" v-model="form.isCredit">Dinq
											    </label>
											    <label class="radio-inline">
											      	<input type="radio" name="optradio" value="1" v-model="form.isCredit">Credit
											    </label>

											    <v-client-table v-if="menuItems" :data="menuItems" :columns="['name','vendor_price','stock_quantity','actions']" :options="options">
											    	<template slot="stock_quantity" slot-scope="props">
											    		<span v-if="props.row.is_unlimited == '1'">
											    			Unlimited
											    		</span>
											    		<span v-else>
											    			{{props.row.stock_quantity}}
											    		</span>
											    	</template>
											    	<template slot="actions" slot-scope="props">
											    		<button class="btn btn-primary">Add To Cart</button>
											    	</template>
											    </v-client-table>
								            </tab-content>
								            <tab-content title="Customer Details">
								             	<h2>Add Customer</h2>
								             	<v-client-table v-if="customers" :data="customers" :columns="['name','age','gender','select']" :options="options">
								             		<template slot="age" slot-scope="props">
								             			{{props.row.date_of_birth | getAge}}
								             		</template>
								             		<template slot="select" slot-scope="props">
								             			<input type="checkbox">
								             		</template>
											    </v-client-table>
								            </tab-content>

								            <tab-content title="Payment Details">
								            	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
						                          	<label for="description" class="col-md-4 col-form-label">Card Name</label>
						                            <div class="col-sm-12">
						                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
						                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
						                            </div>
						                       	</div>

						                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
						                          	<label for="description" class="col-md-4 col-form-label">Card Number</label>
						                            <div class="col-sm-12">
						                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
						                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
						                            </div>
						                       	</div>

						                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
						                          	<label for="description" class="col-md-4 col-form-label">Exp Month</label>
						                            <div class="col-sm-12">
						                                <select class="form-control">
						                                	<option value="January">January</option>
						                                	<option value="February">February</option>
						                                	<option value="March">March</option>
						                                	<option value="April">April</option>
						                                	<option value="May">May</option>
						                                	<option value="June">June</option>
						                                	<option value="July">July</option>
						                                	<option value="August">August</option>
						                                	<option value="September">September</option>
						                                	<option value="October">October</option>
						                                	<option value="November">November</option>
						                                	<option value="December">December</option>
						                                </select>
						                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
						                            </div>
						                       	</div>

						                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
						                          	<label for="description" class="col-md-4 col-form-label">Exp Year</label>
						                            <div class="col-sm-12">
						                                <select class="form-control" v-model="form.paymentInfo.expYear">
						                                	<option v-for="year in years" :value="year">{{ year }}</option>
						                                </select>
						                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
						                            </div>
						                       	</div>

						                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
						                          	<label for="description" class="col-md-4 col-form-label">CVS</label>
						                            <div class="col-sm-12">
						                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
						                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
						                            </div>
						                       	</div>
								            </tab-content>
								            <tab-content title="Order Details">
								            	
								            </tab-content>
								        </form-wizard>
							     	</div>
						      	</form>
						    </div>
					  	</div>
					</div>

				</div>
            </div>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
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
	export default{
		components: {
		  FormWizard,
		  TabContent
		},
		data(){
			return{
        		form: {
           			venue: '',
           			isCredit: 0,
           			orderItem: [],
           			customers: [],
           			paymentInfo: {}
         		},
				orders: [],
                options: {
                    perPage: 10,
                    sortIcon: {
				        base : 'fa',
				        is: 'fa-sort',
				        up: 'fa-sort-asc',
				        down: 'fa-sort-desc'
				    }
                },
               	allerros: [],
               	menuItems: [],
           		success : false,
           		userDetails: {},
           		customers: [],
           		currentYear : Number(moment().year())
			}
		},
		mounted(){
			this.getOrders()
			this.getMenuItems()
			this.getUserDetail()
			this.getCustomers()
		},
	  	computed : {
		    years () {
		      const year = new Date().getFullYear() + 30
		      console.log(year)
		      return Array.from({length: year - Number(moment().year())}, (value, index) => Number(moment().year()) + index)
		    }
	  	},
		methods:{
         	onComplete: function(){
		      alert('Yay. Done!');
		   	},
		   	beforeTabSwitch: function(){
		     	alert("This is called before switchind tabs")
		     	return true;
		   	},
			getMenuItems(){
				axios.get('/menu-items/get').then((response) => {
					this.menuItems = response.data
				})
			},
			save(){

			},
			getOrders(){
				axios.get('/get-orders').then((response) => {
					this.orders = response.data
				})
			},
			addNewOrder(){
				$('#orderModal').modal('show')
			},
			getUserDetail(){
				axios.get('/get-user-details').then((response) => {
					this.userDetails = response.data
				})
			},
			getCustomers(){
				axios.get('/get-customers').then((response) => {
					this.customers = response.data
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
</style>