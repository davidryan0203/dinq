<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Venues</h3></span>
		                	<span class="col-6">
			                	
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<v-client-table v-if="venues" :data="venues" :columns="['id','name','actions']" :options="options">
						<template slot="name" slot-scope="props">
							{{props.row.name}}
						</template>
						<template slot="actions" slot-scope="props">
	             			<a class="btn btn-primary" :href="'/venue/edit/'+props.row.id"><i class="fa fa-edit"></i>Edit</a>
	             			<button class="btn btn-danger" @click.prevent="deactivate(props.row)" v-if="props.row.is_active == '1'"></i>Deactivate</button>
	             			<button class="btn btn-warning" @click.prevent="deactivate(props.row)" v-if="props.row.is_active == '0'"></i>Reactivate</button>
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
           			venues: [],
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
				    }
                },
               	allerros: [],
               	menuItems: [],
           		success : false,
           		userDetails: {},
           		venues: [],
           		currentYear : Number(moment().year()),
           		exchangeRates: {},
           		orderTax: 0,
           		serviceCharge: 0,
           		orderTotal: 0,
           		subTotal: 0,
           		venueTotal: 0,
           		orders: [],
           		taxRate: {},
           		mixerItems: []
			}
		},
		mounted(){
			this.getCustomers()
		},
		methods:{
			getCustomers(){
				axios.get('/get-all-venues').then((response) => {
					this.venues = response.data
				})
			},
			deactivate(venue){
				var self = this
				this.$fire({
				  	title: 'Do you want to deactivate this venue? This action is irreversible.',
				  	showDenyButton: true,
				  	showCancelButton: true,
				  	confirmButtonText: `Yes`,
				  	cancelButtonText: `No`,
				}).then(r => {
					console.log(r)
					if(r.value == true){
					 	self.venue = venue
						axios.get('/venue/remove/'+venue.id).then((response) => {
							self.getCustomers()
							self.$toastr.w("Success! Venue has been deactivated.");
						})
					}			
				});
			},
			reactivate(venue){
				var self = this
				this.$fire({
				  	title: 'Do you want to reactivate this venue? This action is irreversible.',
				  	showDenyButton: true,
				  	showCancelButton: true,
				  	confirmButtonText: `Yes`,
				  	cancelButtonText: `No`,
				}).then(r => {
					console.log(r)
					if(r.value == true){
					 	self.venue = venue
						axios.get('/venue/reactivate/'+venue.id).then((response) => {
							self.getCustomers()
							self.$toastr.w("Success! Venue has been reactivated.");
						})
					}			
				});
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