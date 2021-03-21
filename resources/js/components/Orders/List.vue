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
					<v-client-table v-if="orders" :data="orders" :columns="['id','sender','receiver', 'order_type','status','order_total','date_created','order_expiry']" :options="options">
                        <template slot="date_created" slot-scope="props" >
                        	{{props.row.created_at | formatDate}}
                        </template>

                        <template slot="order_expiry" slot-scope="props" >
                        	<span v-if="props.row.order_status == 'redeemed'">
                        		0
                        	</span>
                        	<span v-else-if="props.row.order_status != 'redeemed' && expiryFormat(props.row.order_expiry) > 0">
	                        	{{props.row.order_expiry | expiryFormat}} hours
	                        </span>

	                        <span v-else>
	                        	expired
	                        </span>
                        </template>
                        <template slot="child_row" slot-scope="props">	
                        	<h4>Menu Item</h4>
                        	<table class="table">
                        		<thead>
                        			<th>Name</th>
                        			<th v-if="userDetails.user_type != '1'">Venue</th>
                        			<th>Add-ons used</th>
                        		</thead>
                        		<tbody>
                        			<tr v-for="item in props.row.menu_items">
                        				<td>{{item.name}}</td>
                        				<td v-if="userDetails.user_type != '1'">{{(item.venue) ? item.venue.user.name : 'N/A'}}</td>
                        				<td v-if="item.selected_mixers">
                        					<ul v-if="item.selected_mixers">
	                        					<li v-for="mixer in item.selected_mixers">{{mixer.name}}</li>
	                        				</ul>

                        				</td>
                        				<td v-else>
                        					<span>
	                        					N/A
	                        				</span>
                        				</td>
                        			</tr>
                        		</tbody>
                        	</table>
                        </template>
                        <template slot="sender" slot-scope="props">
                        	{{props.row.sender.name}}
                        </template>

                        <template slot="receiver" slot-scope="props">
                        	{{props.row.receiver.name}}
                        </template>

                        <template slot="order_type" slot-scope="props">
                        	<span v-if="props.row.order_type == '0'">Dinq</span>
                        	<span v-else>Credit</span>
                        </template>

                        <template slot="status" slot-scope="props">
                        	{{props.row.order_status}}
                        </template>

                        <template slot="order_total" slot-scope="props">
                        	<span v-if="currencyCode.currency">
                        		{{currencyCode.currency.symbol_left}}{{props.row.order_total}}{{currencyCode.currency.symbol_right}}
                        	</span>
                        </template>
					</v-client-table>

					<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog modal-lg" role="document" style="max-width: 1000px">
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
								                      color="red" ref="wizard">
								            <template slot="footer" slot-scope="props">

								            </template>
								            <tab-content title="Items" :before-change="beforeTabSwitch">
								            	<div class="form-group">
									            	<label class="radio-inline">
												      	<input type="radio" name="optradio1" :checked="form.isCredit == '0'" value="0" v-model="form.isCredit">Dinq
												    </label>
												    <label class="radio-inline">
												      	<input type="radio" name="optradio2" value="1" v-model="form.isCredit">Credit
												    </label>
												</div>

											    <div class="form-group row" v-if="userDetails.user_type == '0'" style="width: 40%;float: left;">
					                              	<label style="padding:0px;margin:0px;padding-left:15px;" for="username" class="col-md-4 pull-left col-form-label">Filter by Venue</label>
						                            <div class="col-md-12">
						                            	<select class="form-control" v-model="form.venue" @change="filterVenue()">
						                            		<option value="0">All</option>
						                            		<option v-for="venue in venues" :value="venue">{{venue.name}}</option>
						                            	</select>
						                            </div>
					                           	</div>	

					                           	<div class="form-group row" v-if="userDetails.user_type == '2'" style="width: 40%;float: left;">
					                              	<label style="padding:0px;margin:0px;padding-left:15px;" for="username" class="col-md-4 pull-left col-form-label">Filter by Venue</label>
						                            <div class="col-md-12">
						                            	<select class="form-control" v-model="form.venue" @change="filterVenue()">
						                            		<option value="0">All</option>
						                            		<option v-for="venue in venues" :value="venue">{{venue.user.name}}</option>
						                            	</select>
						                            </div>
					                           	</div>												    

											    <v-client-table v-if="menuItems" :data="menuItems" :columns="['id','name','venue.user.name','sling_price','stock_quantity','mixer','order_quantity']" :options="options">
											    	<template slot="stock_quantity" slot-scope="props">
											    		<span v-if="props.row.is_unlimited == '1'">
											    			Unlimited
											    		</span>
											    		<span v-else>
											    			{{props.row.stock_quantity}}
											    		</span>
											    	</template>

											    	<template slot="props"></template>

											    	<template slot="mixer" slot-scope="props">
											    		<multiselect 
			                                          		class="mixer" :options="props.row.mixerStocks" open-direction="bottom" v-model="form.mixer[props.index]" :close-on-select="false" :multiple="true" track-by="id" label="name" placeholder="Select Add-ons" @input="modifyMixer($event,props.row, props)">
			                                        	</multiselect>
											    	</template>

											    	<template slot="order_quantity" slot-scope="props">
											    		<button class="btn btn-danger" @click.prevent="addOrder(props.row, (props.index - 1))"><i class="fa fa-plus"></i></button>
											    			{{ props.row.orderQuantity }}

											    		<button :disabled="props.row.orderQuantity == '0'" class="btn btn-danger" @click.prevent="subtractOrder(props.row, (props.index - 1))"><i class="fa fa-minus"></i></button>

											    	</template>
											    </v-client-table>
											    
								            </tab-content>
								            <tab-content title="Customer Details" :before-change="beforeTabSwitchCustomer">
								             	<h2>Add Customer</h2>
								             	<v-client-table v-if="customers" :data="customers" :columns="['name','age','gender','select']" :options="options">
								             		<template slot="age" slot-scope="props">
								             			{{props.row.date_of_birth | getAge}}
								             		</template>
								             		<template slot="select" slot-scope="props">
								             			<input type="checkbox" :value="props.row" v-model="form.customers">
								             		</template>
											    </v-client-table>
								            </tab-content>

								            <tab-content title="Payment Details">
								            	<div class="form-group" style="font-size:18px;">
								            		<h4 for="description" class="col-md-4 col-form-label">Select Order Expiry</h4>
								            		<div class="col-12">
										            	<label class="radio-inline">
													      	<input type="radio" name="optradio" :checked="form.order_expiry_option == '0'" value="0" v-model="form.order_expiry_option">4 hours
													    </label>

													    <label class="radio-inline">
													      	<input type="radio" name="optradio" :checked="form.order_expiry_option == '1'" value="1" v-model="form.order_expiry_option">24 hours
													    </label>

													    <label class="radio-inline">
													      	<input type="radio" name="optradio" :checked="form.order_expiry_option == '2'" value="2" v-model="form.order_expiry_option">48 hours
													    </label>
													</div>
												</div>

												<div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="cardError">
													<strong>{{this.cardError}}</strong> 
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>

								            	<div v-if="!userDetails.card_id">
									            	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
							                          	<label for="description" class="col-md-4 col-form-label">Card Name</label>
							                            <div class="col-sm-12">
							                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.paymentInfo.name">
							                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
							                            </div>
							                       	</div>

							                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
							                          	<label for="description" class="col-md-4 col-form-label">Card Number</label>
							                            <div class="col-sm-12">
							                                <input id="card_name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.paymentInfo.cartNumber">
							                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
							                            </div>
							                       	</div>

							                       	<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
							                          	<label for="description" class="col-md-4 col-form-label">Exp Month</label>
							                            <div class="col-sm-12">
							                                <select class="form-control" v-model="form.paymentInfo.expMonth">
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
							                          	<label for="description" class="col-md-4 col-form-label">CVC</label>
							                            <div class="col-sm-12">
							                                <input id="cvc" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.paymentInfo.cvs">
							                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
							                            </div>
							                       	</div>

							                       	<button class="btn btn-primary" @click.prevent="storePaymentInfo">Store Payment Info</button>
						                       	</div>

						                       	<div v-else>
						                       		<div class="form-group">
						                       			<div class="col-12">
								                       		<h4>Default Saved Card:</h4> {{userDetails.card_brand}}: xxxx-xxxx-xxxx-{{userDetails.card_last_four}}
								                       		<button class="btn btn-primary" @click.prevent="changeCard()">Change Card</button>
								                       	</div>
							                       </div>
						                       	</div>

								            </tab-content>
								            <tab-content title="Order Details">
								            	<h3>Order Comments</h3>
								            	<textarea class="form-control" v-model="form.comments">Enter comment here</textarea>
								            	<h3>Customer Details</h3>
								            	<table class="table">
								            		<thead>
								            			<th>Name</th>
								            			<th>Country</th>
								            			<th>Age</th>
								            			<th>Gender</th>
								            		</thead>
								            		<tbody>
								            			<tr v-for="customer in form.customers">
								            				<td>{{customer.name}}</td>
								            				<td>{{customer.country.name}}</td>
								            				<td>{{customer.date_of_birth | getAge}}</td>
								            				<td>{{customer.gender}}</td>
								            			</tr>
								            		</tbody>
								            	</table>

								            	<h3>Order Items</h3>
								            	<table class="table">
								            		<thead>
								            			<th>Product</th>
								            			<th>Quantity</th>
								            			<th>Total</th>
								            		</thead>
								            		<tbody>
								            			<tr v-for="order in menuItems" v-if="order.orderQuantity != '0'">
								            				<td>{{order.name}}</td>
								            				<td>{{order.orderQuantity}}</td>
								            				<td>{{currencyCode.currency.symbol_left}}{{Number(order.orderQuantity * order.sling_price).toFixed(2)}}{{currencyCode.currency.symbol_right}}</td>
								            			</tr>
								            			<tr>
								            				<td colspan="3">&nbsp;</td>
								            			</tr>
								            			<tr v-if="orderTotal">
								            				<td></td>
								            				<td>Sub Total:</td>
								            				<td>{{currencyCode.currency.symbol_left}}{{Number(subTotal).toFixed(2)}}{{currencyCode.currency.symbol_right}}</td>
								            			</tr>
								            			<tr v-if="serviceCharge">
								            				<td></td>
								            				<td>Service Charge:</td>
								            				<td>{{currencyCode.currency.symbol_left}}{{Number(serviceCharge).toFixed(2)}}{{currencyCode.currency.symbol_right}}</td>
								            			</tr>
								            			<tr v-if="totalTax" v-for="(tax,key) in totalTax">
								            				<td></td>
								            				<td>{{key}}</td>
								            				<td>{{currencyCode.currency.symbol_left}} {{Number(tax).toFixed(2)}}{{currencyCode.currency.symbol_right}}</td>
								            			</tr>
								            			<tr v-if="orderTotal">
								            				<td></td>
								            				<td>Order Total:</td>
								            				<td>{{currencyCode.currency.symbol_left}}{{Number(orderTotal).toFixed(2)}}{{currencyCode.currency.symbol_right}}</td>
								            			</tr>
								            		</tbody>
								            	</table>
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
	import Multiselect from 'vue-multiselect'
	import {ServerTable, ClientTable, Event} from 'vue-tables-2';
    
    Vue.use(ClientTable, {}, false, 'bootstrap4');

    import moment from 'moment';
	Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('D MMM Y')
        }
    })

    Vue.filter('expiryFormat', function(value) {
    	function expiryDate(date_string) {
		  	var expiration = moment(date_string).format("YYYY-MM-DD HH:mm:ss");
		  	var current_date = moment().format("YYYY-MM-DD HH:mm:ss");
		  	var days = moment.utc(expiration).diff(current_date, 'hours');
		  	return days;
		}

        if (value) {
        	var now  = moment();
			var then = moment(value);
   			return expiryDate(then);
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
			Multiselect,
		  	FormWizard,
		  	TabContent
		},
		data(){
			return{
        		form: {
           			venue: '',
           			isCredit: 0,
           			orderItems: [],
           			customers: [],
           			paymentInfo: {},
           			mixer : [],
           			order_expiry_option:1,
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
				    	'venue.user.name':'Venue Name',
				    	'mixer' : 'Add-ons'
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
           		currencyCode : {},
           		venues : [],
           		cardError : ''
			}
		},
		mounted(){
			this.getOrders()
			this.getMenuItems()
			this.getUserDetail()
			this.getCustomers()
			this.getExchangeRates()

			$('.wizard-title').text('Order Wizard')
			$('.category').text('sending item to customer')
			this.getMixerItems()
		},
	  	computed : {
		    years () {
		      const year = new Date().getFullYear() + 30
		      return Array.from({length: year - Number(moment().year())}, (value, index) => Number(moment().year()) + index)
		    },
		    totalTax (){
				var self = this
		    	function sum( obj ) {
				  	var sum = 0;
				  	for( var el in obj ) {
				    	if( obj.hasOwnProperty( el ) ) {
				      		sum += parseFloat( obj[el] );
				    	}
				  	}
				  	return sum;
				}

				//return the sum of all keys
				const groupAll = list => list.reduce((acc, item) => {
				  	const accAmout = acc[item.tax_rate.name] || 0;
				  	return Object.assign({}, acc, {[item.tax_rate.name]: accAmout + Number(item.sling_price * item.tax_rate.rate * 0.01) });
				}, {});

				var price = 0
				var venuePrice = 0
				var taxes = groupAll(this.orderItems)
			    	for(let order of self.orderItems){
			    		price += Number(order.sling_price)
			    		venuePrice += Number(order.vendor_price)
			    	}
		    	if(price && price != 0){
		    		this.subTotal = Number(price)
		    		this.orderTotal = (Number(price) + Number(this.serviceCharge) + Number(sum(taxes)))
		    		this.venueTotal = (Number(venuePrice) + Number(this.serviceCharge) + Number(sum(taxes)))
			    }
				return groupAll(this.orderItems);
		    }
	  	},
		methods:{
	  		expiryFormat(value){
	  			function expiryDate(date_string) {
				  	var expiration = moment(date_string).format("YYYY-MM-DD HH:mm:ss");
				  	var current_date = moment().format("YYYY-MM-DD HH:mm:ss");
				  	var days = moment.utc(expiration).diff(current_date, 'hours');
				  	return days;
				}

		        if (value) {
		        	var now  = moment();
					var then = moment(value);
		   			return expiryDate(then);
		        }
	  		},
			getMixerItems(){
				axios.get('/menu/mixer/get').then((response) => {
					this.mixerItems = response.data
				})
			},
			storePaymentInfo(){
				axios.post('/store-payment-info', this.form.paymentInfo).then((response) => {
					if(!response.data.error){
						this.cardError = ''
						this.getUserDetail()
					}else{
						this.cardError = response.data.error
					}
				})
			},
         	onComplete: function(){
         		this.form.orderTotal = this.orderTotal
         		this.form.venueTotal = this.venueTotal
         		this.form.orderTax = this.orderTax
         		this.form.serviceCharge = this.serviceCharge
         		this.form.venue = this.userDetails.venue
         		this.form.customers = this.form.customers
         		this.form.orderItems = this.orderItems
         		this.form.menuItems = this.menuItems
		    	axios.post('/process-order', this.form).then((response) => {
		    		this.form.customers = []
		    		this.form.orderTotal = 0
		    		this.form.venueTotal = 0
		    		this.form.orderTax = 0
		    		this.form.serviceCharge = 0
		    		this.form.venue = ''
		    		this.form.orderItems = []
		    		this.orderItems = []
		    		this.form.menuItems = []
		    		this.getOrders()
		    		$('#orderModal').modal('hide')
		    		this.$refs.wizard.reset()
		    		var menus = []
		    		for(let menu of this.menuItems){
		    			menu.orderQuantity = 0
		    			menus.push(menu)
		    		}
		    		this.menuItems = []
		    		this.menuItems = menus
		    	})
		   	},
		   	beforeTabSwitch: function(){
		     	//alert("This is called before switchind tabs")
		     	if(this.orderItems.length == 0){
					this.$toastr.e('Must select Order first before proceeding.');
			     	return false;
			    }else{
			    	return true;
			    }
		   	},
		   	beforeTabSwitchCustomer(){
		   		if(this.form.customers.length == 0){
		   			this.$toastr.e('Must select Customer first before proceeding.');
		   			return false;
		   		}else{
		   			return true;
		   		}
		   	},
			getMenuItems(){
				axios.get('/menu-items/get').then((response) => {
					this.menuItems = response.data
				})
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
					this.form.comments = this.userDetails.name+' has Dinq\'d you.'
					if(this.userDetails.user_type == 1){
						this.taxRate = this.userDetails.venue.tax_rate
					}

					if(this.userDetails.user_type == 0){
						this.taxRate = this.userDetails.venue.tax_rate
					}
					if(this.userDetails.user_type == 2){
						this.taxRate = this.userDetails.supplier.tax_rate
					}

					axios.get('/get-exchange-rates').then((response) => {
						this.exchangeRates = response.data
						if(this.userDetails.user_type == 1){
							this.currencyCode = this.userDetails.venue
						}

						if(this.userDetails.user_type == 0){
							this.currencyCode = this.userDetails.venue
						}

						if(this.userDetails.user_type == 2){
							this.currencyCode = this.userDetails.supplier
							axios.get('/get-supplier-venues').then((response) => {
								this.venues = response.data
							})
						}

						if(this.userDetails.user_type == 0){
							axios.get('/get-all-venues').then((response) => {
								this.venues = response.data
							})
						}

						this.serviceCharge = (response.data.exchange_rates.rates[this.currencyCode.currency.code] * response.data.conversion_rates.result)
					})
				})
			},
			getCustomers(){
				axios.get('/get-customers').then((response) => {
					this.customers = response.data
				})
			},
			changeCard(){
				axios.post('/remove-payment-info', this.form.paymentInfo).then((response) => {
					this.getUserDetail()
				})
			},
			modifyMixer(event,data,item){
				var price = 0
				var self = this
				for(let stock of event){
					price += Number(stock.sling_price)
				}
				Vue.set(this.menuItems[item.index - 1], 'sling_price', this.menuItems[item.index - 1].sling_price=(Number(price) + Number(data.sling_item_price)));

				Vue.set(this.menuItems[item.index - 1], 'selected_mixers', this.menuItems[item.index - 1].selected_mixers=event);

				if(this.orderItems){
					this.orderItems.forEach(function (value, i) {
						if(data.id == value.id){
							Vue.set(self.orderItems[i], 'sling_price', self.orderItems[i].sling_price=(Number(price) + Number(data.sling_item_price)).toFixed(2) );
						}
					});
				}
			},
			filterVenue(){
				axios.post('/menu-items/filter',this.form).then((response) => {
					this.menuItems = response.data
				})
			},
			addOrder(orderItem, index){
				this.orderItems.push(orderItem)
				Vue.set(this.menuItems[index], 'orderQuantity', this.menuItems[index].orderQuantity+=1);
			},
			subtractOrder(orderItem, index){
				var idx = $.inArray(orderItem,this.orderItems);

				Vue.set(this.menuItems[index], 'orderQuantity', this.menuItems[index].orderQuantity-1);
				this.orderItems.splice(idx, 1);
			},
			getExchangeRates(){
				
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