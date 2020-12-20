<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Latest Orders</h3></span>
		                	<span class="col-6">
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
        	console.log(value)
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
           			order_expiry_option:0,
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
				    	'venue.user.name':'Venue Name'
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
           		venues : []
			}
		},
		mounted(){
			this.getOrders()
			this.getUserDetail()
			this.getExchangeRates()
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
				//
		    	console.log(self.orderItems)
			    	for(let order of self.orderItems){
			    		price += Number(order.sling_price)
			    		venuePrice += Number(order.vendor_price)
			    	}
		    	//}, 100);
		    	console.log(price)
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
		        	console.log(value)
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
					this.getUserDetail()
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
		    		this.form.orderItems = []
		    		this.orderItems = []
		    		this.getOrders()
		    		$('#orderModal').modal('hide')
		    	})
		   	},
		   	beforeTabSwitch: function(){
		     	//alert("This is called before switchind tabs")
		     	console.log(this.orderItems)
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
					if(this.userDetails.user_type == 1){
						this.taxRate = this.userDetails.venue.tax_rate
					}

					if(this.userDetails.user_type == 0){
						this.taxRate = this.userDetails.venue.tax_rate
					}
					console.log(this.userDetails)
					if(this.userDetails.user_type == 2){
						this.taxRate = this.userDetails.supplier.tax_rate
					}
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
					console.log(stock)
					price += Number(stock.sling_price)
				}
				console.log(price)
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
				console.log(this.form)
				axios.post('/menu-items/filter',this.form).then((response) => {
					this.menuItems = response.data
				})
			},
			addOrder(orderItem, index){
				console.log(orderItem)
				this.orderItems.push(orderItem)
				Vue.set(this.menuItems[index], 'orderQuantity', this.menuItems[index].orderQuantity+=1);
			},
			subtractOrder(orderItem, index){
				var idx = $.inArray(orderItem,this.orderItems);

				Vue.set(this.menuItems[index], 'orderQuantity', this.menuItems[index].orderQuantity-1);
				this.orderItems.splice(idx, 1);
			},
			getExchangeRates(){
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
							console.log(response.data)
							this.venues = response.data
						})
					}

					if(this.userDetails.user_type == 0){
						axios.get('/get-all-venues').then((response) => {
							console.log(response.data)
							this.venues = response.data
						})
					}

					console.log(this.currencyCode)
					this.serviceCharge = (response.data.exchange_rates.rates[this.currencyCode.currency.code] * response.data.conversion_rates.result)
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