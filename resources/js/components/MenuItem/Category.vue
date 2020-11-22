<template>
	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-md-12">
	            <div class="card">
	                <div class="card-header" style="padding:10px 0px;">
	                	<div class="container-fluid row">
		                	<span class="col-6 pull-left"><h3>Menu Item Category</h3></span>
		                	<span class="col-6">
			                	<button class="btn btn-danger pull-right" @click.prevent="addNewCategory()"><i class="fa fa-plus"></i> Add New</button>
			                </span>
		                </div>
	                </div>

	                <div class="card-body">
					<v-client-table v-if="menuItemCategories" :data="menuItemCategories" :columns="['name','description','date_created','actions']" :options="options">
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
					  	<div class="modal-dialog" role="document">
						    <div class="modal-content">
						      	<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Category</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
						      	</div>
						      	<form class="form">
							      	<div class="modal-body">
							    		<!-- <div class="form-group row">
		                                    <label for="description" class="col-md-4 col-form-label text-md-right">Name</label>

		                                    <div class="col-md-6">
		                                        <input required="" id="contact_number" v-model="category.name" type="text" class="form-control" name="name" value="" autofocus>
		                                    </div>
		                                </div> -->
		                                <div :class="['form-group row', allerros.name ? 'has-error' : '']" >
			                              	<label for="username" class="col-md-3 pull-left col-form-label">Name</label>
				                            <div class="col-md-12">
				                                <input id="name" name="name" value="" :class="allerros.name ? 'is-invalid' : ''" autofocus="autofocus" class="form-control" type="text" v-model="category.name">
				                                <span v-if="allerros.name" :class="['label label-danger']">{{ allerros.name[0] }}</span>
				                            </div>
			                           </div>

		                                <div class="form-group row">
		                                    <label for="username" class="col-md-3 pull-left col-form-label">Description</label>

		                                    <div class="col-md-12">
		                                        <textarea class="form-control" :class="allerros.description ? 'is-invalid' : ''" v-model="category.description" required=""></textarea>
		                                        <span v-if="allerros.description" :class="['label label-danger']">{{ allerros.description[0] }}</span>
		                                    </div>
		                                </div>

							    		
							     	</div>
							      	<div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								        <!-- <button type="button" class="btn btn-primary" @click.prevent="saveMenuItemCategory">Save changes</button> -->
								        <input type="submit" class="btn btn-primary" value="Save" @click.prevent="saveMenuItemCategory()">
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
	export default{
		data(){
			return{
				category: {'id':'','name': '', 'description' : ''},
				menuItemCategories: [],
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
			}
		},
		mounted(){
			this.getMenuItemCategories()


		},
		methods:{
			saveMenuItemCategory(){
				axios.post('/menu-category-item/save',this.category).then((response) => {
     				this.success = true;
					$('#categoryModal').modal('hide')
					this.getMenuItemCategories()
					this.$toastr.s("Success! Category has been added.");
					this.category.name = ''
					this.category.description = ''
					this.allerros = []
				}).catch((error) => {
                    this.allerros = error.response.data.errors;
                    this.success = false;
               });
			},
			getMenuItemCategories(){
				axios.get('/menu-category-item/get').then((response) => {
					this.menuItemCategories = response.data
				})
			},
			addNewCategory(){
				this.category.id = ''
				this.category.name = ''
				this.category.description = ''
				$('#categoryModal').modal('show')
			},
			edit(id,name,description){
				this.category.name = name
				this.category.description = description
				this.category.id = id
				$('#categoryModal').modal('show')
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

	.pull-left{
		float:left;
	}
</style>