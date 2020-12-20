<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Tax Rates</h3></span>
		                	<span class="col-6">
			                	<button class="btn btn-danger pull-right" @click.prevent="showTaxRate()"><i class="fa fa-plus"></i> Add New Tax Rate</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<v-client-table v-if="taxRates" :data="taxRates" :columns="['id','name','rate','status', 'actions']" :options="options">
						<template slot="status" slot-scope="props">
	             			<span v-if="props.row.is_active == '1'">Active</span>
	             			<span v-else>Inactive</span>
	             		</template>

	             		<template slot="actions" slot-scope="props">
	             			<button class="btn btn-primary" @click.prevent="showTaxRate(props.row)"><i class="fa fa-pen"></i> Edit</button>
	             			<button class="btn btn-danger" @click.prevent="removeTaxRate(props.row)"><i class="fa fa-trash"></i> Remove</button>
	             		</template>
					</v-client-table>

					<div class="modal fade" id="taxRateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Tax Rate</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
		                                <div :class="['form-group row']" >
			                              	<label for="username" class="col-md-3 pull-left col-form-label">Name</label>
				                            <div class="col-md-12">
				                                <input id="name" name="name" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
				                            </div>
			                           </div>

										<div :class="['form-group row']" >
			                              	<label for="username" class="col-md-3 pull-left col-form-label">Rate</label>
				                            <div class="col-md-12">
				                                <input id="rate" name="rate" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.rate">
				                            </div>
			                           </div>							    		
							     	</div>
							      	<div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="saveTaxRate()">
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
        			id: '',
        			name: '',
        			rate: 0.00,
         		},         		
           		taxRates: [],
                options: {
                    perPage: 10,
                    sortIcon: {
				        base : 'fa',
				        is: 'fa-sort',
				        up: 'fa-sort-asc',
				        down: 'fa-sort-desc'
				    }
                },
			}
		},
		mounted(){
			this.getTaxRates()
		},
		methods:{
			getTaxRates(){
				axios.get('/get-tax-rates').then((response) => {
					this.taxRates = response.data
				})
			},
			saveTaxRate(data){
				axios.post('/save-tax-rate',this.form).then((response) => {
					this.form.name = ''
					this.form.id = ''
					this.form.rate = 0
					this.getTaxRates();
					$('#taxRateModal').modal('hide')
					this.$toastr.s('Tax Rate successfully saved.');
				})
			},
			showTaxRate(data){
				if(data){
					console.log(data)
					this.form.name = data.name
					this.form.rate = data.rate
					this.form.id = data.id
				}

				if(!data){
					this.form.name = ''
					this.form.id = ''
					this.form.rate = 0
				}
				$('#taxRateModal').modal('show')
			},
			removeTaxRate(data){
				this.form.id = data.id
				axios.post('/remove-tax-rate',this.form).then((response) => {
					this.getTaxRates();
					this.$toastr.e('Successfully Removed the Tax Rate.');
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