<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Orders</h3></span>
		                	<span class="col-6">
			                	<button class="btn btn-danger pull-right" @click.prevent="addNewCategory()"><i class="fa fa-plus"></i> Add New Order</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body text-center">
					<v-client-table v-if="orders" :data="orders" :columns="['name','description','date_created','actions']" :options="options">
						<template slot="actions" slot-scope="props" >
                            <div class="table-button-container text-center">
                                <span class="edit-record" @click.prevent="edit(props.row.id, props.row.name, props.row.description)" data-function="Edit" title="Edit"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" :id="props.row.id"></i>Edit</span>
                            </div>
                        </template>

                        <template slot="date_created" slot-scope="props" >
                        	{{props.row.created_at | formatDate}}
                        </template>
					</v-client-table>

					<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		                                <!-- div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-4 col-form-label text-md-right">Name</label>
				                            <div class="col-sm-6">
				                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="category.name">
				                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
				                            </div>
			                           </div> -->

		                                <form-wizard @on-complete="onComplete"
							                     color="gray"
							                     error-color="#a94442"
							                     >
							            <tab-content title="Personal details"
							                         icon="ti-user" :before-change="validateFirstTab">
							               <vue-form-generator :model="model" 
							                                   :schema="firstTabSchema"
							                                   :options="formOptions"
							                                   ref="firstTabForm"
							                                   >
							                                     
							               </vue-form-generator>
							            </tab-content>
							            <tab-content title="Additional Info"
							                         icon="ti-settings" :before-change="validateSecondTab">
							             <vue-form-generator :model="model" 
							                                   :schema="secondTabSchema"
							                                   :options="formOptions"
							                                   ref="secondTabForm"
							                                   >                                
							               </vue-form-generator>
							               
							            </tab-content>
							            <tab-content title="Last step"
							                         icon="ti-check">
							              <h4>Your json is ready!</h4>
							              <div class="panel-body">
							                <pre v-if="model" v-html="prettyJSON(model)"></pre>
							              </div>
							            </tab-content>
							        </form-wizard>
							     	</div>
							      	<!-- <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <button type="button" class="btn btn-primary" @click.prevent="saveMenuItemCategory">Save changes</button>
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="save()">
							      	</div> -->
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

    import {FormWizard, TabContent} from 'vue-form-wizard'
	import 'vue-form-wizard/dist/vue-form-wizard.min.css'

	import VueFormGenerator from 'vue-form-generator'
	import 'vue-form-generator/dist/vfg.css'

	Vue.use(VueFormGenerator)

	export default{
		components: {
		  FormWizard,
		  TabContent
		},
		data(){
			return{
				model:{
				    firstName:'',
				    lastName:'',
				    email:'',
				    streetName:'',
				    streetNumber:'',
				    city:'',
				    country:''
			   	},
				formOptions: {
				    validationErrorClass: "has-error",
				    validationSuccessClass: "has-success",
				    validateAfterChanged: true
				},
				firstTabSchema:{
				    fields:[
				      	{
					        type: "select",
					        label: "Menu",
					        model: "menu",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        values:['United Kingdom','Romania','Germany'],
					        styleClasses:'col-xs-6'
				      	},
				    	{
				        	type: "input",
							inputType: "text",
				        	label: "First name",
				        	model: "firstName",
				        	required:true,
				        	validator:VueFormGenerator.validators.string,
				        	styleClasses:'col-xs-6'
				     	},
				     	{
				        	type: "input",
							inputType: "text",
					        label: "Last name",
					        model: "lastName",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        styleClasses:'col-xs-6'
				     	},
				      	{
				        	type: "input",
							inputType: "text",
					        label: "Email",
					        model: "email",
					        required:true,
					        validator:VueFormGenerator.validators.email,
					        styleClasses:'col-xs-12'
				     	},
				    ]
				},
			   	secondTabSchema:{
			     	fields:[
				     	{
				        	type: "input",
							inputType: "text",
					        label: "Street name",
					        model: "streetName",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        styleClasses:'col-xs-9'
				     	},
				      	{
				        	type: "input",
							inputType: "text",
					        label: "Street number",
					        model: "streetNumber",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        styleClasses:'col-xs-3'
				      	},
				      	{
				        	type: "input",
							inputType: "text",
					        label: "City",
					        model: "city",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        styleClasses:'col-xs-6'
				      	},
				      	{
					        type: "select",
					        label: "Country",
					        model: "country",
					        required:true,
					        validator:VueFormGenerator.validators.string,
					        values:['United Kingdom','Romania','Germany'],
					        styleClasses:'col-xs-6'
				      	},
				    ]
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
			}
		},
		mounted(){
			this.getOrders()
			this.getMenuItems()
		},
		methods:{
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
			addNewCategory(){
				// this.category.id = ''
				// this.category.name = ''
				// this.category.description = ''
				$('#categoryModal').modal('show')
			},
			onComplete: function(){
		      alert('Yay. Done!');
		   },
		   validateFirstTab: function(){
		     return this.$refs.firstTabForm.validate();
		   },
		   validateSecondTab: function(){
		     return this.$refs.secondTabForm.validate();
		   },
		   
		   prettyJSON: function(json) {
	            if (json) {
	                json = JSON.stringify(json, undefined, 4);
	                json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
	                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
	                    var cls = 'number';
	                    if (/^"/.test(match)) {
	                        if (/:$/.test(match)) {
	                            cls = 'key';
	                        } else {
	                            cls = 'string';
	                        }
	                    } else if (/true|false/.test(match)) {
	                        cls = 'boolean';
	                    } else if (/null/.test(match)) {
	                        cls = 'null';
	                    }
	                    return '<span class="' + cls + '">' + match + '</span>';
	                });
	            }
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