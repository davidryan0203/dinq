<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Add-ons</h3></span>
		                	<span class="col-6" style="padding-top:5px;">
			                	<button class="btn btn-danger pull-right" @click.prevent="addNewCategory()"><i class="fa fa-plus"></i> Add New</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<v-client-table v-if="mixerItems" :data="mixerItems" :columns="['name','venue_name','sling_price','is_unlimited','date_created','actions']" :options="options">
						<template slot="actions" slot-scope="props" >
                            <div class="table-button-container text-center">
                                <span class="edit-record" @click.prevent="edit(props.row.id, props.row.name,props.row.stock_quantity,props.row.is_unlimited,props.row.img_url,props.row.sling_price)" data-function="Edit" title="Edit"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" :id="props.row.id"></i>Edit</span>
                            </div>
                        </template>

                        <template slot="is_unlimited" slot-scope="props">
                        	<span v-if="props.row.is_unlimited == '1'">Yes</span>
                        	<span v-if="props.row.is_unlimited == '0'">No</span>
                        </template>

                        <template slot="date_created" slot-scope="props" >
                        	{{props.row.created_at | formatDate}}
                        </template>

                        <template slot="venue_name" slot-scope="props">
                        	<span v-if="userDetails.user_type == '0'">{{props.row.venue.user.name}}</span>
                        	<span v-else>{{props.row.venue.user.name}}</span>
                        </template>

					</v-client-table>

					<div class="modal fade" id="mixerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Add-on</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
							      		<div class="form-group row" v-if="userDetails.user_type == '0'">
				                            <label for="description" class="col-md-4 col-form-label">Select Venue</label>

				                            <div class="col-md-12">
				                                <select class="form-control" v-model="form.venue">
				                                	<option v-for="venue in venues" :value="venue">{{venue.name}}</option>
				                                </select>
				                            </div>
				                        </div>
		                                <div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Name</label>
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
							    			<label for="access_roles" class="col-md-4 col-form-label">Choose Category</label>
							    			<div class="col-md-12">
							    				<div class="row">
							    					<div class="col-md-12">
					                                    <multiselect v-model="form.categories" track-by="id" label="name" placeholder="Select one" :options="menuItemCategories" :allow-empty="false">
														  </multiselect>
													</div>
												</div>
				                            </div>
							    		</div>

			                           	<div :class="['form-group row', allerros.quantity ? 'has-error' : '']" >
			                              	<label for="quantity" class="col-md-3 col-form-label text-md-left">Quantity</label>
				                            <div class="col-sm-12">
				                                <input id="quantity" name="quantity" value="" :class="allerros.quantity ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="number" v-model="form.quantity">
				                                <span v-if="allerros.quantity" :class="['label label-danger']">{{ allerros.quantity[0] }}</span>
				                            </div>
			                           	</div>

							    		<div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="isUnlimited" class="col-md-3 col-form-label text-md-left">Subtract from quantity</label>
				                            <div class="col-sm-12">
				                               <select class="form-control" v-model="form.is_unlimited">
				                                	<option :selected="(form.is_unlimited == '0')" value="0">Yes</option>
				                                	<option :selected="form.is_unlimited == '1'" value="1">No</option>
				                                </select>
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

			                           	<div v-if="form.img_url" :class="['form-group row']" >
				                       		<label for="mixerImage" class="col-md-4 col-form-label">&nbsp;</label>
				                            <div class="col-sm-12">

				                				<img :src="form.img_url" class="responsive">
											</div>
				                       	</div>

			                           	<div :class="['form-group row']" >
			                           		<label for="mixerImage" class="col-md-3 col-form-label text-md-left">Add-on Image</label>
				                            <div class="col-sm-12">
				                            	<vue-dropzone @vdropzone-file-added="test" ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
											</div>
			                           	</div>

							     	</div>
							      	<div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <!-- <button type="button" class="btn btn-primary" @click.prevent="saveMenuItemCategory">Save changes</button> -->
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="saveMixerDetails()">
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
	import Multiselect from 'vue-multiselect'
    
    Vue.use(ClientTable, {}, false, 'bootstrap4');

    import moment from 'moment';
	Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('D MMM Y')
        }
    })

    import vue2Dropzone from 'vue2-dropzone'
    // import 'vue2-dropzone/dist/vue2Dropzone.min.css'
	export default{
		components: {
	        vueDropzone: vue2Dropzone,Multiselect
	    },
		data(){
			var self = this
			return{
				form: {'id':'','name': '', 'is_unlimited' : 0, 'quantity':1,'img_url':'','sling_price': 0,'vendor_price': 0, 'categories' : ''},
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
			    userDetails : {},
			    venue: {},
			    venues: [],
			    menuItemCategories: []
			}
		},
		computed:{
			calculateSlingPrice(){
				this.form.sling_price = (Number(this.form.vendor_price) + Number(this.form.vendor_price * 10 / 100)).toFixed(2)
				return (Number(this.form.vendor_price) + Number(this.form.vendor_price * 10 / 100)).toFixed(2)
			}
		},
		mounted(){
			this.getMixerItems()
			axios.get('/get-user-details').then((response) => {
				console.log(response.data)
				this.userDetails = response.data
			})
			axios.get('/get-all-venues').then((response) => {
				this.venues = response.data
			})
			this.getMenuItemCategories()
		},
		methods:{
			saveMixerDetails(){
				axios.post('/menu/mixer/save',this.form).then((response) => {
     				this.success = true;
					$('#mixerModal').modal('hide')
					this.getMenuItemCategories()
					this.$toastr.s("Success! Mixer has been added.");
					this.form.name = ''
					this.form.description = ''
					this.allerros = []
					this.form.id = ''
					this.form.img_url = ''
					this.form.sling_price = 0
					this.form.is_unlimited = 0
					this.form.quantity = 1
					this.form.categories = ''
					this.getMixerItems()
				}).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
               });
               this.getMixerItems()
			},
			getMixerItems(){
				axios.get('/menu/mixer/get').then((response) => {
					this.mixerItems = response.data
				})
			},
			addNewCategory(){
				this.form.id = ''
				this.form.name = ''
				this.form.description = ''
				$('#mixerModal').modal('show')
			},
			edit(id,name,stockQuantity,isUnlimited,imgURL,slingPrice){
				console.log(imgURL)
				this.form.name = name
				this.form.img_url = imgURL
				this.form.quantity = stockQuantity
				this.form.is_unlimited = isUnlimited
				var file = { size: 123, name: "Icon", type: "image/png" };
				var url = "https://dummyimage.com/600x400/000/fff";
				//this.$refs.myVueDropzone.manuallyAddFile(file, url);

				this.form.sling_price = slingPrice
				this.form.id = id
				$('#mixerModal').modal('show')
			},
			test(){
				console.log(this.form)
			},
			getMenuItemCategories(){
				axios.get('/menu-category-item/get').then((response) => {
					this.menuItemCategories = response.data
				})
			},
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

	.VueTables__search-field{
		float: right
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