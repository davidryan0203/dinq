<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Redeem Coupon</h3></span>
		                	<span class="col-6">
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
						<div class="form-group row">
	                        <label for="description" class="col-md-2">Coupon Code</label>

	                        <div class="row col-12" style="margin-left:2px">
	                            <input type="text" class="form-control col-10" v-model="form.coupon_code" placeholder="enter coupon code">

	                            <button type="submit" class="btn btn-danger col-2" @click.prevent="redeem">
		                            Redeem
		                        </button>
	                        </div>
	                    </div>
					</div>				
            	</div>
	            <div class="card" style="margin-top:20px;">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Waiters</h3></span>
		                	<span class="col-6">                	
			                	<button class="btn btn-danger pull-right" @click.prevent="showWaiter()"><i class="fa fa-plus"></i> Add New Waiter</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<v-client-table v-if="waiters" :data="waiters" :columns="['id','name','username','email','contact_number','status','actions']" :options="options">
						<template slot="status" slot-scope="props">
	             			<span v-if="props.row.is_active == '1'">Active</span>
	             			<span v-else>Inactive</span>
	             		</template>

	             		<template slot="username" slot-scope="props">
	             			
	             			<span>{{props.row.venue_id}}-{{props.row.username}}</span>
	             		</template>

	             		<template slot="actions" slot-scope="props">
	             			<button class="btn btn-primary" @click.prevent="showWaiter(props.row)"><i class="fa fa-pen"></i> Edit</button>
	             			<button class="btn btn-danger" @click.prevent="removeWaiter(props.row)"><i class="fa fa-trash"></i> Remove</button>
	             		</template>
					</v-client-table>

					<div class="modal fade" id="waiterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  	<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Waiter</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
		                                <div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Name</label>
				                            <div class="col-sm-12">
				                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.name">
				                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
				                            </div>
			                           	</div>

		                                <div :class="['form-group row', allerros.username ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Username</label>
				                            <div class="col-sm-12">
				                                <input id="username" name="username" value="" :class="allerros.username ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.username">
				                                <span v-if="allerros.username" :class="['label label-danger']">{{ allerros.username[0] }}</span>
				                            </div>
			                           	</div>

		                                <div :class="['form-group row', allerros.email ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Email</label>
				                            <div class="col-sm-12">
				                                <input id="email" name="email" value="" :class="allerros.email ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="form.email">
				                                <span v-if="allerros.email" :class="['label label-danger']">{{ allerros.email[0] }}</span>
				                            </div>
			                           	</div>

		                                <div :class="['form-group row', allerros.password ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Password</label>
				                            <div class="col-sm-12">
				                                <input id="password" name="password" value="" :class="allerros.password ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="password" v-model="form.password">
				                                <span v-if="allerros.password" :class="['label label-danger']">{{ allerros.password[0] }}</span>
				                            </div>
			                           	</div>

			                           	<div :class="['form-group row', allerros.password_confirmation ? 'has-error' : '']" >
			                              	<label for="description" class="col-md-3 col-form-label text-md-left">Confirm Password</label>
				                            <div class="col-sm-12">
				                                <input id="password_confirmation" name="password_confirmation" value="" :class="allerros.password_confirmation ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="password" v-model="form.password_confirmation">
				                                <span v-if="allerros.password_confirmation" :class="['label label-danger']">{{ allerros.password_confirmation[0] }}</span>
				                            </div>
			                           	</div>

		                                <div :class="['form-group row']" >
			                              	<label for="contact_number" class="col-md-3 pull-left col-form-label">Contact Number</label>
				                            <div class="col-md-12">
				                                <input id="contact_number" name="contact_number" value="" autofocus="autofocus" class="form-control" type="text" v-model="form.contact_number">
				                            </div>
			                           </div>

			                           <div v-if="form.img_url" :class="['form-group row']" >
				                       		<label for="mixerImage" class="col-md-4 col-form-label">&nbsp;</label>
				                            <div class="col-sm-12">

				                				<img :src="form.img_url" class="responsive">
											</div>
				                       	</div>

			                           <div :class="['form-group row']" >
			                           		<label for="mixerImage" class="col-md-3 col-form-label text-md-left">Waiter Profile Image</label>
				                            <div class="col-sm-12">
				                            	<vue-dropzone @vdropzone-file-added="test" ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
											</div>
			                           	</div>
							     	</div>
							      	<div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="saveWaiterData()">
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
    import vue2Dropzone from 'vue2-dropzone'
	export default{
		components: {
			Multiselect,
		  	FormWizard,
		  	TabContent,
		  	vueDropzone: vue2Dropzone 
		},
		data(){
			var self = this
			return{
        		form: {
        			name: '',
        			username: '',
        			email: '',
        			password: '',
        			password_confirmation:'',
        			contact_number: '',
        			'img_url':'',
         		},         		
           		waiters: [],           		
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
			        url: '/waiter/upload',
			        thumbnailWidth: 150,
			        maxFilesize: 5,
			        headers: { "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content },
			        maxFiles: 1,
			        success: function(file, response) 
		            {
		            	console.log(file)
		            	self.form.img_url = file.dataURL
		            }
			    }
			}
		},
		mounted(){
			this.getWaiters()
		},
		methods:{
			getWaiters(){
				axios.get('/get-waiters').then((response) => {
					this.waiters = response.data
				})
			},
			redeem(){
				axios.post('/redeem-coupon',this.form).then((response) => {
					this.form.coupon_code = ''
					if(response.data == 'success'){
						this.$toastr.s(response.data);
					}else{
						this.$toastr.e(response.data);
					}
					
				})
			},
			saveWaiterData(data){
				axios.post('/save-waiter-data',this.form).then((response) => {		
					this.success = true;			
					this.allerros = []
					this.form.name = ''
					this.form.username = ''
					this.form.email = ''
					this.form.password = ''
					this.form.password_confirmation = ''
					this.form.contact_number = ''
					this.form.img_url = ''
					this.form.id = ''
					this.getWaiters();
					$('#waiterModal').modal('hide')
					this.$toastr.s('Waiter Data successfully saved.');
				}).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
               });
			},
			showWaiter(data){
				if(data){
					console.log(data)
					this.form.name = data.name
					this.form.username = data.username
					this.form.email = data.email
					this.form.password = ''
					this.form.password_confirmation = ''
					this.form.contact_number = data.contact_number
					this.form.img_url = data.img_url
					this.form.id = data.id
				}

				if(!data){
					this.form.name = ''
					this.form.username = ''
					this.form.email = ''
					this.form.password = ''
					this.form.password_confirmation = ''
					this.form.contact_number = ''
					this.form.img_url = ''
				}
				$('#waiterModal').modal('show')
			},
			removeTaxRate(data){
				this.form.id = data.id
				axios.post('/remove-tax-rate',this.form).then((response) => {
					this.getWaiters();
					this.$toastr.e('Successfully Removed the Waiter.');
				})
			},
			test(){
				console.log(this.form)
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