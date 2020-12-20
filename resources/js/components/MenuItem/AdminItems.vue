<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Menu Items</h3></span>
		                	<span class="col-6">
			                	<button class="btn btn-danger pull-right" @click.prevent="addNewItem()"><i class="fa fa-plus"></i> Add New</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
	                <div class="modal fade" id="addNewMenuItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Menu Item</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
							      		<div class="form-group row">
				                            <label for="description" class="col-md-4 col-form-label">Select Venue</label>

				                            <div class="col-md-12">
				                                <select class="form-control" v-model="form.venue" @change="selectVenue()">
				                                	<option v-for="venue in venues" :value="venue">{{venue.name}}</option>
				                                </select>
				                            </div>
				                        </div>
				                        <span v-if="form.venue != ''">
									        <div :class="['form-group row', allerros.name ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Product Name</label>
					                            <div class="col-sm-12">
					                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
					                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
					                            </div>
					                       	</div>

					                        <div class="form-group row">
					                            <label for="description" class="col-md-4 col-form-label">Description</label>

					                            <div class="col-md-12">
					                                <textarea class="form-control" v-model="form.description" required=""></textarea>
					                            </div>
					                        </div>

					                        <div class="form-group row">
					                            <label for="access_roles" class="col-md-4 col-form-label">Choose User Type</label>

					                            <div class="col-md-12">
					                            	<div style="background-color: rgb(246, 246, 246);padding-left:1rem">
					                                	<div class="form-check">
														  	<label class="form-check-label">
														    	<input type="checkbox" class="form-check-input" v-model="form.access_roles" value="public">Public
														  	</label>
														</div>
														<div class="form-check">
														  	<label class="form-check-label">
														    	<input type="checkbox" class="form-check-input" v-model="form.access_roles" value="supplier">Supplier
														  	</label>
														</div>
														<div class="form-check">
														  	<label class="form-check-label">
														    	<input type="checkbox" class="form-check-input" v-model="form.access_roles" value="venue">Venue
														  	</label>
														</div>
														<div class="form-check">
														  	<label class="form-check-label">
														    	<input type="checkbox" class="form-check-input" v-model="form.access_roles" value="admin">Admin
														  	</label>
														</div>
													</div>
					                            </div>
					                       	</div>

					                       	<div class="form-group row" v-for="role in form.access_roles" v-if="role == 'supplier'">
								    			<label for="access_roles" class="col-md-4 col-form-label">Choose Supplier</label>
								    			<div class="col-md-12">
									    			<multiselect class="" v-model="form.supplierId" :options="suppliers" :multiple="false" :close-on-select="true" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="contact_name" track-by="id">
													    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
													</multiselect>
												</div>
								    		</div>

					                       	<div class="form-group row">
								    			<label for="access_roles" class="col-md-4 col-form-label">Choose Category</label>
								    			<div class="col-md-12">
								    				<div class="row">
								    					<div class="col-md-8">
						                                    <multiselect v-model="form.categories" :options="menuItemCategories" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="id">
															    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
															</multiselect>
														</div>
														<div class="col-md-4">
															<button class="btn btn-primary"  @click.prevent="addNewCategory()">Add Category</button>
														</div>
													</div>

													<div style="background-color:rgb(246, 246, 246)">
														<ul>
															<li v-for="item in form.categories">
																{{item.name}}
															</li>
														</ul>
													</div>
					                            </div>
								    		</div>

								    		<div class="form-group row" v-if="venue">
								    			<label for="access_roles" class="col-md-4 col-form-label">Choose Mixer</label>
								    			<div class="col-md-12">
					                                    <multiselect class="" v-model="form.mixers" :options="mixerItems" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name" track-by="id">
														    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
														</multiselect>

													<div style="background-color:rgb(246, 246, 246)">
														<ul>
															<li v-for="item in form.mixers">
																{{item.name}} - {{userDetails.venue.currency.symbol_left}}{{item.sling_price}} {{userDetails.venue.currency.symbol_right}}
															</li>
														</ul>
													</div>
					                            </div>
								    		</div>

								    		<div :class="['form-group row', allerros.vendor_price ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Vendor Price</label>
					                            <div class="col-sm-12">
					                                <input id="vendor_price" name="number" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.vendor_price">
					                            </div>
					                       </div>
					                       <span style="display: none">{{calculateSlingPrice}}</span>
					                       <div :class="['form-group row', allerros.sling_price ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Sling Price</label>
					                            <div class="col-sm-12">

					                                <input id="sling_price" name="number" autofocus="autofocus" class="form-control" type="text" v-model="form.sling_price">
					                            </div>
					                       </div>
					                       <div :class="['form-group row', allerros.quantity ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Quantity</label>
					                            <div class="col-sm-12">
					                                <input id="quantity" name="number" min="1" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.quantity">
					                            </div>
					                       </div>

					                       <div :class="['form-group row', allerros.min_quantity ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Minimum Purchase Quantity</label>
					                            <div class="col-sm-12">
					                                <input id="min_quantity" name="number" min="1" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.min_quantity">
					                            </div>
					                       </div>

					                       <div :class="['form-group row', allerros.min_quantity ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Subtract From Quantity</label>
					                            <div class="col-sm-12">
					                                <select class="form-control" v-model="form.is_unlimited">
					                                	<option :selected="(form.is_unlimited == '0')" value="0">Yes</option>
					                                	<option :selected="form.is_unlimited == '1'" value="1">No</option>
					                                </select>
					                            </div>
					                       </div>

					                       <div v-if="form.img_url" :class="['form-group row']" >
					                       		<label for="mixerImage" class="col-md-4 col-form-label">&nbsp;</label>
					                            <div class="col-sm-12">

					                				<img :src="form.img_url" class="responsive">
												</div>
					                       	</div>

					                       <div :class="['form-group row']" >
					                       		<label for="mixerImage" class="col-md-4 col-form-label">Item Image</label>
					                            <div class="col-sm-12">
					                				<vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
												</div>
					                       	</div>

					                       <div :class="['form-group row', allerros.min_quantity ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Tax Rate</label>
					                          	<div class="col-sm-12">
					                           		<select v-model="form.tax_type" class="form-control">
					                                   	<option v-for="rate in taxRates" v-if="rate.is_active == '1'" :value="rate.id">{{rate.name}}</option>
					                              	</select>
					                          	</div>
					                      </div>

					                       <div :class="['form-group row', allerros.measure ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Measure</label>
					                            <div class="col-sm-12">
					                                <input id="measure" name="text" min="1" value="" placeholder="Weight" autofocus="autofocus" class="form-control" type="text" v-model="form.measure">
					                            </div>
					                       </div>

					                       <div :class="['form-group row', allerros.uom ? 'has-error' : '']" >
					                          	<label for="description" class="col-md-4 col-form-label">Unit Of Measure</label>
					                            <div class="col-sm-12">
					                                <select class="form-control" v-model="form.uom">
					                                	<option value="liter">Liter</option>
					                                	<option value="milliliter">Milliliter</option>
					                                	<option value="kilograms">KiloGrams</option>
					                                </select>
					                            </div>
					                       </div>
					                   </span>
				                   </div>
				                   <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="save()">
							      	</div>
						      	</form>
						  	</div>
						</div>
					</div>
				    <div class="modal" id="menuCategoryModal" data-backdrop="static">
			            <div class="modal-dialog modal-lg">
			                <div class="modal-content">
			                    <div class="modal-header">
			                    <h4 class="modal-title">Menu Category</h4>
			                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                </div><div class="container"></div>
				                <div class="modal-body">
				                	<form class="form">
							            <div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-4 col-form-label">Name</label>
				                            <div class="col-sm-12">
				                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="category.name">
				                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
				                            </div>
			                           </div>

			                            <div class="form-group row">
			                                <label for="description" class="col-md-4 col-form-label">Description</label>

			                                <div class="col-md-12">
			                                    <textarea class="form-control" :class="allerros.description ? 'is-invalid' : ''" v-model="category.description" required=""></textarea>
			                                    <span v-if="allerros.description" :class="['label label-danger']">{{ allerros.description[0] }}</span>
			                                </div>
			                            </div>

			                            <div slot="modal-footer"></div>
				                        <slot name="modal-footer">
										    <div class="modal-footer">
										        <button
										                type="button"
										                @click.prevent="saveMenuItemCategory()"
										                class="btn btn-primary"
										        >Save
										        </button>
										        <button
										                type="button"
										                class="btn btn-secondary"
										                data-dismiss="modal"
										                @click.prevent="show=false"
										        >Cancel
										        </button>
										    </div>
										</slot>
			                        </form>
				                </div>
			            	</div>
			            </div>
			        </div>

					<v-client-table v-if="allMenuItems" :data="allMenuItems" :columns="['name','venue_name',,'description','date_created','actions']" :options="options">
						<template slot="actions" slot-scope="props" >
                            <div class="table-button-container text-center">
                                <span class="edit-record" @click.prevent="edit(props.row.id, props.row.name, props.row.description,props.row.menu_categories,props.row.mixers,props.row.access_roles,props.row.venue_id,props.row.vendor_price,props.row.sling_price,props.row.tax_rate,props.row.stock_quantity,props.row.minimum_purchase_quantity,props.row.is_unlimited,props.row.measure,props.row.unit_of_measure,props.row.image_url)" data-function="Edit" title="Edit"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" :id="props.row.id"></i>Edit</span>
                                <span @click.prevent="removeModal(props.row.id)"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" :id="props.row.id"></i>Delete</span>
                            </div>
                        </template>

                        <template slot="venue_name" slot-scope="props">
                        	{{props.row.venue.user.name}}
                        </template>

                        <template slot="date_created" slot-scope="props" >
                        	{{props.row.created_at | formatDate}}
                        </template>
					</v-client-table>

					<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			            <div class="modal-dialog" role="document">
			              <div class="modal-content">
			                <div class="modal-header">
			                  <h5 class="modal-title" id="exampleModalLabel">Remove Menu Item</h5>
			                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                  </button>
			                </div>
			                <div class="modal-body">
			                	<p style="color:red">Are you sure you want to remove this Item?</p>

			                </div>
			                <div class="modal-footer">
			                  <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
			                  <a class="btn btn-primary" href="#" @click.prevent="remove()">Yes</a>
			                </div>
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
	import Multiselect from 'vue-multiselect'
	import StackModal from '@innologica/vue-stackable-modal'

	import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
	export default{
		components: { Multiselect,StackModal,vueDropzone: vue2Dropzone  },
		data(){
			var self = this
			return{
				category: {'id':'','name': '', 'description' : ''},
				form: {'id':'', 'supplierId':0,'name': '', 'description' : '', 'access_roles' : [], 'categories' : [], 'sling_price': 0,'vendor_price': 0, 'quantity' :1, 'min_quantity': "1", 'measure': '', 'uom':'','tax_type': '', 'mixers': [], 'img_url': '','venue':{}},
				menuItemCategories: [],
				menuItems: [],
				allMenuItems: [],
				mixerItems: [],
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
           		success : false, 
			    value: [],
		        show: false,
		        show_second: false,
		        show_third: false,
		        modalClass: 'modal-xl',
           		dropzoneOptions: {
			        url: '/mixer/upload',
			        thumbnailWidth: 150,
			        maxFilesize: 5,
			        headers: { "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content },
			        maxFiles: 1,
			        success: function(file, response) 
		            {
		            	console.log(file)
		            	self.form.img_url = file.dataURL
		            }
			    },
			    taxRates: [],
			    userDetails : {},
			    suppliers: [],
			    venue: {},
			    venues: []
			}
		},
		mounted(){
			this.getUserDetail()
			this.getMenuItems()
			this.getSuppliers()
			axios.get('/get-tax-rates').then((response) => {
				this.taxRates = response.data
			})

			axios.get('/get-all-venues').then((response) => {
				this.venues = response.data
			})
		},
		computed:{
			calculateSlingPrice(){
				this.form.sling_price = (Number(this.form.vendor_price) + Number(this.form.vendor_price * 10 / 100)).toFixed(2)
				return (Number(this.form.vendor_price) + Number(this.form.vendor_price * 10 / 100)).toFixed(2)
			}
		},
		methods:{
			getSuppliers(){
				axios.get('/get-suppliers').then((response) => {
					this.suppliers = response.data
				})
			},
			getUserDetail(){
				axios.get('/get-user-details').then((response) => {
					this.userDetails = response.data
				})
			},
			selectVenue(){
				axios.get('/admin-menu-items/'+this.form.venue.venue.id).then((response) => {
					this.menuItems = response.data
				})

				axios.get('/admin-menu-category-item/'+this.form.venue.venue.id).then((response) => {
					this.menuItemCategories = response.data
				})

				axios.get('/admin-menu/mixer/'+this.form.venue.venue.id).then((response) => {
					this.mixerItems = response.data
				})
			},
			getMenuItems(){
				axios.get('/menu-items/get').then((response) => {
					this.allMenuItems = response.data
				})
			},
			addNewCategory(){
				//this.show = true
				$('#menuCategoryModal').modal('show')
			},
			addNewItem(){
				this.form.id = ''
				this.form.name = ''
				this.form.description = ''
				this.form.access_roles = []
				//this.show = true

				this.$refs.myVueDropzone.removeAllFiles();
				$('#addNewMenuItemModal').modal('show')
			},
			edit(id,name,description,menuCaterogyID,mixerID,accessRoles,venueID,vendorPrice,slingPrice,taxCode,stockQuantity,minPurchaseQuantity,isUnlimited,measure,uom,imgURL){
				console.log(imgURL)
				this.$refs.myVueDropzone.removeAllFiles();
				// console.log(name)
				// let dropzone = this.$refs.myVueDropzone;
	   //          var mockFile = { name: "icon.jpg", size: 12345 };
	            //dropzone.manuallyAddFile(mockFile, "http://127.0.0.1:8003/images/menu/items/af4367c60f0b74d6a5328de36be197b6248720bb.png");
	            if(imgURL.length == 0){
	            	imgURL = 'https://www.slingtheworld.com/pos/image/cache/no_image-100x100.png'
	            }
	            //dropzone.manuallyAddFile(mockFile, imgURL);
			    

			    // this.$refs.myVueDropzone.manuallyAddFile(file, "http://127.0.0.1:8003/images/menu/items/af4367c60f0b74d6a5328de36be197b6248720bb.png")

				this.form.name = name
				this.form.description = description
				this.form.access_roles = accessRoles
				this.form.categories = menuCaterogyID
				this.form.sling_price = slingPrice
				this.form.vendor_price = vendorPrice
				this.form.quantity = stockQuantity
				this.form.min_quantity = minPurchaseQuantity
				this.form.is_unlimited = isUnlimited
				this.form.measure = measure
				this.form.uom = uom
				this.form.tax_type = taxCode.id
				this.form.mixers = mixerID
				this.form.id = id
				this.form.img_url = imgURL
				this.allerros = []
				//this.show = true
				$('#addNewMenuItemModal').modal('show')
			},
			saveMenuItemCategory(){
				this.category.venue = this.form.venue
				axios.post('/menu-category-item/save',this.category).then((response) => {
     				this.success = true;
					$('#menuCategoryModal').modal('hide')
					axios.get('/admin-menu-category-item/'+this.form.venue.venue.id).then((response) => {
						this.menuItemCategories = response.data
					})
					this.$toastr.s("Success! Category has been saved.");
					this.category.name = ''
					this.category.description = ''
					this.allerros = []
					this.show_second = false
				}).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
               });
			},
			save(){
				axios.post('/menu-items/save',this.form).then((response) => {
     				this.success = true;
     				this.show = false;
					$('#categoryModal').modal('hide')
					this.getMenuItems()
				    this.$toastr.s("Success! Menu Item has been saved.");
					this.form.name = ''
					this.form.description = ''
					this.form.access_roles = []
					this.form.categories = []
					this.form.sling_price = 0
					this.form.vendor_price = 0
					this.form.quantity = 1
					this.form.min_quantity = 1
					this.form.measure = ''
					this.form.uom = ''
					this.form.tax_type = ''
					this.form.mixers = []
					this.allerros = []
					this.form.img_url = ''
					this.show = false
					this.show_second = false

					$('#addNewMenuItemModal').modal('hide')
				})
			},
			removeModal(id){
				this.form.id = id
				$('#archiveModal').modal('show')
			},
			remove(){
				axios.post('/menu-items/delete',this.form).then((response) => {
					this.form.id = ''
					this.getMenuItems()
					$('#archiveModal').modal('hide')
				    this.$toastr.s("Success! Menu Item has been removed.");
				})
			}
		}
	}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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

	.no-padding{
		padding-left:0px;
		padding-right:0px;
	}

	.responsive {
	  width: 50%;
	  height: auto;
	  text-align: center;
	}
</style>